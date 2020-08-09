<?php
	//  127.0.0.1/vk/php/getVKURL.php?offset=860&doc=4043932_330966431
	$offset = $_GET['page']; // 860
	$doc = $_GET['doc']; // 4043932_330966431
	if( $offset == '' || $offset == null || $doc == '' || $doc == null) return;

	set_time_limit(0);
		$topic = 'topic-4918594_27696136';
		$ch = curl_init();
		$options =  array(
			CURLOPT_HEADER => false,
			CURLOPT_URL => 'https://vk.com/'.$topic,
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 20,
			CURLOPT_PROXYAUTH => CURLAUTH_BASIC,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_COOKIE => 'remixlang=18; remixstid=1564978904_dNq81tA2DfXr3KvXf8Xp3Rv1CWklClgznZrzUT06Bes; remixlhk=a78315ac83ab0fd99c; remixflash=0.0.0; remixscreen_width=1670; remixscreen_height=940; remixscreen_dpr=1.149999976158142; remixscreen_depth=24; remixscreen_orient=1; remixgp=a2a45a89a337870f0cd17f29e9a4be46; remixdt=18000; remixrefkey=afca7b684817273880; remixua=-1%7C-1%7C166%7C1379839269; remixscreen_winzoom=1',
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.113 Safari/537.36 Edg/81.0.416.58',
			CURLOPT_HTTPHEADER => [
			'accept' => '*/*',
			'accept-encoding' => 'gzip, deflate, br',
			'accept-language' => 'zh-CN,zh;q=0.9,ja;q=0.8',
			'cache-control' => 'no-cache',
			'pragma' => 'no-cache',
			'sec-fetch-dest' => 'empty',
			'sec-fetch-mode' => 'cors',
			'sec-fetch-site' => 'same-origin',
			'content-type' => 'application/json;charset=UTF-8',
			'origin' => 'https://vk.com',
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36 Edg/84.0.522.48',
			'referer' => 'https://vk.com/topic-4918594_27696136?offset=0',
			'x-requested-with' => 'XMLHttpRequest',
		]);
		$options[CURLOPT_PROXY] = "127.0.0.1";
		$options[CURLOPT_PROXYPORT] = 1080;
		curl_setopt_array($ch, $options);

		curl_setopt($ch, CURLOPT_POSTFIELDS, 'al=1&al_ad=0&offset='.$offset.'&part=1');
		$content = curl_exec($ch);
		curl_close($ch);
		//file_put_contents($offset.'.html', $content);
		$hash = getStringByStartAndEnd($content, '\/doc'.$doc, '\"');
		if($hash != ''){
			echo header('Location: https://vk.com/doc'.$doc.$hash);
		}else{
			echo '<h1>File NOT FOUND!</h1>';
		}


function getStringByStartAndEnd($s_text, $s_start, $s_end, $i_start = 0, $b_end = false){
	if(($i_start = strpos($s_text, $s_start, $i_start)) !== false){
		if(($i_end = strpos($s_text, $s_end, $i_start + strlen($s_start))) === false){
			if($b_end){
				$i_end = strlen($s_text);
			}else{
				return;
			}
		}
		return substr($s_text, $i_start + strlen($s_start), $i_end - $i_start - strlen($s_start));
	}
	return '';
}