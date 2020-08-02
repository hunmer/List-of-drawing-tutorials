<?php
	header('Access-Control-Allow-Origin: *');
	if(!file_exists('like.json')){
		$json = [];
	}else{
		$json = json_decode(file_get_contents('like.json'), true);
	}
	$ip = getIp();
	switch($_POST['s']){

		case '0':
			if(isset($json[$ip])){
				unset($json[$ip]);
				file_put_contents('like.json', json_encode($json));
			}
			break;

		case '1':
			if(!isset($json[$ip])){
				date_default_timezone_set('Asia/ShangHai');
				$json[$ip] = date('Y-m-d H:i:s');
				file_put_contents('like.json', json_encode($json));
			}
			break;

	}
	echo json_encode([count => 20 + count($json), liked => isset($json[$ip]) ? 1 : 0]);
	exit();
	
function getIp()
{
    if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],
                        "unknown")
                ) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    return ($ip);
}

