<?php

session_start();
require 'database.php';

//require_once ('get_db_results.php');

if( isset($_SESSION['user_id']) ){
	header("Location: /"); // enter location
}



if(!empty($_POST['email_address']) && !empty($_POST['password'])):
    
    

    $records = $conn->prepare('SELECT user_id,email_address,password FROM users WHERE email_address = :email_address');
    $records->bindParam(':email_address', $_POST['email_address']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    
    //$results = getResults($_POST['email_address']);

    $message = '';

    if(count($results) > 0 && ($_POST['password'] == $results['password']) ){
        $_SESSION['user_id'] = $results['user_id'];
        header("Location: /"); // enter location
} else {
        $message = 'Sorry, those credentials do not match.<br>Please contact your supervisor!';
        echo 'hello' . $_SESSION['user_id'] . $results['user_id'] . 'helloo';
}
endif;

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Below</title>
    <link rel="stylesheet" href="/sms3/styles/login_styles.css" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="header">
        <a href="/sms3">Elryan SMS Services</a>
    </div>
    <?php if(!empty($message)): ?>
        <p>
            <?= $message ?>
        </p>
    <?php endif; ?>

    <h1>Login</h1>

    <form action="login.php" method="POST">

        <input type="text" placeholder="Enter your email address" name="email_address">
        <input type="password" placeholder="and password" name="password">
        <input type="submit" value="Login!">

    </form>

    <p>If you have a problem logging in or need access to Elryan SMS Services,<br>please contact your supervisor!</p>

</body>
</html>