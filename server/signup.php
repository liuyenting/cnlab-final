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
    $nowdate = date('Y-m-d');
    echo $_POST['student_id'];
    if (isset($_POST['student_id'])) {
        $connection = mysql_connect('localhost', 'root', 'plinderhaobunbuncnlab');
        mysql_select_db('classroom', $connection);
        $result1 = mysql_query('select Week from week_date_table where Date=\''.$nowdate.'\'') or die('fail');
	$row = mysql_fetch_row($result1)[0];
        $result = mysql_query('UPDATE roll_call_table set '.$row.' = 1 WHERE student_id =\''.$_POST['student_id'].'\'') or die('fail');
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
