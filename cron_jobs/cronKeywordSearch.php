<?php
/*
 * Created on 30-Jan-2010
 * Author :	liju
 * File:	cronKeywordSearch.php
 *
 */
include ('../common/sqlFunctions.php');
include ('../searchFollow/cronClasses.php');
include_once ('../classes/class.twitter.php');
include_once ('../common/secret.php');

$keywords=getkeyword();
$keywordsCount = count($keywords);
$searchKeyword = new SearchFollow('', '');
//$dktwitter = new twitter('','');
for ($i = 0; $i < $keywordsCount; $i++) {
	//echo '<br/>'.$dkrequest = $dktwitter->dkratelimit();
	$searchKeyword->save($keywords[$i]['Message'], $keywords[$i]['Lang'], $keywords[$i]['KeyId'], $keywords[$i]['since_id'], $keywords[$i]['max_id']);
}
echo 'Cron Keyword Search Completed Successfully';
?>
