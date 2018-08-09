<?php

require('./vendor/autoload.php');
require_once './lineBot.php';


$bot = new Linebot();
$text = $bot->getMessageText();
$eventType = $bot->getEventType();
$messageType = $bot->getMessageType();
// $bot->reply($text);

if($eventType == "join"){
  $bot->replyUsingText("Terimakasih telah mengundang saya kesini bos! Ada yang bisa dibantu?");
} else if($eventType == "message"){
    if($messageType == "text"){
      if($text == "/leave"){
        if($bot->getRoomChatType() == "group"){
          $bot->leaveGroup($bot->getGroupId());    
        }
      } else if($text == "/groupId"){
        $bot->getGroupId();
      } else{
        $bot->replyUsingText('Maaf, bisa diulangi bos? Saya masih belajar :(');
      }
    }
}

// switch($text){
//   case '/leave':
//     $bot->leaveGroup();
//     break;
//   case '/groupId':
//     $bot->getGroupId();
//     break;
//   default:
//     $bot->replyUsingText('Maaf, bisa diulangi bos?');
//     break;
// }


