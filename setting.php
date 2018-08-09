<?php

class Setting {
	public function getChannelAccessToken(){
		$channelAccessToken = "W1yPDkFgGLAQGVeoD5KxzCKJ7Dh8v3ulaBFrZiZHmQQJ5XSRibF72VloI3TbKu+agQp5zkM7qb+HxSQQNPJhChECs3qqppPjtQbwhK7jF23GYFoKRyXwgUaOrkkrMVpM4jxGeoNvuQNgIpbo1/sivQdB04t89/1O/w1cDnyilFU=";
		return $channelAccessToken;
	}
	public function getChannelSecret(){
		$channelSecret = "f0efe27c52ff4aef671b13eb8a984d7f";
		return $channelSecret;
	}
	public function getApiReply(){
		$api = "https://api.line.me/v2/bot/message/reply";
		return $api;
	}
	public function getApiPush(){
		$api = "https://api.line.me/v2/bot/message/push";
		return $api;
	}
}