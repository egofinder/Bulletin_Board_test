<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Accounting</title>
<?php 
include("common_setting.php");
include('db_connect.php');
?>
</head>

<body>
	<div id="topbox">
		<form action="Accounting.php" method="get">
		<input type="hidden" name="limit1">
		<input type="hidden" name="page_section">
		<table id="table">
			<tr>
    			<th id='header' style='font-size:55px; height: 80px;' colspan='3'>ACCOUNTING</th>
    		</tr>
			<tr>
				<td id="topboxtd" style="width:357px;"><input type="radio" name="in_out_select" id="radio1" class="css-checkbox" value="ALL" <?php if ($_GET["in_out_select"] == "ALL"){echo "checked";} ?>>
				<label for="radio1" class="css-label radGroup1">MONEY IN&OUT</label></td>
	  			<td id="topboxtd" style="width:345px"><input type="radio" name="in_out_select" id="radio2" class="css-checkbox" value="I" <?php if ($_GET["in_out_select"] == "I"){echo "checked";} ?>>
				<label for="radio2" class="css-label radGroup1">MONEY IN</label></td>
	  			<td id="topboxtd" style="width:345px;"><input type="radio" name="in_out_select" id="radio3" class="css-checkbox" value="O" <?php if ($_GET["in_out_select"] == "O"){echo "checked";} ?>>
				<label for="radio3" class="css-label radGroup1">MONEY OUT</label></td>
			</tr>
		</table>
	</div>
	<div id="topbox">
		<table id="table">
			<tr>
				<td id="topboxtd" style="width:190px;"><input type="radio" name="type_select" id="radio4" class="css-checkbox" value="ALL" <?php if ($_GET["type_select"] == "ALL"){echo "checked";} ?>>
				<label for="radio4" class="css-label radGroup2">ALL</label></td>

				<td id="topboxtd" style="width:190px;"><input type="radio" name="type_select" id="radio5" class="css-checkbox" value="B" <?php if ($_GET["type_select"] == "B"){echo "checked";} ?>>
				<label for="radio5" class="css-label radGroup2">BILL</label></td>

				<td id="topboxtd" style="width:199px;"><input type="radio" name="type_select" id="radio6" class="css-checkbox" value="T" <?php if ($_GET["type_select"] == "T"){echo "checked";} ?>>
				<label for="radio6" class="css-label radGroup2">TICKET</label></td>

				<td id="topboxtd" style="width:190px;"><input type="radio" name="type_select" id="radio7" class="css-checkbox" value="A" <?php if ($_GET["type_select"] == "A"){echo "checked";} ?>>
				<label for="radio7" class="css-label radGroup2">AFT</label></td>

				<td id="topboxtd" style="width:270px;"><input type="radio" name="type_select" id="radio8" class="css-checkbox" value="H" <?php if ($_GET["type_select"] == "H"){echo "checked";} ?>>
				<label for="radio8" class="css-label radGroup2">HANDPAY</label></td>
			</tr>
		</table>
	</div>
	<div id="topbox">
		<table id="table">
			<tr>
				<td id="topboxtd" style="width:150px">FROM</td>
				<td id="topboxtd" style="width:200px"><label class="date"><input style="font-size:36px; width:200px;"; name="start_date" placeholder="Start Date"></label></td>
				<td id="topboxtd" style="width:150px">TO</td>
				<td id="topboxtd" style="width:200px"><label class="date"><input style="font-size:36px; width:200px;"; type="text" name="end_date" placeholder="End Date"></label></td>
				<td id="topboxtd" style="width:317px"><input class="btnExample" type="submit" value="SEARCH"></td>
			</tr>
		</table>
	</div>
	<div id="topbox">
		<table id="table">
			<tr>
				<td id="topboxtd" style="width:200px;">GAME NO</td>
				<td id="topboxtd" style="width:300px;"><input style="font-size:36px; width:200px;"; type="text" name="game_number" placeholder="DD-NN"></td>
<?php
$machine_select = $_GET["machine_select"];
$cabinet_number = $_GET["cabinet_number"];
if($machine_select == 'C'){
	echo "<input type='hidden' name='cabinet_number' value='$cabinet_number'>
			<input type='hidden' name='machine_select' value='C'>
			<td id='topboxtd'' style='width:238px;'>CABINET NO</td>
			<td id='topboxtd' style='width:295px;'>$cabinet_number</td>";
}
else{
	echo "<input type='hidden' name='machine_select' value='S'>
			<td id='topboxtd'' style='width:238px;'>CABINET NO</td>
			<td id='topboxtd'' style='width:295px;'><input style='font-size:36px; width:200px;' type='text' name='cabinet_number' placeholder='X'></td>";
}
?>
			</tr>
		</table>
		</form>
</div>

<!--........Intentionally make blank space..........-->
<div style="border: 0px;"><table><tr><td style="border: 0px;"></td></tr></table></div>

<div id="bottombox">
	<table id="table">
		<tr id="header">
			<th style='width:40px'>NO</th>
			<th style='width:180px'>DATE</th>
			<th style='width:120px'>GAME NO</th>
			<th style='width:540px'>INFO</th>
			<th style='width:120px'>CABINET NO</th>
		</tr>

<?php
$select1 = $_GET["in_out_select"];
$select2 = $_GET["type_select"];

