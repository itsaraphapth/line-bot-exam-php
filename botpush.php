






    <?php
    require_once __DIR__ . '/vendor/autoload.php';
  
    // debug
    error_reporting(-1);
    ini_set('display_errors', 'On');
  
    // Channel secret - (from https://developers.line.me/console/)
    $token = 'dh1wWTCSKQGOZg5QQdtQuXvSMbPP7YsgS5ZDVv5dfNNKCChgttDTvwqz/PxbdplN28Gdg6ARoJQIdk7LU3fWImZntWSZyNbwPqWfZPY4H4EuoDVcCNLST5izrdeHG308idXPWYrN11ZoTzijjKvy9wdB04t89/1O/w1cDnyilFU=';
    // $token = $_POST['token'];
    
    // Channel access token - (from https://developers.line.me/console/)
    $secret = '3c69a807c14b2357a8ee4aae1b33dc38';
    // $secret = $_POST['secret'];
   $pushID = array(
       "U11fae07ce7afb4aac7875be082b2b3ee",
       "U0e6b5794496cbcee1bb4850c8f888c8c",
       "U8f70ff048d6c81f89cc0f280be0acef2"
   );
  
    // connect key setup
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($token);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
  
    if(isset($pushID) ){
  
      // check for send message only
      $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ลองส่งหลายคน");
      $response = $bot->multicast($pushID, $textMessageBuilder);
  
      // check status sending line api
      if($response->isSucceeded()){
        echo "true";
      }else{
        echo "false";
      }
  
    }else{
  
      // Get POST body content
      $content = file_get_contents('php://input');
      // Parse JSON
      $events = json_decode($content, true);
  
      // Validate parsed JSON data
      if (!is_null($events['events'])) {
        foreach ($events['events'] as $event) {
          if($event['type'] == "message" && isset($event['message']['text'])){
  
            $type = $event['source']['type']; // user , room , group
            $to = $event['source'][$type.'Id']; // userId , roomId , groupId
            $message = trim($event['message']['text']);
  
            switch ($message) {
              case '/help':
                $text = "ฉันคือ ID Finder Bot ยินดีที่ได้รู้จัก";
                $text .= "\nฉันมีหน้าที่ช่วยคุณค้าหา UserID RoomID หรือ GroupID ให้กับคุณ";
                $text .= "\nลองพิมพ์ /id ดูซิ";
                break;
              case '/id':
                $text = "ข้อมูล ID ของคุณ";
                if(isset($event['source']['userId'])){ $text .= "\nUser ID : ".$event['source']['userId']; }
                if(isset($event['source']['roomId'])){ $text .= "\nRoom ID : ".$event['source']['roomId']; }
                if(isset($event['source']['groupId'])){ $text .= "\nGroup ID : ".$event['source']['groupId']; }
                break;
              default:
                $text = NULL;
                break;
            }
  
            // message setup & send
            if($text != NULL){
              $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
              $response = $bot->pushMessage($to, $textMessageBuilder);
            }
  
          }
        }
      }
    }
  
    // debug
    // echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
  ?>