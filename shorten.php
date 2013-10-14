<?php

include 'shuffle.php';



?>


 <p align="center">Your URL:</p>
         <p align="center"><?php echo $_POST['url']; ?></p>
         <p align="center">Has been shortened to:</p>
         <p align="center"><?php echo geturl($_POST['url']); ?></p>



