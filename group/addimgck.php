<?
function uploadimage($imgname,$imgtmpname,$imgtype,$add,$thumbsrc,$n_width,$n_height)
{
///////// Start the thumbnail generation//////////////
//$n_width=60;          // Fix the width of the thumb nail images
//$n_height=60;         // Fix the height of the thumb nail imaage

$tsrc=$thumbsrc.$imgname;   // Path where thumb nail image will be stored
//echo $tsrc;
if (!($imgtype =="image/pjpeg" or $imgtype =="image/jpeg" or $imgtype =="image/jpg" or  $imgtype=="image/gif")){echo "Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
exit;}
/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
try{
if ($imgtype=="image/gif")
{
$im=imagecreatefromgif($add);
$width=imagesx($im);              // Original picture width is stored
$height=imagesy($im);                  // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height);
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagegif")) {
Header("Content-type: image/gif");
imagegif($newimage,$tsrc);
}
elseif (function_exists("imagejpeg")) {
Header("Content-type: image/jpeg");
imagejpeg($newimage,$tsrc);
}
}////////// end of gif file thumb nail creation//////////

////////////// starting of JPG thumb nail creation//////////
if(($imgtype=="image/jpeg") or ($imgtype=="image/jpg")){
$im=imagecreatefromjpeg($add); 
$width=imagesx($im);              // Original picture width is stored
$height=imagesy($im);             // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height);           
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
imagejpeg($newimage,$tsrc);
//chmod("$tsrc",0777);
}
}
catch(Exception $o ){
    print_r($o); 
    exit;  
}
}
?>