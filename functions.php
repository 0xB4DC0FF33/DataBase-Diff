<?php

function getTablesAndCols($PDO, $database, $prefix, $filter) {
	$tableRequest = "SHOW TABLES FROM ".$database." LIKE '".$filter."'";
	try {
		$table = $PDO->query($tableRequest);
	} catch (Exception $e) {
		echo "Request failed : ".$e->getMessage();
	}

	$result = array();

	$tempArray = $table->fetchAll();

	foreach ($tempArray as $fe) {
		$tableName = $fe[0];
		preg_match("|(".$prefix.")(.+)|", $tableName, $matches);
		$result[$matches[2]] = array();

		$columnsRequest = "SHOW COLUMNS FROM ".$tableName;
		try {
			$columns = $PDO->query($columnsRequest);
			$resCol = $columns->fetchAll();
		} catch (Exception $e) {
			echo "Request failed : ".$e->getMessage();
		}
		foreach ($resCol as $col) {
			array_push($result[$matches[2]], $col['Field']);
		}
	}
	return $result;
}

function getPDO($dbname, $host, $user, $pass) {
	$errors = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	$dsn="mysql:dbname=".$dbname.";host=".$host;
	try {
		$PDO = new PDO($dsn, $user, $pass, $errors);
	} catch (PDOException $e) {
		echo 'Connection failed : ' . $e->getMessage();
	}
	return $PDO;
}

?>
