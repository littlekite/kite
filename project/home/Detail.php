<?php
namespace project\home;
use core\Template;
use core\Db;
use core\tpcl\ComFun\ComFun;
class Detail{
    public function detail(){
        $temp = new Template();
        //读取数据库
        $path_info = ltrim($_SERVER['PATH_INFO'], '/');
        $path = explode('/', $path_info);
        if (is_numeric($path[0])){
            $article = Db::query("SELECT id, title, keywords, description, rele_type  FROM k_article WHERE id = $path[0] LIMIT 1");
            switch ($article[0]['rele_type']){ 
            	case 1:
            	break;
            	case 2:
                $article_c_list = Db::query("SELECT h.* FROM k_headpic_rele AS hr LEFT JOIN k_headpic AS h ON hr.headpic_id = h.id WHERE hr.source_id = ".$article[0]['id']);
            	$article[0]['c_list'] = $article_c_list;
                break;
            	case 3:
				$article_c_list = Db::query("SELECT h.* FROM k_expresstion_rele AS hr LEFT JOIN k_expresstion AS h ON hr.expresstion_id = h.id WHERE hr.source_id = ".$article[0]['id']);
                foreach($article_c_list as $k=>$r) {
                    $img_info = getimagesize(APP_PATH.$r['expresstion']);
                    $w = $img_info[0];
                    $h = $img_info[1];
                    if ($w > $h) {
                        $bilv = round($h/$w,2);
                        if ($w>150) {
                            $w = 150;
                            $h = $w*$bilv;
                        }
                    } else {
                        $bilv = round($w/$h,2);
                        if ($h>150) {
                            $h = 150;
                            $w = $h*$bilv;
                        }   
                    }
                    $article_c_list[$k]['w'] = $w;
                    $article_c_list[$k]['h'] = $h;
                }
                $article[0]['c_list'] = $article_c_list;
            	break;
            	default :
            }
            $temp->assign('article', current($article));
            //$temp->assign('cover', $cover);
            $temp->display('detail');
        }
    }	   
}