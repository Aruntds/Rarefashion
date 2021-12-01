<?php
extract($_REQUEST);
include_once('../../jackus.php');

reguser_protect();

//$phrase = "";

// if(isset($_GET['phrase'])) {
	// $phrase = $_GET['phrase'];
// }
//echo $phrase.'-'.$_GET['phrase'];

//if(strpos($phrase, '-') == TRUE) {
//	$received_phrase = str_replace(' ','',$phrase);  //strpos($a, 'are')
//	$phrase_new = strbefore($received_phrase,'-');
//	$phrase_afternew = strafter($received_phrase,'-');
//} else {
//	$phrase_new = $phrase;
//	$phrase_afternew = $phrase;
//}

//if(strlen($phrase_new) > 8) {
//	$filter_barcode_phrase = "OR default_barcode LIKE '$phrase_new%'";
//}


$return_arr = array();

$fetch = sqlQUERY_LABEL("SELECT productsku, producttitle FROM js_product where (productsku LIKE '%$phrase%' OR producttitle LIKE '%$phrase%') and deleted='0' LIMIT 0, 10"); 

while ($row = sqlFETCHARRAY_LABEL($fetch, MYSQL_ASSOC)) {
    $producttitle = $row['producttitle'];
	$producttitle = htmlspecialchars_decode($producttitle);
    $producttitle = preg_replace('/\s\s+/', '<br>', $producttitle);
    $producttitle = html_entity_decode($producttitle);
    $producttitle = str_replace('&amp;', '&', $producttitle);
    $producttitle = str_replace('&nbsp;', '', $producttitle);
    $row_array['productsku'] = $row['productsku'].' : '.$producttitle;
    
    array_push($return_arr,$row_array);
}

  echo json_encode($return_arr);

?>