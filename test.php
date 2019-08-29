<html>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="text" name="fname";>
	<button type="submit">submit</button>
</form>

<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>	
	


</html>