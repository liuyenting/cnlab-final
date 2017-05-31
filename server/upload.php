
<?php
$student_id=$_POST[student_id];
$target_dir = "/tmp/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
echo $_FILES["fileToUpload"]["tmp_name"];
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $type = pathinfo($target_file, PATHINFO_EXTENSION);
        $data = file_get_contents($target_file);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        //echo $base64;
        $curl_body = "{
    \"image\": \"" . $base64 . "\",
    \"subject_id\": \"" . $student_id . "\",
    \"gallery_name\": \"Demo\"
}";
    //echo "<br>". $curl_body."<br>";
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
        //echo $response;
        curl_close($ch);
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "classroom";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
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



var_dump($response);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
