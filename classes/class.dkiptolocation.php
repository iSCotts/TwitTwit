<?php
/*
 * Created By : Dinson Kadudhus(DK)
 * Created On : 2010-April-26
 * Description: This class returns location details of ip address
*/
class dkIpToLocation
{
	function getIpLocation($ip)
	{
		$ipLocDet['country']	= NULL;
		$ipLocDet['region']		= NULL;
		$ipLocDet['city']		= NULL;
		try 
		{
			$url = "http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress=$ip";
			$tags = @get_meta_tags($url);
		} 
		catch (Exception $e) { $tags = array(); }		
		if(is_array($tags))
		{
			if (array_key_exists('country', $tags))		$ipLocDet['country'] 	= $tags['country'];
			if (array_key_exists('region', $tags)) 		$ipLocDet['region'] 	= $tags['region'];
			if (array_key_exists('city', $tags)) 		$ipLocDet['city'] 		= $tags['city'];
		}
		if(empty($ipLocDet['country']) || empty($ipLocDet['city']))
		{
			$temp = $this->getIpLocFromHostip($ip);
			if((!empty($temp['country']) && !empty($temp['city'])) || ((!empty($temp['country']) || !empty($temp['city'])) && (empty($ipLocDet['country']) && empty($ipLocDet['city']))))
			{
				$ipLocDet['country']	= $temp['country'];
				$ipLocDet['region']		= NULL;
				$ipLocDet['city']		= $temp['city'];
			}
			if(empty($ipLocDet['country']))
			{
				try 
				{
					$ipLocDet['country'] = trim(@file_get_contents("http://nl.ae/iptocapi.php?type=3&ip=".$ip));
					$ipLocDet['region']		= NULL;
					$ipLocDet['city']		= NULL;
				} 
				catch (Exception $e) { $tags = array(); }		
			}
		}
		if(empty($ipLocDet['country'])) $ipLocDet['country']	= 'Unknown Country';
		if(empty($ipLocDet['region'])) $ipLocDet['region']		= 'Unknown Region';
		if(empty($ipLocDet['city'])) $ipLocDet['city']			= 'Unknown City';
		return $ipLocDet;
	}
	function getIpLocFromHostip($ip)
	{
		$ipLocDet['country']	= NULL;
		$ipLocDet['city']		= NULL;
		try 
		{
			$data	= @file_get_contents("http://api.hostip.info/get_html.php?ip=$ip");

		} 
		catch (Exception $e) { $data	= NULL;}	
		$temp = explode(':', $data);
		if (array_key_exists(1, $temp))
		{		
			$temp1 					= explode('City', $temp[1]);
			$temp1[0]				= trim($temp1[0]);
			$filter_words			= array('(Unknown Country?) (XX)');
			if(!in_array($temp1[0],$filter_words))
			$ipLocDet['country'] 	= $temp1[0];
		}
		if (array_key_exists(2, $temp))
		{		
			$temp1 					= explode('IP', $temp[2]);
			$temp1[0]				= trim($temp1[0]);
			$filter_words			= array('(Unknown City?)','(Unknown city)');
			if(!in_array($temp1[0],$filter_words))
			$ipLocDet['city'] 		= $temp1[0];
		}
		return $ipLocDet;
	}
}