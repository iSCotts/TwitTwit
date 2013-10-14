<?
function uploadimage($fileName,$imgtmpname,$imgtype,$location_original,$location_thumb,$new_width,$new_height)
{
$allowed_types = array(
 'image/pjpeg',
 'image/gif','image/jpeg','image/jpg');
 if(in_array($imgtype, $allowed_types))
 {
 //$getExt = explode ('.', $imgname);
 //$file_ext = $getExt[count($getExt)-1];

 //$fileName=$recId.".".$file_ext;

 $getSize=getimagesize($imgtmpname);
 $width=$getSize[0];
 $height=$getSize[1];
 $target=85;

 if ($width > $height) {
 $percentage = ($target / $width);
 }
 else {
 $percentage = ($target / $height);
 }

 $new_width = round($width * $percentage);
 $new_height = round($height * $percentage);


 //copy ($imgtmpname, $location_original) or die ("Could not copy");
 $imageLargeFile=$location_original;

 $image_p = imagecreatetruecolor($new_width,$new_height);
 if ($imgtype == "image/gif")
 {
 $img = @imagecreatefromgif($imageLargeFile);
 imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 $thenames=$fileName;
 $location=$location_thumb.$thenames;
 imagegif($image_p,$location, 100);
// echo $location;
 }
 else
 {
 $img = @imagecreatefromjpeg($imageLargeFile);
 imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 $thenames=$fileName;
 $location=$location_thumb.$thenames;
 imagejpeg($image_p,$location, 100);
 //echo $location;
 }
 }
 }
?>