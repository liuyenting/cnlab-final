# upload.php  
enroll to Kairos gallery **Demo**  
  
# Initialize SQL tables  
We starts with a database called _classroom_.
```
CREATE DATABASE classroom;  
```
Simple schema for the signup sheets, targted for an 18w course.
```
CREATE TABLE week_date_table(Week VARCHAR(20), Date VARCHAR(20));  
CREATE TABLE roll_call_table(student_id VARCHAR(20), wk0 INT, wk1 INT, wk2 INT, wk3 INT, wk4 INT, wk5 INT, wk6 INT, wk7 INT, wk8 INT, wk9 INT, wk10 INT, wk11 INT, wk12 INT, wk13 INT, wk14 INT, wk15 INT, wk16 INT, wk17 INT);  
CREATE TABLE time_table(Status VARCHAR(20), Time VARCHAR(20));  
```

# SQL settings  
```
show databases;
```
```
+--------------------+  
| Database           |  
+--------------------+  
| information_schema |  
| classroom          |  
| mysql              |  
| performance_schema |  
| test               |  
+--------------------+  
```
---
```
show tables;  
```
```
+---------------------+  
| Tables_in_classroom |  
+---------------------+  
| roll_call_table     |  
| week_date_table     |  
+---------------------+  
```
---
```
describe roll_call_table;
```
```
+------------+-------------+------+-----+---------+-------+  
| Field      | Type        | Null | Key | Default | Extra |  
+------------+-------------+------+-----+---------+-------+  
| student_id | varchar(20) | YES  |     | NULL    |       |  
| wk0        | int(11)     | YES  |     | NULL    |       |  
| wk1        | int(11)     | YES  |     | NULL    |       |  
| wk2        | int(11)     | YES  |     | NULL    |       |  
| wk3        | int(11)     | YES  |     | NULL    |       |  
| wk4        | int(11)     | YES  |     | NULL    |       |  
| wk5        | int(11)     | YES  |     | NULL    |       |  
| wk6        | int(11)     | YES  |     | NULL    |       |  
| wk7        | int(11)     | YES  |     | NULL    |       |  
| wk8        | int(11)     | YES  |     | NULL    |       |  
| wk9        | int(11)     | YES  |     | NULL    |       |  
| wk10       | int(11)     | YES  |     | NULL    |       |  
| wk11       | int(11)     | YES  |     | NULL    |       |  
| wk12       | int(11)     | YES  |     | NULL    |       |  
| wk13       | int(11)     | YES  |     | NULL    |       |  
| wk14       | int(11)     | YES  |     | NULL    |       |  
| wk15       | int(11)     | YES  |     | NULL    |       |  
| wk16       | int(11)     | YES  |     | NULL    |       |  
| wk17       | int(11)     | YES  |     | NULL    |       |  
+------------+-------------+------+-----+---------+-------+  
```
---
```
describe week_date_table;
```
```
+-------+-------------+------+-----+---------+-------+  
| Field | Type        | Null | Key | Default | Extra |  
+-------+-------------+------+-----+---------+-------+  
| Week  | varchar(20) | YES  |     | NULL    |       |  
| Date  | varchar(20) | YES  |     | NULL    |       |  
+-------+-------------+------+-----+---------+-------+  
```
---
```
describe time_table;
```
```
+--------+-------------+------+-----+---------+-------+  
| Field  | Type        | Null | Key | Default | Extra |  
+--------+-------------+------+-----+---------+-------+  
| Status | varchar(20) | YES  |     | NULL    |       |  
| Time   | varchar(20) | YES  |     | NULL    |       |  
+--------+-------------+------+-----+---------+-------+  
```