switch($select1){
	case "ALL":
	$select1_status = "AND IN_OUT IS NOT NULL";
	break;
	case "I":
	$select1_status = "AND IN_OUT = 'I'";
	break;
	case "O":
	$select1_status = "AND IN_OUT = 'O'";
	break;
}

switch($select2){
	case "ALL":
	$select2_status = "AND TYPE IS NOT NULL";
	break;
	case "B":
	$select2_status = "AND TYPE = 'B'";
	break;
	case "T":
	$select2_status = "AND TYPE = 'T'";
	break;
	case "A":
	$select2_status = "AND TYPE = 'A'";
	break;
	case "H":
	$select2_status = "AND TYPE = 'H'";
	break;
}

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];

if(!empty($end_date)){
	$end_date = strtotime($end_date) + 3600*24; //ADD 1 day to selected END DATE
	$end_date = date('Y-m-d', $end_date); //Change Format to YYYY-mm-dd
}
else{}

$game_number = $_GET["game_number"];
$limit1 = $_GET["limit1"];
$page_section = $_GET["page_section"];
if(empty($page_section)){$page_section = 1;}

if(!empty($limit1)){ $now_page = ($limit1/$number_of_list)+1; }
else{ $now_page = 1; }

if(empty($limit1)){ $limit1 = 0; }
$limit_status = "ORDER BY SEQ DESC LIMIT $limit1, $number_of_list";

if(!empty($start_date)){ $start_date_status = "AND DATE1>= '$start_date'"; }
else{ $start_date_status = ''; }

if(!empty($end_date)){ $end_date_status = "AND DATE1<= '$end_date'"; }
else{ $end_date_status = ''; }

if(!empty($game_number)){ $game_number_status = "AND GN = '$game_number'"; }
else{$game_number_status = '';}

if(!empty($cabinet_number)){ $cabinet_number_status = "AND CBN = '$cabinet_number'"; }
else{$cabinet_number_status = '';}

//Count Number of row/////////////////////////////////////////////////
$count = mysql_query("SELECT SEQ FROM accounting WHERE 1 $select1_status $select2_status $game_number_status $cabinet_number_status $start_date_status $end_date_status");
$count = mysql_num_rows($count);

if($count > ($number_of_list*$page_number_limit)){ $total_page_section = ceil($count/($number_of_list*$page_number_limit)); }
else{ $total_page_section = 1; $page_section = 1; }

$result = mysql_query("SELECT * FROM accounting WHERE 1 $select1_status $select2_status $game_number_status $cabinet_number_status $start_date_status $end_date_status $limit_status");
	for($i = 1; $i <= ($number_of_list/2); $i++){
		$limit1 = $limit1 + 1;
		if($count == 0){$row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[6] = '';}
		else{ $row_array = mysql_fetch_row($result); }
		echo "<tr id='alt'>
		<td>$limit1</td>
		<td>$row_array[1]</td>
		<td>$row_array[2]</td>
		<td>$row_array[3]</td>
		<td>$row_array[6]</td>
		</tr>";

		$limit1 = $limit1 + 1;
		if($count == 0){$row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[6] = '';}
		else{ $row_array = mysql_fetch_row($result); }
		echo "<tr id='alt2'>
		<td>$limit1</td>
		<td>$row_array[1]</td>
		<td>$row_array[2]</td>
		<td>$row_array[3]</td>
		<td>$row_array[6]</td>
		</tr>";
	}

include('db_close.php'); 
?>
	</table>

</div>
<?php		
//When data can't display one page, it will make number of links.

if(!empty($end_date)){
	$end_date = strtotime($end_date) - 3600*24; //Since 1 days added beginning, now subtract.
	$end_date = date('Y-m-d', $end_date); //Set date format to YYYY-mm-dd.
}
echo "<div class='link'>";
echo "<table id='table'>";
echo "<tr>";

$total_page = ceil($count/$number_of_list);
$show_page = $page_number_limit*$page_section;
if($show_page > $total_page){$show_page = $total_page;}

	if($page_section >= 2){
		echo "<td style='font-size:36px;'>";
		$page_section = $page_section - 1;
		$limit1 = ($page_section-1) * $page_number_limit*$number_of_list+$number_of_list*($page_number_limit-1);
		echo "<a href=Accounting.php?page_section=$page_section&machine_select=$machine_select&in_out_select=$select1&type_select=$select2&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[PREV]</a>"; 
		echo "</td>";
		$page_section = $page_section + 1;

	}

for($i = 1 + $page_number_limit*($page_section-1); $i <= $show_page; $i++){
		echo "<td style='font-size:36px;'>";
		$limit1 = ($i-1)*$number_of_list;
		if($i == $now_page){ echo "<B><a style='color: #6a1b9a'; href=Accounting.php?page_section=$page_section&machine_select=$machine_select&in_out_select=$select1&type_select=$select2&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[$i]</a></B>"; }
		else{ echo "<a href=Accounting.php?page_section=$page_section&machine_select=$machine_select&in_out_select=$select1&type_select=$select2&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[$i]</a>"; }
		echo "</td>";
	}

	if($page_section < $total_page_section){
		echo "<td style='font-size:36px;'>";
		$limit1 = $limit1 + $number_of_list;
		$page_section = $page_section+1;
		echo "<a href=Accounting.php?page_section=$page_section&machine_select=$machine_select&in_out_select=$select1&type_select=$select2&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[NEXT]</a>";
		echo "</td>";
		$page_section = $page_section-1;
	}

?>
</tr>
</table>
</div>
</body>
</html>