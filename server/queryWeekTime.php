<html>
	<form name="form1" method="post">
	<select name="content">
		<option value="time_table">Time</option>
		<option value="week_date_table">Week</option>
	</select>
	<input type="submit" value="search" name="submit1">
	</form>
</html>
<?php
if(isset($_POST['content'])) {
	echo $_POST['content'];
	$connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
	mysql_select_db('classroom', $connection);
	$result2 = mysql_query('SELECT * FROM ' . $_POST['content']) or die ('fail');
	echo "[";
	if(mysql_num_rows($result2)) {
		$firstRow = true;
		while($row2 = mysql_fetch_row($result2)) {
			if($firstRow) {
				echo "{\"status\": ";
				$firstRow = false;
			}
			else {
				echo ",{\"status\": ";
			}
			echo "\"" . $row2[0] . "\",\"content\": \"" . $row2[1] . "\"}";
		}
	}
	echo "]";
}
?>