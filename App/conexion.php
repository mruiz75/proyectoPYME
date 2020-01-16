<?php 
    $hostname = 'localhost';
    $database = 'pyme';
    $username = 'administrador';
    $password = '123';

    $conn = new mysqli($hostname, $username, $password, $database);
    if($conn->connect_errno){
        die("Conexión fallida: " . $conn->connect_error);
        //echo "El sitio web está experimentando problemas.";
    }
    
    // class DbConnect
	// {
	// 	//Variable que almacena el link a la base
	// 	private $con;
	 
	// 	function __construct()
	// 	{
	 
	// 	}
	 
	// 	//Metodo para conectarse a la base
	// 	function connect()
	// 	{
	// 		include_once dirname(__FILE__) . '/constantes.php';
	 
	// 		$this->con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 
	// 		if (mysqli_connect_errno()) {
	// 			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// 		}
	 
	// 		return $this->con;
	// 	}
	 
	// }

?>