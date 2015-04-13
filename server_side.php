<?php
	// header("content-type: text/xml");
 //    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"

if ($_SERVER['REQUEST_METHOD'] == 'GET')
	return;

$servername = "localhost";
$username = "root";
$password = "hellohello";
$database = "FARMER";

//Create connection
$mysqli = mysqli_connect($servername, $username, $password, $database);

if ($mysqli->connect_error) {
	die("Connection failed: ".$mysqli->connect_error);
}

$sql = 'Select Address from RegisterInfo';

$result = $mysqli->query($sql);

$output = '{"AddressList":[';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$output .= '{"Address":"'  . $row['Address'] . '"},';
    }
}
$output = substr($output, 0, -1);
$output .="]}";
echo($output);
$mysqli->close();
?>

