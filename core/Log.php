<?php
namespace core;
class Log
{
    // 日志信息
   public static  $log = [];
   public static  $config = [
        'time_format' => ' c ',
        'file_size'   => 2097152,
        'path'        => LOG_PATH,
        'apart_level' => [],
    ];
    
    /**
     * 记录调试信息
     * @param mixed  $msg  调试信息
     * @param string $type 信息类型
     * @return void
     */
    public static function record($msg, $type = 'log')
    {
        self::$log[$type][] = $msg;
    }
    //日志读取
    public static function getRecord($type = 'return')
    {
          foreach (self::$log as $t => $val) {
                if ($t == $type) {
                    foreach ($val as $msg) {
                        if (!is_string($msg)) {
                            $msg = var_export($msg, true);
                        }
                    }
                    return  $msg;
                }  
          }  
    }
    /**
     * 日志写入接口
     * @access public
     * @param array $log 日志信息
     * @return bool
     */
   public static function save()
    { 
        $now         = date(self::$config['time_format']);
        $destination = self::$config['path'] . date('Ym') . DS . date('d') . '.log';

        $path = dirname($destination);
        !is_dir($path) && mkdir($path, 0755, true);

        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file($destination) && floor(self::$config['file_size']) <= filesize($destination)) {
            rename($destination, dirname($destination) . DS . $_SERVER['REQUEST_TIME'] . '-' . basename($destination));
        }

        // 获取基本信息
        $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $runtime    = number_format(microtime(true) - SERVER_START_TIME, 10);
        $reqs       = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
        $time_str   = ' [运行时间：' . number_format($runtime, 6) . 's][吞吐率：' . $reqs . 'req/s]';
        $memory_use = number_format((memory_get_usage() - SERVER_START_MEM) / 1024, 2);
        $memory_str = ' [内存消耗：' . $memory_use . 'kb]';
        $file_load  = ' [文件加载：' . count(get_included_files()) . ']';

        $info   = '[ log ] ' . $current_uri . $time_str . $memory_str . $file_load . "\r\n" . var_export(get_included_files(), true) . "\r\n";
        $server = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '0.0.0.0';
        $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
        $uri    = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        
        foreach (self::$log as $type => $val) {
            $level = '';
            foreach ($val as $msg) {
                if (!is_string($msg)) {
                    $msg = var_export($msg, true);
                }
                $level .= '[ ' . $type . ' ] ' . $msg . "\r\n";
            }
            if (in_array($type, self::$config['apart_level'])) {
                // 独立记录的日志级别
                $filename = $path . DS . date('d') . '_' . $type . '.log';
                error_log("[{$now}] {$server} {$remote} {$method} {$uri}\r\n{$level}\r\n---------------------------------------------------------------\r\n", 3, $filename);
            } else {
                $info .= $level;
            }
        }
        return error_log("[{$now}] {$server} {$remote} {$method} {$uri}\r\n{$info}\r\n---------------------------------------------------------------\r\n", 3, $destination);
    }
}