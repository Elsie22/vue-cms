<?php

$config		= array(
	##数据库配置
	'dbhost'		=> 'localhost',	//数据库地址
	'dbname'		=> 'test',		//数据库名
	'dbport'		=> '3306',			//数据库端口
	'dbuser'		=> 'root',			//数据库用户名
	'dbpass'		=> '123456',	//数据库密码
	//'isonlyopenid'	=> false,			//是否静默方式只获取用户opendid（true，false；）
	'debug'			=> true,			//是否开启debug模式
);

##根据链接分配公众号授权
/*if($_SERVER['HTTP_HOST'] == 'www.yuxinzhilian.com'){
	#雨欣智联
	$config['appid']	= "wx2f4c14f5cfa6914c";
	$config['secret']	= "21fcf68dbec5cbf5262a2c7ab872397c";
}elseif($_SERVER['HTTP_HOST'] == 'www.h5see.cn'){
	##智联游戏中心
	$config['appid']	= "wx17c706dc48f9e699";
	$config['secret']	= "5c289048df2433d0653de2b10ffd5dd6";
}*/


return $config;