<?php
 
    $servername = "localhost";
    $username = "root";
    $password = "hellohello";
    $database = "FARMER";

    //Create connection
    $mysqli = mysqli_connect($servername, $username, $password, $database);

    if ($mysqli->connect_error) {
        die("Connection failed: ".$mysqli->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$body = $_POST['Body'];
        $arr = explode(" ",trim($body));
        $phone = $_POST['From'];
	$phoneNo = trim($phone);
        $checkStatus = $arr[0];
	$message = '';
        if (((string)$checkStatus) === 'Register') {
            $firstName = $arr[1];
	    $lastName = $arr[2];
	    $address = '';
	    for ($i = 3; $i < count($arr); $i++) {
	    	$address .= $arr[$i] . ' ';
	    }
            $sql = "INSERT INTO RegisterInfo VALUES('" . $firstName . "','" . $lastName . "','" . $address . "','". $phoneNo ."')";
            $mysqli->query($sql);
            $message = "Hi ". $firstName . ", You have been registered with our system. You can now send your problems.";
        } else {
            $sql = "SELECT First_Name FROM RegisterInfo WHERE PhoneNo='" . $phoneNo ."' LIMIT 1;";
            $result = $mysqli->query($sql); 
            $row = $result->fetch_assoc();
	    $firstName = $row["First_Name"];

	    $pest = $arr[0];
	    $sql2 = "SELECT * FROM Pesticides WHERE Pest='" . $pest . "' LIMIT 1;";
	    $result2 = $mysqli->query($sql2);
	    $row2 = $result2->fetch_assoc();
	    $pesticide = $row2["Pesticide"];
            $message = "Hi " . $firstName . ", You should use " . $pesticide . ".";
        }

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        echo "<Response><Sms>" . utf8_encode($message) . "</Sms></Response>";
    } else {
        echo "Only POST Requests are valid.";
    }
?>
