<?php
	$title = $_POST['title'];
	$message = $_POST['message'];
	if($title != '' && $message != ''){
		if(!file_exists('data.json')){
			$json = [];
		}else{
			$json = json_decode(file_get_contents('data.json'), true);
		}
		date_default_timezone_set('Asia/ShangHai');
		$json[] = [
			'title' => $title,
			'message' => $message,
			'date' => date('Y-m-d H:i:s')
		];
		file_put_contents('data.json', json_encode($json));
		exit('success');
	}
	exit('error');

