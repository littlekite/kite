<?php
namespace core;
use PDO;
use PDOStatement;
use core\Log;
class Db
{
    //  数据库连接实例
    private static $instance = null;
    // 当前的SQL指令
    protected $queryStr = '';
    
    /** @var PDOStatement PDO操作实例 */
    private $PDOStatement;
    
    private $linkID;
    
    // 返回或者影响记录数
    private $numRows = 0;
    
    private static $queryType;
    
    private $resultSetType = 'array';
    // 查询结果类型
    private $fetchType = PDO::FETCH_ASSOC;
    // PDO连接参数
    private $params = [
        PDO::ATTR_CASE              => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES  => false,
    ];
    public static function connect()
    {
        if (empty(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }
    public static function __callStatic($method, $params)
    {
        // 自动初始化数据库
        if($method == 'query'){
            $method = 'querySql';
            self::$queryType = 'select';
        }
        if($method == 'execute'){
            $method = 'querySql';
            self::$queryType = 'execute';
        }
        if($method == 'getId'){
            $method = 'getLastInsID';
        }
        return call_user_func_array([self::connect(), $method], $params);
    }
    /**
     * 初始化数据库连接
     * @access protected
     * @param boolean $master 是否主服务器
     * @return void
     */
    protected function initConnect($master = true)
    {
        if (!$this->linkID) {
            // 默认单数据库
            $this->linkID = $this->connectDb();
        }
    }
     /**
     * 解析pdo连接的dsn信息
     * @access protected
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config)
    {
        $dsn = 'mysql:dbname=' . $config['database'] . ';host=' . $config['hostname'];
        if (!empty($config['hostport'])) {
            $dsn .= ';port=' . $config['hostport'];
        } elseif (!empty($config['socket'])) {
            $dsn .= ';unix_socket=' . $config['socket'];
        }
        if (!empty($config['charset'])) {
            $dsn .= ';charset=' . $config['charset'];
        }
        return $dsn;
    }
    /**
     * 连接数据库方法
     * @access public
     * @param array         $config 连接参数
     * @param integer       $linkNum 连接序号
     * @param array|bool    $autoConnection 是否自动连接主数据库（用于分布式）
     * @return PDO
     * @throws Exception
     */
    public function connectDb(array $config = [], $linkNum = 0, $autoConnection = false)
    {
        if (!isset($this->links[$linkNum])) {
            $config  = require 'Config.php';
            // 连接参数
            if (isset($config['params']) && is_array($config['params'])) {
                $params = $config['params'] + $this->params;
            } else {
                $params = $this->params;
            }
            // 记录当前字段属性大小写设置
            $this->attrCase = $params[PDO::ATTR_CASE];
            // 记录数据集返回类型
            if (isset($config['resultset_type'])) {
                $this->resultSetType = $config['resultset_type'];
            }
            try {
                if (empty($config['dsn'])) {
                    $config['dsn'] = $this->parseDsn($config);
                }
                if ($config['debug']) {
                    $startTime = microtime(true);
                }
                $this->links[$linkNum] = new PDO($config['dsn'], $config['username'], $config['password'], $params);
            } catch (\PDOException $e) {
                if ($autoConnection) {
                    return $this->connect($autoConnection, $linkNum);
                } else {
                    throw $e;
                }
            }
        }
        return $this->links[$linkNum];
    }
    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str SQL字符串
     * @param bool   $master 是否主库查询
     * @return string
     */
    public function quote($str, $master = true)
    {
        $this->initConnect($master);
        return $this->linkID ? $this->linkID->quote($str) : $str;
    }
    /**
     * 根据参数绑定组装最终的SQL语句 便于调试
     * @access public
     * @param string    $sql 带参数绑定的sql语句
     * @param array     $bind 参数绑定列表
     * @return string
     */
    public function getRealSql($sql, array $bind = [])
    {
        if ($bind) {
            foreach ($bind as $key => $val) {
                $val = $this->quote(is_array($val) ? $val[0] : $val);
                // 判断占位符
                $sql = is_numeric($key) ?
                substr_replace($sql, $val, strpos($sql, '?'), 1) :
                str_replace(
                    [':' . $key . ')', ':' . $key . ',', ':' . $key . ' '],
                    [$val . ')', $val . ',', $val . ' '],
                    $sql . ' ');
            }
        }
        return $sql;
    }
    /**
     * 参数绑定
     * 支持 ['name'=>'value','id'=>123] 对应命名占位符
     * 或者 ['value',123] 对应问号占位符
     * @access public
     * @param array $bind 要绑定的参数列表
     * @return void
     * @throws \server\Exception
     */
    protected function bindValue(array $bind = [])
    {
        foreach ($bind as $key => $val) {
            // 占位符
            $param = is_numeric($key) ? $key + 1 : ':' . $key;
            if (is_array($val)) {
                $result = $this->PDOStatement->bindValue($param, $val[0], $val[1]);
            } else {
                $result = $this->PDOStatement->bindValue($param, $val);
            }
            if (!$result) {
                throw new \Exception("Error occurred  when binding parameters '{$param}'");
            }
        }
    }
    /**
     * 获得数据集
     * @access protected
     * @param bool          $procedure 是否存储过程
     * @return mixed
     */
    protected function getResult($procedure = false)
    {
        if ($procedure) {
            // 存储过程返回结果
            //return $this->procedure();
        }
        $result        = $this->PDOStatement->fetchAll($this->fetchType);
        $this->numRows = count($result);
        return $result;
    }
    /**
     * 释放查询结果
     * @access public
     */
    public function free()
    {
        $this->PDOStatement = null;
    }
     /**
     * 获取最近插入的ID
     * @access public
     * @param string  $sequence     自增序列名
     * @return string
     */
    public function getLastInsID($sequence = null)
    {
        $this->linkID = $this->connectDb();
        return $this->linkID->lastInsertId($sequence);
    }
    /**
     * 执行查询 返回数据集
     * @access public
     * @param string        $sql sql指令
     * @param array         $bind 参数绑定
     * @param boolean       $master 是否在主服务器读操作
     * @return mixed
     * @throws BindParamException
     * @throws PDOException
     */
    public function querySql($sql, $bind = [], $master = false)
    {
        $this->initConnect($master);
        if (!$this->linkID) {
            return false;
        }
        // 根据参数绑定组装最终的SQL语句
        $this->queryStr = $this->getRealSql($sql, $bind);
        //释放前次的查询结果
        if (!empty($this->PDOStatement)) {
            $this->free();
        }
        try { 
            //debug 模式 SQL性能分析
            if ( KITE_DEBUG && 0 === stripos(trim($sql), 'select')) {
                $this->getExplain($this->queryStr);
            }
            // 预处理
            $this->PDOStatement = $this->linkID->prepare($sql);
            // 参数绑定
            $this->bindValue($bind);
            // 执行查询
            $result = $this->PDOStatement->execute();
            //检测sql的类型 如果是查询语句则返回结果集  执行语句返回受影响的行数
            if(self::$queryType == "select"){
                $procedure = in_array(strtolower(substr(trim($sql), 0, 4)), ['call', 'exec']);
                return $this->getResult($procedure);
            } else if(self::$queryType == "execute"){
                $this->numRows = $this->PDOStatement->rowCount();
                return $this->numRows;
            } else {
                throw new \Exception('wrong query!');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * SQL性能分析
     * @access protected
     * @param string $sql
     * @return array
     */
    protected function getExplain($sql)
    {
        $result = $this->querySql("EXPLAIN " . $sql);
        $result = array_change_key_case($result[0]);
        if (isset($result['extra'])) {
            if (strpos($result['extra'], 'filesort') || strpos($result['extra'], 'temporary')) {
                Log::record('SQL:' . $this->queryStr . '[' . $result['extra'] . ']', 'warn');
            }
        }
        Log::record('[ EXPLAIN : ' . var_export($result, true) . ' ]', 'sql');
    }
}