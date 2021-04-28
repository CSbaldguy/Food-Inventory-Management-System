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

for ($i = 0; $i < sizeof($_POST["newQuantity"]); $i++){
  $oldQuantity = $_POST["oldQuantity"][$i];
  $newQuantity = $_POST["newQuantity"][$i];
  $id = $_POST["id"][$i];
  $status = true;
  
  if ($oldQuantity != $newQuantity) {
	if ($newQuantity > 0) {
	  $sql = "UPDATE Item SET quantity={$newQuantity} WHERE id={$id}";
	}
	elseif ($newQuantity == 0) {
	  $sql = "DELETE FROM Item WHERE id={$id}";
	  
	  $filepath = "upload/" . $id . ".jpg";
	  $status = unlink($filepath);
	  if ($status) {
	    echo "Photo delete successfully\n";
	  }
	  else {
	    echo "Error deleting photo: " . $filepath . "\n";
	  }	  
	}
	
	if ($conn->query($sql) === TRUE) {
	  echo "Record updated successfully\n";
	} 
	else {
	  echo "Error updating record: " . $conn->error . "\n";
	}
  }
}
?>