<html>
	<form name="form1" method="post">
		<table>
			<tr>
				<td>student_id</td>
				<td><input type="text" name="student_id"></td>
				<td>week</td>
				<td><input type="text" name="week"></td>
			</tr>
			<tr>
				<td><input type="submit" value="toggle record" name="submit1"></td>
			</tr>
		</table>
	</form>
</html>
<?php
	$week = (int)$_POST['week'] - 1;
	if(isset($_POST['student_id'])) {
		$connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
		mysql_select_db('classroom', $connection);
		$result = mysql_query('UPDATE roll_call_table set wk'.$week.' = IF(wk'.$week.'!=0, 0, 2) WHERE student_id =\''.$_POST['student_id'].'\'') or die('fail');
		echo $result;
		http_response_code(200);
		exit();
	}
	else {
		echo "no data";
		http_response_code(400);
		exit();
	}
?>
