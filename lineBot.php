
<?php

require('./vendor/autoload.php');
require_once './setting.php';

class Linebot {
	private $channelAccessToken;
	private $channelSecret;
	private $webhookResponse;
	private $webhookEventObject;
	private $apiReply;
	private $apiPush;
	
	public function __construct(){
		$this->channelAccessToken = Setting::getChannelAccessToken();
		$this->channelSecret = Setting::getChannelSecret();
		$this->apiReply = Setting::getApiReply();
		$this->apiPush = Setting::getApiPush();
		$this->webhookResponse = file_get_contents('php://input');
		$this->webhookEventObject = json_decode($this->webhookResponse);
	}
	
	private function httpPost($api,$body){
		$ch = curl_init($api); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
			array( 
			'Content-Type: application/json; charset=UTF-8', 
			'Authorization: Bearer '.$this->channelAccessToken)
		); 
		$result = curl_exec($ch); 
		curl_close($ch); 
		return $result;
	}
	
	public function reply($arrayMessage){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] = $arrayMessage;
		
		$result = $this->httpPost($api,$body);
		return $result;
	}
	
	public function replyUsingText($text){
		$arrayMessage = array(
			"type" => "text",
			"text" => $text
		);
		$this->reply($arrayMessage);
	}
	
	public function getMessageText(){
		$webhook = $this->webhookEventObject;
		$messageText = $webhook->{"events"}[0]->{"message"}->{"text"}; 
		return $messageText;
	}

	public function getEventType(){
		$webhook = $this->webhookEventObject;
		$res = $webhook ->{"events"}[0]->{"type"};
		return $res;
	}

	public function getRoomChatType(){
		$webhook = $this->webhookEventObject;
		$res = $webhook->{"events"}[0]->{"source"}->{"type"};
		return $res;
	}

	public function getMessageType(){
		$webhook = $this->webhookEventObject;
		$res = $webhook->{"events"}[0]->{"message"}->{"type"};
		return $res;
	}
	
	public function postbackEvent(){
		$webhook = $this->webhookEventObject;
		$postback = $webhook->{"events"}[0]->{"postback"}->{"data"}; 
		return $postback;
	}
	
	public function getUserId(){
		$webhook = $this->webhookEventObject;
		$userId = $webhook->{"events"}[0]->{"source"}->{"userId"}; 
		return $userId;
	}
	
	public function leaveGroup($groupId){
		$this->replyUsingText('Terimakasih! Kalau ada apa apa invite lagi ya!');
		$leaveGroupApi = "https://api.line.me/v2/bot/group/". $groupId . "/leave";
		// $this->replyUsingText($leaveGroupApi);
		$ch = curl_init($leaveGroupApi);
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
			array(
			'Authorization: Bearer '.$this->channelAccessToken)
		); 
		$result = curl_exec($ch); 
		if(!curl_exec($ch)){
			die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
		}
		curl_close($ch); 
		// $this->replyUsingText($curlInit);
	}

	public function joinGroup(){
		$webhook = $this->webhookEventObject;
	}

	public function getGroupId(){
		$webhook = $this->webhookEventObject;
		$groupId = $webhook->{"events"}[0]->{"source"}->{"groupId"};
		// $this->replyUsingText($groupId);
		return $groupId;
	}

}
