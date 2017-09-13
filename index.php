<?php

$access_token = 'U8dbIysxBSXmKz4wI8Z6lp/cZwqTNAIP/kEdTVmZCMthVucIUphxtisWUtxSuT269GHObeCVSMncbSu1E7HO6e+w0f0bliQ4dfFvcJchDj3ckrp3RboE2/IjFy8tbFuqoGfZdG9CSOe6CIYBH+cuHAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');

$events = json_decode($content, true);

// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		
		//$userId = $event['source']['userid'];
		//$userId = '123456789';
		
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			
			error_log('$text >>>>>>>>>'.$text.'<<<<<<<< $text');
	
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
            
			$messages = 'X';
			
			$msg = array();
			
			
			if(stristr($text,'hey')) {
				
				
				array_push($msg,[
						'type' => 'text',
						'text' => 'hi po'
				]);
			}
			
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => $msg,
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			
		}
	}
}





echo 'OK';

?>
