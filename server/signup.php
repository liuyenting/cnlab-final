<html>
	<form name="form1" method="post">
		<table>
			<tr>
				<td>student_id</td>
				<td><input type="text" name="student_id"></td>
			</tr>
			<tr>
				<td><input type="submit" value="add record" name="submit1"></td>
			</tr>
		</table>
	</form>
</html>
<?php
	date_default_timezone_set('Asia/Taipei');
	$nowdate = date('Y-m-d'); // Current date
	echo $_POST['student_id'];
	if(isset($_POST['student_id'])) {
		$connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
		mysql_select_db('classroom', $connection);
		$result = mysql_query('SELECT Week FROM week_date_table WHERE Date=\''.$nowdate.'\'') or die ('fail');
		$week = mysql_fetch_row($result)[0];
		$result = mysql_query('SELECT Time FROM time_table WHERE Status=\'time_start\'') or die ('fail');
		$time_start = mysql_fetch_row($result)[0];
		$result = mysql_query('SELECT Time FROM time_table WHERE Status=\'time_end\'') or die ('fail');
		$time_end = mysql_fetch_row($result)[0];
		$current_time = date('H:i:s');
		$v1 = get_time_difference($time_start, $current_time);
		$v2 = get_time_difference($time_end, $current_time);
		if($v1 > 0 && $v1 < 600) { // 10 mins
			$result = mysql_query('UPDATE roll_call_table SET '.$week.' = 1 WHERE student_id =\''.$_POST['student_id'].'\'') or die ('fail');
		}
		else if($v2 > -600 && $v2 < 0) { // 10 mins
			$result = mysql_query('SELECT ' . $week . ' FROM roll_call_table WHERE student_id =\''.$_POST['student_id'].'\'') or die ('fail');
			$attended = mysql_fetch_row($result)[0];
			if($attended == 1) {
				$result = mysql_query('UPDATE roll_call_table SET '.$week.' = 2 WHERE student_id =\''.$_POST['student_id'].'\'') or die ('fail');
			}
		}
		echo $result;
		http_response_code(200);
		exit();
	}
	else {
		echo "no data";
		http_response_code(400);
		exit();
	}
function get_time_difference($time1, $time2) { // $time1 - $time2 seconds
	$time1 = strtotime("1/1/1980 $time1");
	$time2 = strtotime("1/1/1980 $time2");
	return ($time1 - $time2);
}
?>
