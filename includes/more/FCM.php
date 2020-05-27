<?php
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
        $headers = array('Authorization:key=Your Firebase 
Server API Key Here','Content-Type:application/json');
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