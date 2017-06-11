<?php
$connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
mysql_select_db('classroom', $connection);
$result2 = mysql_query('SELECT * FROM roll_call_table') or die ('cannot show columns from ');
echo "[";
if(mysql_num_rows($result2)) {
	$firstRow = true;
	while($row2 = mysql_fetch_row($result2)) {
		if($firstRow) {
			echo "{\"sid\": ";
			$firstRow = false;
		}
		else {
			echo ",{\"sid\": ";
		}
		$first = true;
		$second = true;
		foreach($row2 as $key => $value) {
			if($first) {
				echo "\"" . $value . "\",\"attendance\": [";
				$first = false;
				continue;
			}
			if($second) {
				echo $value;
				$second = false;
				continue;
			}
			echo ",".$value;
		}
		echo "]}";
	}
}
echo "]";
?>