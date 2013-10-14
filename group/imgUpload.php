 <?php
 function uploadPhoto($recId,$type,$photo_tmpname,$photo_name,$photo_type,$target,$location_thumb,$location_original)
 {
 /* Settings */
 $allowed_types = array(
 'image/pjpeg',
 'image/gif','image/jpeg','image/jpg');

 if(in_array($photo_type, $allowed_types))
 {
 $getExt = explode ('.', $photo_name);
 $file_ext = $getExt[count($getExt)-1];

 $fileName=$recId.$type.".".$file_ext;
 $getSize=getimagesize($photo_tmpname);
 $width=$getSize[0];
 $height=$getSize[1];
 $target=60;
 if ($width > $height) {
 $percentage = ($target / $width);
 }
 else {
 $percentage = ($target / $height);
 }

 $new_width = round($width * $percentage);
 $new_height = round($height * $percentage);
 //copy ($photo_tmpname,$location_original) or die ("Could not copy");
 $imageLargeFile=$location_original;

 $image_p = imagecreatetruecolor($new_width,$new_height);
 if ($photo_type == "image/gif")
 {
 $img = @imagecreatefromgif($imageLargeFile);
 imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 $thenames="thumb_$fileName";
 $location=$location_thumb.$thenames;
 imagegif($image_p,$location,100);
 }
 else
 {
 $img = @imagecreatefromjpeg($imageLargeFile);
 imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 $thenames="thumb_$fileName";
 $location=$location_thumb.$thenames;
 imagejpeg($image_p,$location,100);
 }
 }
  return $fileName;
 }
 ?>