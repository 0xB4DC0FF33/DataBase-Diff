<?php
	include "functions.php";

	$BDD1 = getPDO("[DBNAME]", "[HOST]", "[LOGIN]", "[PASSWORD]");
	$BDD2 = getPDO("[DBNAME]", "[HOST]", "[LOGIN]", "[PASSWORD]");

	$resDB1 = getTablesAndCols($BDD1, "`[HOST]`", "[PREFIX]", "[FILTER]");
	$resDB2 = getTablesAndCols($BDD2, "`[HOST]`", "[PREFIX]", "[FILTER]");

	$resArray = array();

	foreach ($resDB1 as $k => $table) {
		$tmpArray[$k] = array_diff($resDB2[$k], $resDB1[$k]);
		array_merge($tmpArray[$k], array_diff($resDB1[$k], $resDB2[$k]));
		if ($tmpArray[$k]) {
			$resArray[$k] = $tmpArray[$k];
		}
	}

	

	$result = print_r($resArray, true);

	if (!empty($result)) {
		echo("<pre>");
		echo $result;
		echo("</pre>");
	} else {
		echo "No differences";
	}

?>