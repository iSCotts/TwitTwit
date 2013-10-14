<?php
$metadata_selected = array();
$current_page=basename($_SERVER['PHP_SELF']);
switch ($current_page) {
   case "index.php":
		$metadata_selected['title'] 					=  $metadata['home']['title'] ;
		$metadata_selected['meta_keywords'] 			=  $metadata['home']['meta_keywords'] ;
		$metadata_selected['meta_description'] =  $metadata['home']['meta_description'] ;
        break;
    case "home.php":
		$metadata_selected['title'] 					=  $metadata['home']['title'] ;
		$metadata_selected['meta_keywords'] 			=  $metadata['home']['meta_keywords'] ;
		$metadata_selected['meta_description'] =  $metadata['home']['meta_description'] ;
        break;
	case "features.php":
		$metadata_selected['title'] 					=  $metadata['features']['title'] ;
		$metadata_selected['meta_keywords'] 			=  $metadata['features']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['features']['meta_description'] ;
        break;
	case "pricing.php":
		$metadata_selected['title'] 					=  $metadata['pricing']['title'] ;
		$metadata_selected['meta_keywords'] 			=  $metadata['pricing']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['pricing']['meta_description'] ;
        break;
	case "how_it_works.php":
		$metadata_selected['title'] 					= $metadata['how_it_works']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['how_it_works']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['how_it_works']['meta_description'] ;
        break;
	case "affiliate_program.php":
		$metadata_selected['title'] 					= $metadata['affiliate_program']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['affiliate_program']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['affiliate_program']['meta_description'] ;
        break;
	case "affiliates.php":
		$metadata_selected['title'] 					= $metadata['affiliates']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['affiliates']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['affiliates']['meta_description'] ;
        break;
	case "aff.php":
		$metadata_selected['title'] 					= $metadata['affiliates']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['affiliates']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['affiliates']['meta_description'] ;
        break;
	case "benefits.php":
		$metadata_selected['title'] 					= $metadata['benefits']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['benefits']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['benefits']['meta_description'] ;
        break;	
	case "faq.php":
		$metadata_selected['title'] 					= $metadata['faq']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['faq']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['faq']['meta_description'] ;
        break;	
	case "contact.php":
		$metadata_selected['title'] 					= $metadata['contact']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['contact']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['contact']['meta_description'] ;
        break;
	default:
		$metadata_selected['title'] 					= $metadata['other']['title'] ;
		$metadata_selected['meta_keywords'] 			= $metadata['other']['meta_keywords'] ;
		$metadata_selected['meta_description'] = $metadata['other']['meta_description'] ;
        break;		
}
?>