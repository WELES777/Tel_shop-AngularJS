<?php
include('db_connect.php');
// $filtering = $_POST['filtering'];
// switch ($filtering) {
// 	case 'search':
// 		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1'");
// 		break;
// 	case 'news':
// 		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1' AND new = '1'");
// 		break;
// 	case 'leaders':
// 		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1' AND leader = '1'");
// 		break;
// 	case 'sale':
// 		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1' AND sale = '1'");
// 		break;	
// 	default:
// 		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1'");
// 		break;
$types = $_GET["types"];
$models = $_GET["models"];

$typesTop = "AND type_product='$types'";
$modelsTop = "AND model='$models'";
if(isset($_GET["types"])){
	$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1' $typesTop") or die("Brak połączenia z bazą danych ".mysqli_error($link));
	}
	else if(isset($_GET["models"])){
	$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1' $modelsTop") or die("Brak połączenia z bazą danych ".mysqli_error($link));
	}
	else{
		$count = mysqli_query($link, "SELECT * FROM table_products WHERE visible = '1'") or die("Brak połączenia z bazą danych ".mysqli_error($link));
	}

		


$arr = array();
if(mysqli_num_rows($count) > 0) {
	while($row = mysqli_fetch_assoc($count)) {
		$arr[] = $row;  
	}
}
$json_response = json_encode($arr);
echo $json_response;



?>
