<?PHP
 include "class.myatomparser.php"; 
 $url = "http://twitter.com/statuses/user_timeline/92294609.rss"; 
  $atom_parser = new myAtomParser($url); 
  $output = $atom_parser->getOutput(); 
  
  print_r($output);
   ?>