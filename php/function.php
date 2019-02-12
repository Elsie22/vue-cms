<?php
/**
 * 显示错误
 * @param unknown $msg
 */
function showerr($msg,$data=''){
	global $Db;
	if($Db){
		$Db->close();
	}
	ajaxReturn(array('error'=>1,'info'=>$msg?:'未知错误','data'=>$data,'a'=>$_REQUEST['a']));
}
/**
 * 显示成功
 */
function showsuc($msg,$data=''){
	global $Db;
	if($Db){
		$Db->close();
	}
	ajaxReturn(array('error'=>0,'info'=>$msg?:'操作成功','data'=>$data,'a'=>$_REQUEST['a']));
}

/**
 * 显示成功
 */
function showSucBase($msg,$data=''){
	global $Db;
	if($Db){
		$Db->close();
	}
	ajaxReturn(array('error'=>0,'info'=>$msg?:'操作成功','base'=>$data,'a'=>$_REQUEST['a']));
}

/**
 * ajax返回数据,返回json数据，并终止程序.汉字不编码/u
 */
function ajaxReturn($data){
	header('Content-Type:application/json; charset=utf-8');
	echo json_encode($data);
	exit();
}

/**
 * 测试用，打印数据
 */
function printp($data,$flag = 1){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	$flag ? die() : '';
}


////////////////////////安全过滤////////////////////////////////
if($_REQUEST){
	foreach ($_REQUEST as $k=>$v){
		$_REQUEST[$k]=strip_tags($v);
		$keyword = 'select|insert|update|delete|union|into|load_file|outfile|sleep| or ';
// 		$arr = explode( '|', $keyword );
		$v = str_ireplace( $arr, '', $v );
// 		$v=str_replace("'", '‘', $v);
		$v=str_replace('"', '“', $v);
// 		$v=str_replace('/', '', $v);
		$_REQUEST[$k]=strip_tags($v);
	}
}
////////////////////////过滤结束////////////////////////////////

function removeEmoji($nickname) {

	// Match Emoticons
	$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
	$clean_text = preg_replace($regexEmoticons, '', $nickname);

	// Match Miscellaneous Symbols and Pictographs
	$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
	$clean_text = preg_replace($regexSymbols, '', $clean_text);

	// Match Transport And Map Symbols
	$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
	$clean_text = preg_replace($regexTransport, '', $clean_text);

	// Match Miscellaneous Symbols
	$regexMisc = '/[\x{2600}-\x{26FF}]/u';
	$clean_text = preg_replace($regexMisc, '', $clean_text);

	// Match Dingbats
	$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
	$clean_text = preg_replace($regexDingbats, '', $clean_text);

	return $clean_text;
}

/**
 * 防止修改数据
 *
 * @param mid       加密的md5字符串 - md5($value . $tid . 'vy888hy')
 * @param tid       时间戳
 * @param value     防修改的值(如：分数，或者其它值)
 */
function verifyMd5($mid, $tid, $value)
{
    if($mid != md5($value . $tid . 'vy888hy')){
        return false;
    }

    return true;
}

/**
 * 验证手机号是否正确
 * 
 * @param number $mobile    手机号码
 * @return bool
 */
function is_mobile($mobile)
{
    return preg_match("/^1[34578]{1}\d{9}$/", $mobile) ? true: false;
}

/**
 * 验证身份证号
 * 
 * @param string  $vStr     身份证号码
 * @return bool
 */
function is_credit_no($vStr)
{
    $vCity = array('11', '12', '13', '14', '15', '21', '22', '23', '31', '32', '33', '34', '35', '36', '37', '41', '42', '43', '44', '45', '46', '50', '51', '52', '53', '54', '61', '62', '63', '64', '65', '71', '81', '82', '91');
    
    if ( ! preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr))
        return false;
    
    if ( ! in_array(substr($vStr, 0, 2), $vCity))
        return false;
    
    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);
    
    if ($vLength == 18) {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }
    
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday)
        return false;
    if ($vLength == 18) {
        $vSum = 0;
        
        for ($i = 17; $i >= 0; $i -- ) {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10: intval($vSubStr, 11));
        }
        
        if ($vSum % 11 != 1)
            return false;
    }
    
    return true;
}
