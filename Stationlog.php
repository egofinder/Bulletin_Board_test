<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
		<title>EVENT LOGS</title>
<?php 
include("common_setting.php");
include('db_connect.php');
?>
</head>

<body>
<form action="Stationlog.php" method="get">
	<div id="topbox">
		<input type="hidden" name="limit1">
		<input type="hidden" name="page_section">

		<table id="table">
			<tr>
    			<th id="header" style="font-size:50px; height: 50px; margin: 0px; padding: 0px;" colspan = "2">EVENT LOGS</th>
			</tr>
			<tr>
		  		<td id="topboxtd"  style = "width:50%">
				<input type="radio" name="type_select" id="radio1" class="css-checkbox" value="CE" <?php if ($_GET["type_select"] == "CE"){echo "checked";} ?> >
				<label for="radio1" class="css-label radGroup2">Critical-Event</label></td>
				<td id="topboxtd"  style = "width:50%">
				<input type="radio" name="type_select" id="radio2" class="css-checkbox" value="AI" <?php if ($_GET["type_select"] == "AI"){echo "checked";} ?> >
				<label for="radio2" class="css-label radGroup2">AFT-IN</label></td>
			</tr>	
			<tr>
		  		<td id="topboxtd" style = "width:50%">
				<input type="radio" name="type_select" id="radio3" class="css-checkbox" value="VI" <?php if ($_GET["type_select"] == "VI"){echo "checked";} ?> >
				<label for="radio3" class="css-label radGroup2">Voucher-IN</label></td>
				<td id="topboxtd" style = "width:50%">
				<input type="radio" name="type_select" id="radio4" class="css-checkbox" value="VO" <?php if ($_GET["type_select"] == "VO"){echo "checked";} ?> >
				<label for="radio4" class="css-label radGroup2">Voucher-OUT</label></td>
			</tr>
			<tr>
				<td id="topboxtd" style="width:50%;">
				<input type="radio" name="type_select" id="radio5" class="css-checkbox" value="BI" <?php if ($_GET["type_select"] == "BI"){echo "checked";} ?> >
				<label for="radio5" class="css-label radGroup2">Bill-IN</label></td>
	  			<td id="topboxtd" style="width:50%;">
				<input type="radio" name="type_select" id="radio6" class="css-checkbox" value="HP" <?php if ($_GET["type_select"] == "HP"){echo "checked";} ?> >
				<label for="radio6" class="css-label radGroup2">Handpay</label></td>
			</tr>
		</table>
	</div>

	<div id="topbox">
		<table id="table">
			<tr>
				<td id="topboxtd" style="width:20%">FROM</td>
				<td id="topboxtd" style="width:25%"><label class="date"><input style="font-size:36px; width: 350px; border: 0px"; name="start_date" placeholder="Start Date"></label></td>
				<td id="topboxtd" style="width:20%">TO</td>
				<td id="topboxtd" style="width:25%"><label class="date"><input style="font-size:36px; width: 350px; border: 0px"; name="end_date" placeholder="End Date"></label></td>
				<td id="topboxtd" style="width:10%"><input class="btnExample" type="submit" value="SEARCH"></td>
			</tr>
		</table>
	</div>
	<div id="topbox">
		<table id="table">
			<tr>
				<td id="topboxtd" style="width:30%;">GAME NO</td>
				<td id="topboxtd" style="width:20%;"><input style="font-size:30px;" type="text" name="game_number" placeholder="DD-NN"></td>
<?php
$machine_select = $_GET["machine_select"];
$cabinet_number = $_GET["cabinet_number"];
if($machine_select == 'C'){
	echo "<input type='hidden' name='cabinet_number' value='$cabinet_number'>
			<input type='hidden' name='machine_select' value='C'>
			<td id='topboxtd' style='width:30%;'>CABINET NO</td>
			<td id='topboxtd' style='width:20%;'>$cabinet_number</td>";
}
else{
	echo "<input type='hidden' name='machine_select' value='S'>
			<td id='topboxtd' style='width:30%;'>CABINET NO</td>
			<td id='topboxtd' style='width:20%;'><input style='font-size:30px;' name='cabinet_number' placeholder='X'></td>";
}
?>
			</tr>
		</table>
	</div>
</form>

<div id="bottombox">
	<table id="table">
		<tr id="header">
			<th style='width:5%'>NO</th>
			<th style='width:15%'>DATE</th>
			<th style='width:10%'>GAME NO</th>
			<th style='width:55%'>INFO</th>
			<th style='width:15%'>CABINET NO</th>
		</tr>

