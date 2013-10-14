<?php
    session_start();

    include_once "config.php";
 
    /*
    Create a new TwitterOAuth object, and then
    get a request token. The request token will be used
    to build the link the user will use to authorize the
    application.

     You should probably use a try/catch here to handle errors gracefully
    */

    $to = new TwitterOAuth($consumer_key, $consumer_secret);
    $tok = $to->getRequestToken();

    $request_link = $to->getAuthorizeURL($tok);

    $_SESSION['oauth_request_token']        = $tok['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];

    header("Location: $request_link");
    exit;
?>
