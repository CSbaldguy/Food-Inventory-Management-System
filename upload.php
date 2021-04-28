<?php 
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "food_inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$currentTime = time();
$barcode = $_POST['barcode'];
$expiryDate = $_POST['expiryDate'];
$quantity = $_POST['quantity'];

if (empty($barcode)) {
  $barcode = "NULL";
}
$sql = "INSERT INTO Item VALUES ({$currentTime}, {$barcode}, {$quantity}, '{$expiryDate}')";

if (empty($expiryDate)) {
  $sql = "INSERT INTO Item(id, barcode, quantity) VALUES ({$currentTime}, {$barcode}, {$quantity})";
}

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully\n";
  $conn->close();
} 
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  $currentTime = time();
  if (empty($barcode)) {
    $barcode = "NULL";
  }
  $sql = "INSERT INTO Item VALUES ({$currentTime}, {$barcode}, {$quantity}, '{$expiryDate}')";
  if (empty($expiryDate)) {
    $sql = "INSERT INTO Item(id, barcode, quantity) VALUES ({$currentTime}, {$barcode}, {$quantity})";
  }
  
  if ($conn->query($sql) === TRUE) {
	echo "Retry: New record created successfully\n";
  }  
  else {
	echo "Retry Error: " . $sql . "<br>" . $conn->error;  
  }
  $conn->close();
} 

// SECURITY - To be improved: Can be fake extension
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$target_path = "upload/" . $currentTime . "." . $ext;

/* $imageTemp = $_FILES["file"]["tmp_name"]; 
$image = imagecreatefromjpeg($imageTemp);
imagejpeg($image, $target_path, 0.75); */

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
// if ($target_path) {
    echo "The file has been uploaded to {$target_path}.\n";
} else {
    echo "There was an error uploading the file, please try again!";
}

foreach ($_POST as $key => $value){
  echo "{$key} = {$value}\r\n";
}
?>