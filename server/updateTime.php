<html>
	<form name="form1" method="post">
		Class starts from:<br>
		Hour:
		<select name="hour_start">
		<?php foreach (range(0,23) as $hour):?>
		<option value="<?php echo $hour;?>"><?php echo $hour;?></option>
		<?php endforeach?>
		</select>
		Minute:
		<select name="minute_start">
		<?php foreach (range(0,59) as $minute):?>
		<option value="<?php echo $minute;?>"><?php echo $minute;?></option>
		<?php endforeach?>
		</select>
		<br>Class ends at:<br>
		Hour:
		<select name="hour_end">
		<?php foreach (range(0,23) as $hour):?>
		<option value="<?php echo $hour;?>"><?php echo $hour;?></option>
		<?php endforeach?>
		</select>
		Minute:
		<select name="minute_end">
		<?php foreach (range(0,59) as $minute):?>
		<option value="<?php echo $minute;?>"><?php echo $minute;?></option>
		<?php endforeach?>
		</select>
		<br>
		<input type="submit" value="add record" name="submit1">
	</form>
</html>
<?php
if (isset($_POST['submit1'])) {
	date_default_timezone_set('Asia/Taipei');
	$time1 = date_create("1980-01-01");
	$time2 = date_create("1980-01-01");
	date_time_set($time1, (int)$_POST["hour_start"], (int)$_POST["minute_start"]); // Start time
	date_time_set($time2, (int)$_POST["hour_end"], (int)$_POST["minute_end"]); // End time
	echo date_format($time1 ,"H:i:s");
	$connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
	mysql_select_db('classroom', $connection);
	mysql_query("DELETE FROM time_table WHERE Status IS NOT NULL") or die('fail');
	mysql_query("INSERT INTO time_table (Status, Time) VALUES (\"time_start\", \"" . date_format($time1 ,"H:i:s") . "\")") or die('fail');
	mysql_query("INSERT INTO time_table (Status, Time) VALUES (\"time_end\", \"" . date_format($time2 ,"H:i:s") . "\")") or die('fail');
	mysql_close();
}
?>
