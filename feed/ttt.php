<?php
// include class
include_once 'Services/Services/Twitter.php';

try {
  // initialize service object
  // perform login
  $service = new Services_Twitter('kumarphp7346', 'senthil');
  
  // update status
  $service->statuses->update('Having dinner with friends');
   
  // perform logout
  $service->account->end_session();
} catch (Exception $e) { 
  die('ERROR: ' . $e->getMessage());
}
?>
