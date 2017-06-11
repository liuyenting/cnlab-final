<?php
$connection = mysql_connect('localhost','root','plinderhaobunbuncnlab');
mysql_select_db('classroom',$connection);
$select = "SELECT * FROM roll_call_table";
$export = mysql_query($select) or die("Sql error : " . mysql_error());
$fields = mysql_num_fields($export);
for($i = 0; $i < $fields; $i++) {
	$header .= mysql_field_name($export , $i) . ",";
}
while($row = mysql_fetch_row($export)) {
	$line = '';
	foreach($row as $value) {
		if ((!isset($value)) || ($value == "")) {
			$value = ",";
		}
		else {
			$value = str_replace('"' , '""' , $value);
			$value = '"' . $value . '"' . ",";
		}
		$line .= $value;
	}
	$data .= trim($line) . "\n";
}
$data = str_replace("\r" , "" , $data);
if($data == "") {
	$data = "\n(0) Records Found!\n";                        
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=roll_call_table.csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>