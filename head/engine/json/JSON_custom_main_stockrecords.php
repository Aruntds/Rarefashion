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
    $prdt_name = $row['producttitle'];
	$prdt_name = htmlspecialchars_decode($prdt_name);
    $prdt_name = preg_replace('/\s\s+/', '<br>', $prdt_name);
    $prdt_name = html_entity_decode($prdt_name);
    $prdt_name = str_replace('&amp;', '&', $prdt_name);
    $prdt_name = str_replace('&nbsp;', '', $prdt_name);
    $row_array['productsku'] = $row['productsku'].' : '.$prdt_name;
    //$row_array['prdt_name'] = $row['prdt_name'];
    array_push($return_arr,$row_array);
}

  echo json_encode($return_arr);

?>