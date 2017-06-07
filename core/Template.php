<?php
namespace core;
class Template{
    protected $data = array();
    //渲染模板
    public function display($moudel,$action){
        if(is_file(__DIR__."/project/$action/$action.html")){
            $c = file_get_contents(__DIR__."/project/$action/$action.html");
            $run_name = "$action/$action";
            $this->parseTag($c);//表达式解析
            $this->parse($c);//变量解析
            //判断缓存文件是否需要更新
            $path = 'runtime/'.md5($run_name);
            if(is_file( $path)){
                $handle = @fopen( $path, "r");
                // 读取第一行
                preg_match('/\/\*(.+?)\*\//', fgets($handle), $matches);
                if (!isset($matches[1])) {
                    $this->write($path,$c);
                }
            } else {
                $this->write($path,$c);
            }
            $this->read('runtime/'.md5($run_name));
        }else{
            throw new \Exception('template is not found!');
        }  
    }
    public function assign($name,$value){
        $this->data[$name] = $value;
    }
    //解析模板表达式标签
    public function parseTag(&$c){
        $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'if'         => ['attr' => 'condition', 'expression' => true]
        ];
        foreach ($tags as $name => $val) {
            $close                      = !isset($val['close']) || $val['close'] ? 1 : 0;
            $tags[$close][$name] = $name;
        }
        // 闭合标签
        if (!empty($tags[1])) {
            $nodes = [];
            $tags_s = array_keys($tags[1]);
            $tagName = is_array($tags_s) ? implode('|', $tags_s) : $tags_s;
            $regex = '/{(?:(' . $tagName . ')\b(?>[^}]*)|\/(' . $tagName . '))}/is';
            if (preg_match_all($regex, $c, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
                $right = [];
                foreach ($matches as $match) {
                    print_r($match);
                    if ('' == $match[1][0]) {
                        $name = strtolower($match[2][0]);
                        // 如果有没闭合的标签头则取出最后一个
                        if (!empty($right[$name])) {
                            // $match[0][1]为标签结束符在模板中的位置
                            $nodes[$match[0][1]] = [
                                'name'  => $name,
                                'begin' => array_pop($right[$name]), // 标签开始符
                                'end'   => $match[0], // 标签结束符
                            ];
                        }
                    } else {
                        // 标签头压入栈
                        $right[strtolower($match[1][0])][] = $match[0];
                    }
                }
                unset($right, $matches);
                // 按标签在模板中的位置从后向前排序
                krsort($nodes);
            }
            $break = '<!--###break###--!>';
            if ($nodes) {
                $beginArray = [];
                // 标签替换 从后向前
                foreach ($nodes as $pos => $node) {
                    // 对应的标签名
                    $name  = $tags[1][$node['name']];
                    // 解析标签属性
                    $attrs  = $this->parseAttr($node['begin'][0], $name, '',$tags);
                    $method = 'tag' . $name;
                    // 读取标签库中对应的标签内容 replace[0]用来替换标签头，replace[1]用来替换标签尾
                    $replace = explode($break, $this->$method($attrs, $break));
                    if (count($replace) > 1) {
                        while ($beginArray) {
                            $begin = end($beginArray);
                            // 判断当前标签尾的位置是否在栈中最后一个标签头的后面，是则为子标签
                            if ($node['end'][1] > $begin['pos']) {
                                break;
                            } else {
                                // 不为子标签时，取出栈中最后一个标签头
                                $begin = array_pop($beginArray);
                                // 替换标签头部
                                $c = substr_replace($c, $begin['str'], $begin['pos'], $begin['len']);
                            }
                        }
                        // 替换标签尾部
                        $c= substr_replace($c, $replace[1], $node['end'][1], strlen($node['end'][0]));
                        // 把标签头压入栈
                        $beginArray[] = ['pos' => $node['begin'][1], 'len' => strlen($node['begin'][0]), 'str' => $replace[0]];
                    }
                }
                while ($beginArray) {
                    $begin = array_pop($beginArray);
                    // 替换标签头部
                    $c = substr_replace($c, $begin['str'], $begin['pos'], $begin['len']);
                }
            }
        }
        return;
    }
     /**
     * 分析标签属性 正则方式
     * @access public
     * @param string $str 标签属性字符串
     * @param string $name 标签名
     * @param string $alias 别名
     * @return array
     */
    public function parseAttr($str, $name, $alias = '',$tags)
    {
         
        $regex  = '/\s+(?>(?P<name>[\w-]+)\s*)=(?>\s*)([\"\'])(?P<value>(?:(?!\\2).)*)\\2/is';
        $result = [];
        if (preg_match_all($regex, $str, $matches)) {
            foreach ($matches['name'] as $key => $val) {
                $result[$val] = $matches['value'][$key];
            }
            if (isset($tags[$name])) {
                $tag = $tags[$name];
            }
        }
        return $result;
    }
    /**
     * if标签解析
     * 格式：
     * {if condition=" $a eq 1"}
     * {elseif condition="$a eq 2" /}
     * {else /}
     * {/if}
     * 表达式支持 eq neq gt egt lt elt == > >= < <= or and || &&
     * @access public
     * @param array $tag 标签属性
     * @param string $content 标签内容
     * @return string
     */
    public function tagIf($tag, $content)
    {
        $parseStr  = '<?php if(' . $tag['condition'] . '): ?>' . $content . '<?php endif; ?>';
        return $parseStr;
    }
    //解析模板变量标签
    public function parse(&$c){
        $regex =  '/{((?:[\$]{1,2}[a-wA-w_]|[\:\~][\$a-wA-w_]|[+]{2}[\$][a-wA-w_]|[-]{2}[\$][a-wA-w_]|\/[\*\/])(?>(?:(?!}).)*))}/is';
        if (preg_match_all($regex, $c, $matches, PREG_SET_ORDER)) {
              foreach ($matches as $match) {
                $flag = substr($match[1], 0, 1);
                if($flag == "$"){
                    $match[1] = '<?php echo ' . $match[1]. '; ?>';
                }
                $c = str_replace($match[0], $match[1], $c);
              }
        }
        return;
    }
    public function write($cacheFile, $content)
    {
        // 检测模板目录
        $dir = dirname($cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        // 生成模板缓存文件
        if (false === file_put_contents($cacheFile, $content)) {
            throw new Exception('cache write error:' . $cacheFile, 11602);
        }
    }
    public function read($cacheFile)
    {
        $vars = $this->data;
        if (!empty($vars) && is_array($vars)) {
            // 模板阵列变量分解成为独立变量
            extract($vars, EXTR_OVERWRITE);
        }
        //载入模版缓存文件
        include $cacheFile;
    }
}
?>