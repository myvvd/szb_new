<?php

namespace app\home\controller;

use app\common\controller\HomeBase;
use think\Db;

class Index extends HomeBase
{
  public function index()
  {

  	$cate = Db::name('category')
            ->order('sort ASC')
            ->field('id,title,create_time,ftitle')
        ->where('status',1)
            ->select();
            
//     dump($cate);die;
    $this->assign('cate', $cate);

    $listcate = Db::name('cate')
            ->where('status = 0')
            ->order('sort ASC')
            ->select();

    foreach ($listcate as &$v){
        if ($v['cateid'] == 9){
            $subcate = Db::name('cate')->where('pid',$v['id'])->field('title')->order('id')->select();
            $v['catestr'] = $subcate;
            $str = '';
            foreach ($subcate as &$val){
                $str .= $val['title'].',';
            }
            $str = substr($str,0,-1);
            $v['subcate'] = $str;
        }

    }
//    dump($listcate);die;
    $this->assign('listcate', $listcate);
    return $this->fetch();
  }
}