<?php
$type_select = $_GET["type_select"];

switch($type_select){
	case "CE":
	$type_select_status = "AND ITEM_HEX = '0x00004001'";
	break;
	case "VI":
	$type_select_status = "AND ITEM_HEX = '0x00005004'";
	break;
	case "VO":
	$type_select_status = "AND ITEM_HEX = '0x0000400D'";
	break;
	case "BI":
	$type_select_status = "AND ITEM_HEX = '0x00005003'";
	break;
	case "AI":
	$type_select_status = "AND ITEM_HEX = '0x00011001'";
	break;
	case "HP":
	$type_select_status = "AND ITEM_HEX = '0x00009010'";
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

if(!empty($start_date)){ $start_date_status = "AND DATE>= '$start_date'"; }
else{ $start_date_status = ''; }

if(!empty($end_date)){ $end_date_status = "AND DATE<= '$end_date'"; }
else{ $end_date_status = ''; }

if(!empty($game_number)){ $game_number_status = "AND GN = '$game_number'"; }
else{$game_number_status = '';}

if(!empty($cabinet_number)){ $cabinet_number_status = "AND CBN = '$cabinet_number'"; }
else{$cabinet_number_status = '';}

////////////////////////////////////////////////////////////////////////Count Number of row/////////////////////////////////////////////////
$count = mysql_query("SELECT SEQ FROM stationlog WHERE 1 $type_select_status $game_number_status $cabinet_number_status $start_date_status $end_date_status");
$count = mysql_num_rows($count);

if($count > ($number_of_list*$page_number_limit)){ $total_page_section = ceil($count/($number_of_list*$page_number_limit)); }
else{ $total_page_section = 1; $page_section = 1; }

$result = mysql_query("SELECT * FROM stationlog WHERE 1 $type_select_status $game_number_status $cabinet_number_status $start_date_status $end_date_status $limit_status");
	for($i = 1; $i <= ($number_of_list/2); $i++)
	{
		$limit1 = $limit1 + 1;
		if($count == 0){$row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[6] = '';}
		else{ $row_array = mysql_fetch_row($result); }
		echo "<tr id='alt'>
		<td>$limit1</td>
		<td>$row_array[1]</td>
		<td>$row_array[2]</td>
		<td>$row_array[6]</td>
		<td>$row_array[3]</td>
		</tr>";

		$limit1 = $limit1 + 1;
		if($count == 0){$row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[6] = '';}
		else{ $row_array = mysql_fetch_row($result); }
		echo "<tr id='alt2'>
		<td>$limit1</td>
		<td>$row_array[1]</td>
		<td>$row_array[2]</td>
		<td>$row_array[6]</td>
		<td>$row_array[3]</td>
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
echo "<div class='link' align = 'center'>";
echo "<table style = 'text-align: center'>";
echo "<tr>";

$total_page = ceil($count/$number_of_list);
$show_page = $page_number_limit*$page_section;
if($show_page > $total_page){ $show_page = $total_page; }

	if($page_section >= 2){
		echo "<td style='font-size:34px;'>";
		$page_section = $page_section - 1;
		$limit1 = ($page_section-1) * $page_number_limit*$number_of_list+$number_of_list*($page_number_limit-1); 
		echo "<a href=Stationlog.php?type_select=$type_select&page_section=$page_section&machine_select=$machine_select&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[PREV]</a>"; 
		echo "</td>";
		$page_section = $page_section + 1;
	}

for($i = 1 + $page_number_limit*($page_section-1); $i <= $show_page; $i++){
		echo "<td style='font-size:34px;'>";
		$limit1 = ($i-1)*$number_of_list;
		if($i == $now_page){ echo "<B><a style='color: #6a1b9a'; href=Stationlog.php?type_select=$type_select&page_section=$page_section&machine_select=$machine_select&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[$i]</a></B>"; }
		else{ echo "<a href=Stationlog.php?type_select=$type_select&page_section=$page_section&machine_select=$machine_select&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[$i]</a>"; }
		echo "</td>";
	}

	if($page_section < $total_page_section){
		echo "<td style='font-size:34px;'>";
		$limit1 = $limit1 + $number_of_list;
		$page_section = $page_section+1;
		echo "<a href=Stationlog.php?type_select=$type_select&page_section=$page_section&machine_select=$machine_select&start_date=$start_date&end_date=$end_date&game_number=$game_number&cabinet_number=$cabinet_number&limit1=$limit1>[NEXT]</a>";
		echo "</td>";
		$page_section = $page_section-1;
	}

?>
</tr>
</table>
</div>
</body>
</html>