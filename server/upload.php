<?php
$target_dir = "/tmp/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg") {
	$id = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
	uploadToKairos($_FILES["fileToUpload"]["tmp_name"], $id);
	/*
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		// Insert row into MySQL
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "classroom";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "INSERT INTO roll_call_table (student_id, wk0, wk1, wk2)
		VALUES (\"" . $student_id . "\", 0, 0, 0)";
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	else {
		echo "Sorry, there was an error uploading your file.";
	}
	*/
}
else if($fileType == "zip") {
	$zip = new ZipArchive;
	if ($zip->open($_FILES["fileToUpload"]["tmp_name"]) === TRUE) {
		$zip->extractTo('/tmp/tmpzip/');
		$zip->close();
		echo 'Unzip OK' . "<br>";
		$files = glob('/tmp/tmpzip/*.{jpg,png,gif,jpeg}', GLOB_BRACE);
		foreach($files as $file) {
			echo "Uploading ". $file . " to Kairos..." . "<br>";
			$id = pathinfo($file, PATHINFO_FILENAME);
			uploadToKairos($file, $id);
		}
	} else {
		echo 'Unzip failed' . "<br>";
	}
} else {
	echo "File type error" . "<br>";
}

function uploadToKairos($target_file, $student_id) {
	$type = pathinfo($target_file, PATHINFO_EXTENSION);
	$data = file_get_contents($target_file);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	$curl_body = "{\"image\": \"" . $base64 . "\",\"subject_id\": \"" . $student_id . "\",\"gallery_name\": \"Demo\"}";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.kairos.com/enroll");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_body);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"app_id: 420de94a",
		"app_key: bb9d4e85c8acbb16de74654e4a9c009a"
	));
	$response = curl_exec($ch);
	//echo $response . "<br>";
	curl_close($ch);
}
function updateSQL($student_id) {
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "classroom";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO roll_call_table (student_id, wk0, wk1, wk2)
	VALUES (\"" . $student_id . "\", 0, 0, 0)";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully" . "<br>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
?>
