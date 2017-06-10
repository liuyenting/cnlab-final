<?php
	$servername = "localhost";
	$username = "root";
	$password = "plinderhaobunbuncnlab";
	$dbname = "classroom";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$datepicker = $_POST[datepicker];
	list($month, $day, $year) = split("/", $datepicker, 3);
	$date = date_create();
	date_date_set($date, $year, $month, $day);
	echo date_format($date, 'Y-m-d')."<br>";
	$sql = "DELETE FROM week_date_table WHERE Week IS NOT NULL";
	if ($conn->query($sql) === TRUE) {
		echo "Old records deleted successfully" . "<br>";
	}
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	for($i=0;$i<18;$i++) {
		$sql = "INSERT INTO week_date_table (Week, Date) VALUES (\"wk" . $i . "\",\"" . $date->format('Y-m-d') . "\")";
		$date->add(new DateInterval('P7D'));
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully" . "<br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	$conn->close();
?>
