<?php
$con = mysql_connect("ID", "User", "Password") or die ("Fail");
mysql_query("DROP DATABASE test");
mysql_query("CREATE DATABASE test CHARACTER SET ascii COLLATE ascii_general_ci");
mysql_query("USE test");
mysql_query("CREATE TABLE server(SEQ INT(11) NOT NULL AUTO_INCREMENT, PW CHAR(20), PRIMARY KEY (SEQ))");
mysql_query("CREATE TABLE about(SEQ INT(11) NOT NULL AUTO_INCREMENT, GNME CHAR(30), CPN CHAR(20), BCT CHAR(30), TNSP CHAR(30), EMAIL CHAR(30), ADR CHAR(60), PRIMARY KEY (SEQ))");
mysql_query("CREATE TABLE stationlog(SEQ INT(11) NOT NULL AUTO_INCREMENT, DATE DATETIME, GN CHAR(7), CBN CHAR(12) NOT NULL DEFAULT 0, ITEM INT(11) NOT NULL DEFAULT 0, ITEM_HEX CHAR(10), TEXT VARCHAR(60), PRIMARY KEY (SEQ))");
mysql_query("CREATE TABLE dividend(SEQ INT(11) NOT NULL AUTO_INCREMENT, GAMEID INT(11) NOT NULL DEFAULT 0, DATE DATETIME, GN CHAR(7), HEC TINYINT(4) NOT NULL DEFAULT 0, RANK CHAR(10), WIN VARCHAR(80), DIV_SHOW VARCHAR(80), QU VARCHAR(400), EX VARCHAR(870), PRIMARY KEY (SEQ))");
mysql_query("CREATE TABLE userbet(SEQ INT(11) NOT NULL AUTO_INCREMENT, GAMEID INT(11) NOT NULL DEFAULT 0, DATE DATETIME, GN CHAR(7),  CBN CHAR(12) NOT NULL DEFAULT 0, PS INT(11) NOT NULL DEFAULT 0, BS INT(11) NOT NULL DEFAULT 0, HEC TINYINT(4) NOT NULL DEFAULT 0, CS INT(11) NOT NULL DEFAULT 0, WIN VARCHAR(80), DIV_SHOW VARCHAR(80), QU VARCHAR(400), EX VARCHAR(870), PRIMARY KEY (SEQ))");
mysql_query("INSERT INTO `server`(`SEQ`, `PW`) VALUES(NULL, 'test.com');");

if(mysql_close($con)){
  echo "Success";
}
else{
  echo "Fail";
}
?>