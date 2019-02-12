<?php
class WeixinAction{
	
	private $appid ;
	private $secret;

	
	public function __construct($config,$db){
		$this->appid = $config['appid'];
		$this->secret = $config['secret'];
		$this->isonlyopenid=$config['isonlyopenid'];
		$this->db=$db;
	}
	
	public function _getAccessToken(){
		//判断session中是否存在
		if($_SESSION['WX_ACCESS_TOKEN']&&$_SESSION['WX_JSAPI_TICKET']&&($_SESSION['WX_CREATE_TIME']+$_SESSION['WX_EXPIRES_IN']>time())){
			//存在值，直接返回
	
		}else{
			//session中没有值，读取数据库
			//判断access_token是否失效
			//$arr=M("access")->find();
			$sql = "select * from access where appid='$this->appid' order by id desc limit 1";
			$arr1 = $this->db->getAll($sql);
			if($arr1[0]['create_time']+$arr1[0]['expires_in']>time()){
				$arr=$arr1[0];
			}else{
			    echo 11;
                $curl = curl_init();
                //设置抓取的url
                $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret;
                curl_setopt($curl, CURLOPT_URL, $url);
                //设置获取的信息以文件流的形式返回，而不是直接输出。
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                //执行命令
                $rs1 = curl_exec($curl);
                //关闭URL请求
                curl_close($curl);
				$arr=json_decode($rs1,true);
//				var_dump($arr);
//				var_dump($rs1);die;
				if($arr['access_token']){
                    $curl1 = curl_init();
                    //设置抓取的url
                    $url1='https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$arr['access_token'].'&type=jsapi';
                    curl_setopt($curl1, CURLOPT_URL, $url1);
                    //设置获取的信息以文件流的形式返回，而不是直接输出。
                    curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
                    //执行命令
                    $rs2 = curl_exec($curl1);
                    //关闭URL请求
                    curl_close($curl1);
					$arr2=json_decode($rs2,true);
					if($arr2['errcode']==0){
						$create_time=time();
						$ticket=$arr2['ticket'];
						$access_token = $arr['access_token'];
						$expires_in = $arr['expires_in'];
						if($arr1[0]['appid']){
							$sql = "update access set access_token='$access_token',ticket='$ticket',create_time='$create_time',expires_in='$expires_in' where appid='{$this->appid}'";
						}else{
							$sql = "insert into  access (access_token,ticket,create_time,expires_in,appid) values('$access_token','$ticket','$create_time','$expires_in','{$this->appid}')";													
						}
						//echo $sql;
						$d = $this->db->execute($sql);
						if($d){
	
						}else{
							exit("ERROR0:很抱歉，页面已失效！");
						}
						
					}else{
						exit("ERROR1:很抱歉，页面已失效！");
					}
				}else{
					exit("ERROR2:很抱歉，页面已失效！");
				}
			}
			$_SESSION['WX_ACCESS_TOKEN'] = $arr['access_token'];
			$_SESSION['WX_CREATE_TIME'] = $arr['create_time'];
			$_SESSION['WX_EXPIRES_IN'] = $arr['expires_in'];
			$_SESSION['WX_JSAPI_TICKET'] = $arr['ticket'];
		}
	}
	
	//重定向获取微信用户code
	public function _getWeixinCode(){
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?';
		$url.='appid='.$this->appid;
		$url.='&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$url.='&response_type=code';
		if($this->isonlyopenid){
			$url.='&scope=snsapi_base';
		}else{
			$url.='&scope=snsapi_userinfo';
		}
		$url.='&state=STATE#wechat_redirect';
		header('location:'.$url);
		exit();
	}
	
	//根据用户code获取用户信息
	public function _getWeixinUserInfo($code){
        $curl = curl_init();
        //设置抓取的url
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $rs = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
		$arr=json_decode($rs,true);


		if($arr['openid']){
			$_SESSION['openid']=$arr['openid'];
		}
        $curl1 = curl_init();
        //设置抓取的url
        $url1='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
        curl_setopt($curl1, CURLOPT_URL, $url1);
        //设置头文件的信息作为数据流输出
        //curl_setopt($curl1, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $rs1 = curl_exec($curl1);
        //关闭URL请求
        curl_close($curl1);
		$userinfo = json_decode($rs1,true);
		return $userinfo;
	}

}


















?>