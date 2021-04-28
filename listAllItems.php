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

$sql = "SELECT id, expiryDate, quantity FROM Item ORDER BY expiryDate ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $i = 0;
  echo "<table class=\"mytable\"><tr><th>Image</th><th>Expiry Date</th><th>Quantity</th></tr>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$class = "";
	$date1 = new DateTime("now");
	$date2 = new DateTime($row["expiryDate"]);
	$interval = $date1->diff($date2);
	$interval = intval($interval->format('%R%a'));
	if ($interval <= 0) {
		$class = "urgent";
	}	
	else if ($interval <= 7) {
		$class = "almost";
	}
	else if ($row["expiryDate"] == "2099-12-31") {
		$class = "noExpiry";
	}	
    echo "<tr><td><img src=\"./upload/".$row["id"].".jpg\"></td><td class=\"{$class}\">".$row["expiryDate"]."</td><td><input type=\"button\" id=\"sub{$i}\" class=\"subbutton\" value=\"—\" style=\"display: inline;\" onclick=\"subf({$i})\" /><input type=\"number\" name=\"newQuantity[]\" id=\"newQuantity{$i}\" pattern=\"[0-9]*\" value=\"{$row["quantity"]}\" style=\"display: inline; vertical-align: middle; \" /><input disabled type=\"button\" id=\"add{$i}\" class=\"addbutton\" value=\"＋\" style=\"display: inline; opacity: 0.5;\" onclick=\"addf({$i})\" />".
		 "<input hidden type=\"number\" name=\"oldQuantity[]\" id=\"oldQuantity{$i}\" value=\"{$row['quantity']}\" /><input hidden type=\"number\" name=\"id[]\" value=\"{$row['id']}\" /></td></tr>";
    ++$i;
  }
  echo "</table><input type=\"submit\" id=\"submit\" value=\"Confirm Update\">";
} else {
  echo "There is no record in the database.";
}
$conn->close();
?>