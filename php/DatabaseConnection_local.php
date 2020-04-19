<?php
class DatabaseConnection
    {
        # Create a singleton to store the connection for reuse
        private static $singleton,
                       $con;
        # save connection to singleton and return itself (the full object)
        public function __construct()
           {
                # If your singleton is not set
                if(!isset(self::$singleton))
                    # assign it this class
                    self::$singleton = $this;
                # return this class
                return self::$singleton;
           }
        # This is a connection method because your __construct
        # is not able to return the $pdo connection
        public function connection($host="localhost", $username="root", $password="password", $database="wordpress")
            {
                if(self::$con instanceof mysqli)
                    return self::$con;
		$servername = "localhost";
		$username = "root";
		$password = "password";
		$dbname = "wordpress";

		// Create connection
		$connection = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($connection->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		self::$con = $connection;
		return self::$con;
            }
    }
