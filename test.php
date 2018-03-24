<?php
class foo_mysqli extends mysqli {
	public function __construct($host, $user, $pass, $db) {

		parent::__construct($host, $user, $pass, $db);

		if (mysqli_connect_error()) {
			die('Connect Error (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
	}

	public static function singleton() {

		if (!isset(self::$instance)) {

			$className = __CLASS__;
			self::$instance = new $className;

			if (self::$instance->connect_errno != 0) {
				throw new DBConnectionException("Could not connect to database. Returned error number:" . self::$instance->connect_errno );
			}
		}

		return DB::$instance;
	}


	public function query($query, $resultmode = null) {
		$result = parent::query($query, $resultmode);

		if (!$result) throw new DatabaseQueryErrorException(json_encode(array("query" => $query, "error" => $this->error)));
		return $result;
	}

	public function arrayFromResults() {
	// function that takes results and returns array
	}
}

$db = DB::singleton();
$result = $db->query($query);
$products = $db->arrayFromResult($result);



class DB extends \mysqli {
	private static $instance;
	protected static $connection;

	public function __construct($instance) {
		global $databaseDomain;
		global $databaseUsername;
		global $databasePassword;
		global $databaseName;

		self::$connection = new mysqli($databaseDomain,$databaseUsername,$databasePassword,$databaseName);
		
		self::$instance = self::$connection;
		$this->set_charset("utf8");
	}

	public static function singleton() {

		if (!isset(self::$connection)) {

			$className = __CLASS__;
			self::$instance = new $className;
			if (self::$instance->connect_errno != 0) {

				throw new DBConnectionException("Could not connect to database. Returned error number:" . self::$instance->connect_errno );
			}
		}
		$className = __CLASS__;
	    self::$instance = new $className;
		return self::$instance;
	}
	public function query($query, $resultmode = null) {
		$result = parent::query($query, $resultmode);

		if (!$result) throw new DatabaseQueryErrorException(json_encode(array("query" => $query, "error" => $this->error)));
		return $result;
	}

	public function arrayFromResults() {
	// function that takes results and returns array
	}
}
============================