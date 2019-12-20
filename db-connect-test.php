<?php 

// $dbname = 'pyme';
// $dbuser = 'administrador';
// $dbpass = '123';
// $dbhost = 'localhost:8080';


// $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
// mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

// echo"Great work!";

// $test_query = "SHOW TABLES FROM $dbname";
// $result = mysqli_query($link, $test_query);

// $tblCnt = 0;
// while($tbl = mysqli_fetch_array($result)) {
//   $tblCnt++;
//   #echo $tbl[0]."<br />\n";
// }

// if (!$tblCnt) {
//   echo "There are no tables<br />\n";
// } else {
//   echo "There are $tblCnt tables<br />\n";
// } 

$host = "localhost:3306";
$username = "administrador";
$password = "123";
$database = "pyme";

$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
	die("Connection failed: " . mysqli_connect_error());
}
echo "Connected succesfully";

 ?>