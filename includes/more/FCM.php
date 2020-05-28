<?php

$deviceToken = '';
$title = 'test Title';
$body = 'test body';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\JWT\CustomTokenGenerator;
/*
$clientEmail = 'firebase-adminsdk-qvbcs@iproject-38.iam.gserviceaccount.com';
$privateKey = '-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDIiUHKrETmQDTz
0Ng4gS+EfExi3nMB54v5JUfNC2Qj9woatdEkKR0YOE4kRs+j+iQ3IH7WnkIhLczC
1MwtDsi7HcI0sA7gWrjUOp3quecR+rucazcwVcPqd6uuWn5A7az5L9fPB7jnvPZy
BFE7zTllC9Zb6jUF4v6PZB+Y';
try {
    $generator = CustomTokenGenerator::withClientEmailAndPrivateKey($clientEmail, $privateKey);
    $deviceToken = $generator->createCustomToken('uid',['first_claim' => 'first_value']);
} catch (Exception $ex){
    Debug::diePrint($ex->getMessage());
}
$factory = (new Factory)->withServiceAccount(__DIR__.'/secret/iproject-38-firebase-adminsdk-qvbcs-37ec1c4b13.json');

$messaging = $factory->createMessaging();
$notification = Notification::fromArray([
        'title' => $title,
        'body' => $body

]);

$message = CloudMessage::withTarget('token', $deviceToken)->withNotification($notification);

try {
    $messaging->send($message);
} catch (Exception $ex){
    Debug::diePrint($ex->getMessage());
}
*/
class FCM {
    function __construct() {
    }
    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $notification,$device_type) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type == "Android"){
            $fields = array(
                'to' => $registatoin_ids,
                'data' => $notification
            );
        } else {
            $fields = array(
                'to' => $registatoin_ids,
                'notification' => $notification
            );
        }
        // Firebase API Key
        $headers = array('Authorization:key=AAAAV0dwhvc:APA91bFykW45TBo24dgOcVd7l-RjCy28HioDx1UKTVnrcE1equZLpr9OvdMOTXLXshkN2TnKNYUo8QkJIEaNRdYndBVagTuHW9NMMH4JdfKRmk902RziImv85YtugarOedrOgLOqoySr','Content-Type:application/json');
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
?>