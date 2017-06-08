<style type="text/css">
table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>
<?php
$student_id = $_POST[student_id];
$connection = mysql_connect('localhost','root','plinderhaobunbuncnlab');
mysql_select_db('classroom',$connection);
$result = mysql_query('SHOW TABLES',$connection) or die('cannot show tables');
while($tableName = mysql_fetch_row($result)) {
	$table = $tableName[0];
	echo '<h3>',$table,'</h3>';
	if($student_id)
		$result2 = mysql_query('SELECT * FROM '.$table.' WHERE student_id=\''.$student_id.'\'') or die('cannot show columns from '.$table);
	else
		$result2 = mysql_query('SELECT * FROM '.$table) or die('cannot show columns from '.$table);
	if(mysql_num_rows($result2)) {
		echo '<table cellpadding="0" cellspacing="0" class="db-table">';
		echo '<tr><th>student_id</th><th>wk0</th><th>wk1</th><th>wk2</th></tr>'; //TODO update total week number
		while($row2 = mysql_fetch_row($result2)) {
			echo '<tr>';
			foreach($row2 as $key=>$value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		}
		echo '</table><br />';
	}
	else {
		if($student_id)
			echo 'no record for '.$student_id;
		else
			echo 'no record for table classroom';
	}
}
?>
