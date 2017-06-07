<style>
#text {
	position: absolute;
	top: 100px;
	left: 50%;
	margin: 0px 0px 0px -150px;
	font-size: 18px;
	text-align: center;
	width: 300px;
}
	#barbox_a {
	position: absolute;
	top: 130px;
	left: 50%;
	margin: 0px 0px 0px -160px;
	width: 304px;
	height: 24px;
	background-color: black;
}
.per {
	position: absolute;
	top: 130px;
	font-size: 18px;
	left: 50%;
	margin: 1px 0px 0px 150px;
	background-color: #FFFFFF;
}
.bar {
	position: absolute;
	top: 132px;
	left: 50%;
	margin: 0px 0px 0px -158px;
	width: 0px;
	height: 20px;
	background-color: #0099FF;
}

.blank {
	background-color: white;
	width: 300px;
}
</style>
<?php
ob_implicit_flush(true); // Immediately echo, this only works with Chrome
ob_end_flush(); // Immediately echo, this only works with Chrome
$target_dir = "/tmp/";
$unzip_tmp_dir = "/tmp/tmpzip/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg") {
	$id = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
	uploadToKairos($_FILES["fileToUpload"]["tmp_name"], $id);
	updateSQL($id);
}
else if($fileType == "zip") {
	$zip = new ZipArchive;
	if ($zip->open($_FILES["fileToUpload"]["tmp_name"]) === TRUE) {
		$zip->extractTo($unzip_tmp_dir);
		$zip->close();
		echo 'Unzip OK...' . "<hr>";
		echo "
			<div id='text'>Upload Progress</div>
			<div id='barbox_a'></div>
			<div class='bar blank'></div>
			<div class='per'>0%</div>
			";
		$files = glob($unzip_tmp_dir.'*.{jpg,png,gif,jpeg}', GLOB_BRACE);
		$counter = 0;
		$total = count($files);
		foreach($files as $file) {
			//echo "Uploading ". $file . " to Kairos..." . "<br>";
			$id = pathinfo($file, PATHINFO_FILENAME);
			uploadToKairos($file, $id);
			updateSQL($id);
			$counter++;
			update_progress(100*$counter/$total);

		}
		array_map('unlink', glob($unzip_tmp_dir.'*.*'));
		rmdir($unzip_tmp_dir);
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
	echo "Uploading ". $student_id . " to Kairos..." . "<br>";
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
	VALUES (\"" . $student_id . "\", 0, 0, 0)"; //TODO update total week number
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully" . "<br>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
function update_progress($percent) {
	echo "<div class='per'>{$percent}%</div>\n";
	echo "<div class='bar' style='width: ",$percent * 3, "px'></div>\n";
}
?>
