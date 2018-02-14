<?php

session_start();
require 'database.php';
//require_once 'get_db_results.php';

$_SESSION['status'] = 'message status';

if( !isset($_SESSION['user_id']) ){
	header("Location: /login.php");
} else {
    $records = $conn->prepare('SELECT user_id,email_address,password,username,privilege FROM users WHERE user_id = :user_id');
    $records->bindParam(':user_id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    //$results = getResults($_SESSION['user_id']);

   // $user = NULL;

  //   if( count($results) > 0){
  //     $user = $results;
  // }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elryan SMS Services</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/sms3/styles/style.css" type="text/css">
</head>
<body>
    <div class="header">
        <a href="/sms3">Elryan SMS Services</a>
        
            <br />Welcome <?= $results['username']; ?> 
            <br />You are successfully logged in!
            <a href="logout.php">Logout?</a>
    </div>

    <div class="container">
        <div id="error"></div>
        <!-- Last message status: <div id="status"></div> -->
        <form>
            <br>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Phone Number:</span>
                <span class="input-group-addon" id="sizing-addon3">+964</span>
                <input type="number" class="form-control" id="phoneNumber1" placeholder="ex. 7701234567" aria-describedby="basic-addon1" name="phoneNumber" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon3">Message:</span>
                <textarea class="form-control col-xs-12" id="message" placeholder="Type your message Here!" aria-describedby="basic-addon1" name="message" required></textarea>
            </div>
            <br>
            <div class="btn-group" role="group" aria-label="...">
                <button id="submit" type="submit" class="btn btn-default" name="submit">Send</button>
            </div>
        </form>

        <div id="list-container">
            <ul class="list-group" id="messages-list">
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
                <li class="list-group-item"></li>
            </ul>
        </div>

        <?php if($results['privilege'] == '1'): ?>
                <div>
                    <a href="download.php">Download SMS report</a>
                </div>
        <?php endif; ?>
        
        <script type="text/javascript" src="js/script.js"></script>
    </div>
</body>
</html>