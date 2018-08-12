<?php
require_once './lineBot.php';


$bot = new Linebot();
$text = $bot->getMessageText();
$eventType = $bot->getEventType();
$messageType = $bot->getMessageType();
// $bot->reply($text);
$textExplodeWeather = explode(' ', $text);
$userDisplayName = $bot->getUserName($bot->getUserId());

if ($eventType == "join"){
  $bot->replyUsingText("Terimakasih telah mengundang saya kesini bos! Ada yang bisa dibantu?");
} else if ($eventType == "message"){
    if($messageType == "text"){
      if($text == "/leave"){
        if($bot->getRoomChatType() == "group"){
          $bot->leaveGroup($bot->getGroupId());    
        }
      } else if($text == "/groupId"){
        $bot->printGroupId();
      } else if($textExplodeWeather[0] == "/weather"){
        $bot->getWeatherBasedOnCityName($textExplodeWeather[1]);
      } else if(strpos($text, "makasih") || strpos($text, "thx")){
        $bot->replyUsingText("Siap! sama-sama " . $userDisplayName);
      } else{
        $bot->replyUsingText('Maaf, bisa diulangi bos? Saya masih belajar :(');
      }
    }
} else if ($eventType == "follow"){
    $bot->replyUsingText("Helo! " . $userDisplayName . " kenalin saya With Her. Bot yang bakal bantu kamu untuk tau info cuaca. Keyword yang bisa kamu pakai yaitu: \n
    - /weather {nama_kota} untuk cek cuaca berdasarkan nama kota
    - /leave untuk keluar dari grup, ataupun room chat. Selamat mencoba!
    ");
}


