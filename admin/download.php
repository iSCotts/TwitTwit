<?
if(isset($_REQUEST['filename']))
{
	$file=$_REQUEST['filename'];
    $dir      = "../mailtempl/";
    if ((isset($file))&&(file_exists($dir.$file)))
	 {
       header("Content-type: application/force-download");
       header('Content-Disposition: inline; filename="' . $dir.$file . '"');
       header("Content-Transfer-Encoding: Binary");
       header("Content-length: ".filesize($dir.$file));
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename="' . $file . '"');
       readfile("$dir$file");
    }
	 else 
	{
       echo "No file selected";
    } //end if

}
?>