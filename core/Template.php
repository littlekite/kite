<?php
namespace core;
class Template{
    protected $data = array();
    public function display($moudel,$action){
        if(is_file(__DIR__."/project/$action/$action.html")){
            $c = file_get_contents(__DIR__."/project/$action/$action.html");
            $run_name = "$action/$action";
            $this->parse($c,'runtime/'.md5($run_name));
            $this->read('runtime/'.md5($run_name));
        }else{
            throw new \Exception('template is not found!');
        }  
    }
    public function assign($name,$value){
        $this->data[$name] = $value;
    }
    //解析模板标签
    public function parse(&$c,$path){
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
        $this->write($path,$c);
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