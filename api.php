<?php

session_start();

error_reporting(E_ERROR);
date_default_timezone_set('Asia/Chongqing');
include './php/function.php';
include './php/database.class.php';
$config=include './php/config.php';
global $Db; 
$Db=new database($config);

$openid = $_SESSION['openid'];
$ctime = date('Y-m-d H:i:s');

header('Access-Control-Allow-Origin:*');

$type=$_REQUEST['a']?:'start';

try{
//获取首页轮播图里列表
  if ($type == 'getSwipeList') {
    $res = $Db->getAll("select * from cms_swipe_home");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('list'=>$res));
  }

//获取新闻列表
  if ($type == 'getNewsList') {
    $res = $Db->getAll("select * from cms_newslist");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('list'=>$res));
  }

//获取新闻详情
  if ($type == 'getNewsInfo') {
    $id = $_REQUEST['id'];
    $res = $Db->getOne("select * from cms_newslist where id = '$id'");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('newsinfo'=>$res));
  }

//获取资讯评论
  if ($type == 'getNewsCmt') {
    $id = $_REQUEST['id'];
    $pageIndex = $_REQUEST['pageIndex'];
    $length = 10;
    $start = ($pageIndex-1) * $length;
    $res = $Db->getAll("select * from cms_cmmt where newsid = $id order by add_time DESC limit $start, $length");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('cmtlist'=>$res));
  }

//提交评论
  if ($type == 'submitCmt') {
    $id = $_REQUEST['id'];
    $content = $_REQUEST['content'];
    $res = $Db->add('cms_cmmt', array('newsid'=>$id, 'content'=>$content, 'add_time'=>Date('Y-m-d H:i:s')));
    if (!$res) {
      showerr('提交失败');
    }
    showsuc('提交成功');
  }

//获取图片分类
  if ($type == 'getCategory') {
    $res = $Db->getAll("select * from cms_photo_category");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('categories'=>$res));
  }

//获取当前分类下图片列表
  if ($type == 'getPhotosByCate') {
    $id = $_REQUEST['id'];
    if (!$id) {
      $res = $Db->getAll("select * from cms_photos");
    }else{
      $res = $Db->getAll("select * from cms_photos where cateid=$id");
    }
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('photolist'=>$res));
  }

//获取图片详情
  if ($type == 'getPhotoInfo') {
    $id = $_REQUEST['id'];
    $res = $Db->getOne("select * from cms_photos where id = $id");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('photoinfo'=>$res));
  }

//获取缩略图
  if ($type == 'getPhotoImgs') {
    $id = $_REQUEST['id'];
    $res = $Db->getAll("select * from cms_photo_imgs where photoid = $id");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('photoimgs'=>$res));
  }

//获取商品列表
  if ($type == 'getGoodsList') {
    $pageIndex = $_REQUEST['pageIndex'];
    $length = 4;
    $start = ($pageIndex-1) * $length;
    $res = $Db->getAll("select * from cms_goods limit $start,$length");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('goodsList'=>$res));
  }

//获取商品详情
  if ($type == 'getGoodsInfo') {
    $id = $_REQUEST['id'];
    $res = $Db->getOne("select * from cms_goods where id = $id");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('goodsinfo'=>$res));
  }

//获取商品图文介绍
  if ($type == 'getGoodsDetail') {
    $id = $_REQUEST['id'];
    $res = $Db->getOne("select title, content from cms_goods where id = $id");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('goodsdetail'=>$res));
  }
  
//获取购物车里面的商品的信息
  if ($type == 'getCtGdsInfo') {
    $idArr = $_REQUEST['idarr'];
    $res = $Db->getAll("select * from cms_goods where id in($idArr)");
    if (!$res) {
      showerr('没有数据');
    }
    showsuc('获取成功',array('gdsInfo'=>$res));
  }

//新增
  if ($type == 'add') {
    $name = $_POST['name'];
    if (!$name) {
      showerr('品牌名为空');
    }
    $res = $Db->add('vue_brand',array('name'=>$name, 'ctime'=>$ctime));
    if ($res) {
      showsuc('添加成功');
    }
  }

//删除
  if ($type == 'del') {
    $id = $_REQUEST['id'];
    if (!$id) {
      showerr('ID为空');
    }
    $res = $Db->delete('vue_brand', $where ="id='$id'");
    if ($res) {
      showsuc('删除成功');
    }
  }


//登录
  if ($type == 'login') {
	 var_dump($_SESSION);
    $phone = $_REQUEST['phone'];  //手机号
    $smscode = $_REQUEST['smscode'];
    if ($phone != $_SESSION['phone']) {
      showerr('手机号不正确');
    }elseif ($_SESSION['expiretime'] < time()) {
      unset($_SESSION['expiretime']);
      unset($_SESSION['smscode']);
      showerr('验证码已过期');
    }elseif ($smscode != $_SESSION['smscode']) {
      showerr('验证码错误');
    }else{
      $res = $Db->getOne(" select * from Aug_vw_user where openid = '$openid' ");
      $Db->update('Aug_vw_user',array('phone'=>$phone, 'create_time'=>$create_time)," openid='$openid' ");
      showsuc('登录成功');
    }
  }

//提交问卷
    if ($type == 'submit') {
      $sex = $_REQUEST['sex'];  //性别，1表示男，2表示女
      $area = $_REQUEST['area'];  //地区
      $num = $_REQUEST['num'];  //数量
      $like = $_REQUEST['like'];  //喜欢的车型
      //$res = $Db->getOne(" select * from Aug_vw_user where openid='$openid' ");
      if (!$sex) {
        showerr('性别不能为空');
      }elseif (!$area) {
        showerr('地区不能为空');
      }elseif (!$num) {
        showerr('数量不能为空');
      }elseif (!$like) {
        showerr('喜欢的车型不能为空');
      }else{
        $Db->update('Aug_vw_user',array('sex'=>$sex, 'area'=>$area, 'num'=>$num, 'like'=>$like, 'create_time'=>$create_time)," openid='$openid' ");
        showsuc('记录成功');
      }    
    }

}catch (Exception $e){
	showerr($e->getMessage());
}
?>