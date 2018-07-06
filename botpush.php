<?php



require "vendor/autoload.php";

$access_token = 'dh1wWTCSKQGOZg5QQdtQuXvSMbPP7YsgS5ZDVv5dfNNKCChgttDTvwqz/PxbdplN28Gdg6ARoJQIdk7LU3fWImZntWSZyNbwPqWfZPY4H4EuoDVcCNLST5izrdeHG308idXPWYrN11ZoTzijjKvy9wdB04t89/1O/w1cDnyilFU=';

$channelSecret = '3c69a807c14b2357a8ee4aae1b33dc38';

$pushID = array( 
    'U11fae07ce7afb4aac7875be082b2b3ee'

    );

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("เอกสาร PR ใหม่ รออนุมัติ ".$pushID." ");
$response = $bot->multicast($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







