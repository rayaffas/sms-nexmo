<?php
  
session_start();

$API_KEY = "";
$API_SECRET = "";
$API_NUMBER = "";
$recipient = $_POST['phoneNumber'];
$body = $_POST['message'];

$url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
[
'api_key' =>  $API_KEY,
'api_secret' => $API_SECRET,
'to' => $recipient,
'from' => $API_NUMBER,
'text' => $body,
'type' => 'unicode'
]
);

require 'database.php';
$records = $conn->prepare('SELECT user_id,email_address,password,username FROM users WHERE user_id = :user_id');
$records->bindParam(':user_id', $_SESSION['user_id']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

$_SESSION['username'] = $results['username'];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
//Decode the json object you retrieved when you ran the request.
$decoded_response = json_decode($response, true);
//error_log($_SESSION['username'] . ': sent ' . $decoded_response['message-count'] . ' messages.');

$messsage_id = '';
$_SESSION['status'] = 'Success';

$fp = fopen('report.csv', 'a');

foreach ( $decoded_response['messages'] as $message ) {
  if ($message['status'] == 0) {
    error_log(',' . $_SESSION['username'] . ',' . $recipient . ",Success" . ',' . str_replace(',', ';',$body) . ',' . $message['message-id']);
    $messsage_id = $message['message-id'];
  } else {
    error_log(',' . $_SESSION['username'] . ',' . $recipient . ",Error {$message['status']} {$message['error-text']}" . ',' . str_replace(',', ';',$body));
    $messsage_id = $message['message-id'];
    $_SESSION['status'] = 'Failed';
    $status = 'Failed';
  }
}

$fields = array (date('Y-m-d'), date('H:i:s'), $_SESSION['username'], $recipient, $_SESSION['status'], $body, $messsage_id);
fputcsv($fp, $fields);
fclose($fp);

?>