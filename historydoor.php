<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
		<title>History Door</title>

<?php 
include("common_setting.php");
include('db_connect.php');
?>
</head>

<body>
	<div id="topbox">
		<form action="Historydoor.php" method="get">
			<table id='table'>
				<tr>
   					<th id='header' style='font-size:55px; height: 80px;'>DOOR HISTORY</th>
    			</tr>
				<tr>
    				<td id="topboxtd" style="width:1041px;"><input type="radio" name="type_select" id="radio15" class="css-checkbox" value="ALL" <?php if ($_GET["type_select"] == "ALL"){echo "checked";} ?> >
					<label for="radio15" class="css-label radGroup2">ALL</label></td>
				</tr>
			</table>
		</div>
		<div id="topbox">
			<table id="table">
				<tr>
		  			<td id="topboxtd" style="width:260px;"><input type="radio" name="type_select" id="radio16" class="css-checkbox" value="C" <?php if ($_GET["type_select"] == "C"){echo "checked";} ?> >
					<label for="radio16" class="css-label radGroup2">Cabinet</label></td>
		  			<td id="topboxtd" style="width:260px;"><input type="radio" name="type_select" id="radio17" class="css-checkbox" value="B" <?php if ($_GET["type_select"] == "B"){echo "checked";} ?> >
					<label for="radio17" class="css-label radGroup2">Belly</label></td>
    				<td id="topboxtd" style="width:260px;"><input type="radio" name="type_select" id="radio18" class="css-checkbox" value="S" <?php if ($_GET["type_select"] == "S"){echo "checked";} ?> >
					<label for="radio18" class="css-label radGroup2">Stacker</label></td>
	  				<td id="topboxtd" style="width:260px;"><input type="radio" name="type_select" id="radio19" class="css-checkbox" value="L" <?php if ($_GET["type_select"] == "L"){echo "checked";} ?> >
					<label for="radio19" class="css-label radGroup2">LogicBox</label></td>
				</tr>
			</table>
		</div>
		<div id="topbox">
			<table id="table">
			<tr>
				<td id="topboxtd" style="width:150px;">FROM</td>
				<td id="topboxtd" style="width:200px;"><label class="date"><input style="font-size:36px; width:200px;"; name="start_date" placeholder="Start Date"></label></td>
				<td id="topboxtd" style="width:150px;">TO</td>
				<td id="topboxtd" style="width:200px;"><label class="date"><input style="font-size:36px; width:200px;"; type="text" name="end_date" placeholder="End Date"></label></td>
				<td id="topboxtd" style="width:317px;"><input class="btnExample" type="submit" value="SEARCH"></td>
			</tr>
			</table>
		</div>
		<div id="topbox">
			<table id="table">
			<tr>
<?php
$machine_select = $_GET["machine_select"];
$cabinet_number = $_GET["cabinet_number"];
if($machine_select == 'C'){
	echo "<input type='hidden' name='machine_select' value='C'>
			<input type='hidden' name='cabinet_number' value='$cabinet_number'>	
			<td id='topboxtd' style='width:500px;'>CABINET NO</td>
			<td id='topboxtd' style='width:541px;'>$cabinet_number</td>";			
}
else{ echo "<input type='hidden' name='machine_select' value='S'>
				<td id='topboxtd' style='width:500px;'>CABINET NO</td>
				<td id='topboxtd' style='width:541px;'><input style='font-size:36px; width:200px;' type='text' name='cabinet_number' placeholder='X'></td>";
}
?>
				</tr>
			</table>
		</div>
<input type="hidden" name="limit1">
<input type="hidden" name="page_section">
	</form>
</div>
<!--........Intentionally make blank space..........-->
<div style="border: 0px;"><table><tr><td style="border: 0px;"></td></tr></table></div>

<!--........Intentionally make blank space..........-->
<div style="border: 0px;"><table><tr><td style="border: 0px;"></td></tr></table></div>


<div id="bottombox">
	<table id="table">
		<tr id="header">
      		<th style='width:40px'>NO</th>
			<th style='width:180px'>DATE</th>
			<th style='width:120px'>GAME NO</th>
     	 	<th style='width:270px'>DOOR TYPE</th>
    	 	<th style='width:270px'>DOOR STATUS</th>
		 	<th style='width:120px'>CABINET NO</th>
		</tr>

<?php
$type_select = $_GET["type_select"];

switch($type_select){
	case "ALL":
	$type_select_status = "AND DT IS NOT NULL";
	break;
	case "C":
	$type_select_status = "AND DT = 'C'";
	break;
	case "B":
	$type_select_status = "AND DT = 'B'";
	break;
	case "S":
	$type_select_status = "AND DT = 'S'";
	break;
	case "L":
	$type_select_status = "AND DT = 'L'";
	break;
}

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
if(!empty($end_date)){
	$end_date = strtotime($end_date) + 3600*24; //ADD 1 day to selected END DATE
	$end_date = date('Y-m-d', $end_date); //Change Format to YYYY-mm-dd
}
else{}
$limit1 = $_GET["limit1"];
$page_section = $_GET["page_section"];
if(empty($page_section)){$page_section = 1;}

if(!empty($limit1)){ $now_page = ceil($limit1/$number_of_list)+1; }
else{ $now_page = 1;}

if(empty($limit1)){ $limit1 = 0;}
$limit_status = "ORDER BY SEQ DESC LIMIT $limit1, $number_of_list";

if(!empty($start_date)){ $start_date_status = "AND DATE1>= '$start_date'"; }
else{ $start_date_status = '';}

if(!empty($end_date)){ $end_date_status = "AND DATE1<= '$end_date'"; }
else{ $end_date_status = '';}

if(!empty($cabinet_number)){ $cabinet_number_status = "AND CBN ='$cabinet_number'"; }
else{ $cabinet_number_status = '';}

//Count Number of row///////////////////////////////////////////////////////////////////////////
$count = mysql_query("SELECT SEQ FROM historydoor WHERE 1 $type_select_status $start_date_status $end_date_status $cabinet_number_status");
$count = mysql_num_rows($count);

if($count > ($number_of_list*$page_number_limit)){ $total_page_section = ceil($count/($number_of_list*$page_number_limit)); }
else{ $total_page_section = 1; $page_section = 1; }

$result = mysql_query("SELECT * FROM historydoor WHERE 1 $type_select_status $start_date_status $end_date_status $cabinet_number_status $limit_status");

for($i = 1; $i <= ($number_of_list/2); $i++){
	$limit1 = $limit1 + 1;
	if($count == 0){ $row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[4]=''; $row_array[5]=''; }
	else{ $row_array = mysql_fetch_row($result); }
	switch($row_array[4]){
		case "C":
		$row_array[4] = "Cabinet";
		break;

		case "B":
		$row_array[4] = "Belly";
		break;

		case "S":
		$row_array[4] = "Stacker";
		break;

		case "L":
		$row_array[4] = "LogicBox";
		break;
	}
	switch($row_array[5]){
		case "O";
		$row_array[5] = "OPEN";
		break;

		case "C";
		$row_array[5] = "CLOSED";
		break;
	}
echo "<tr id='alt'>
		<td>$limit1</td>
		<td>$row_array[2]</td>
		<td>$row_array[3]</td>
        <td>$row_array[4]</td>
		<td>$row_array[5]</td>
		<td>$row_array[1]</td>
	</tr>";

	$limit1 = $limit1 + 1;
	if($count == 0){ $row_array[1] = ''; $row_array[2] = ''; $row_array[3] = ''; $row_array[4]=''; $row_array[5]=''; }
	else{ $row_array = mysql_fetch_row($result); }
	switch($row_array[4]){
		case "C":
		$row_array[4] = "Cabinet";
		break;

		case "B":
		$row_array[4] = "Belly";
		break;

		case "S":
		$row_array[4] = "Stacker";
		break;

		case "L":
		$row_array[4] = "LogicBox";
		break;
	}
	switch($row_array[5]){
		case "O";
		$row_array[5] = "OPEN";
		break;

		case "C";
		$row_array[5] = "CLOSED";
		break;
	}
echo "<tr id='alt2'>
		<td>$limit1</td>
		<td>$row_array[2]</td>
		<td>$row_array[3]</td>
		<td>$row_array[4]</td>
		<td>$row_array[5]</td>
		<td>$row_array[1]</td>
	</tr>";

}
include('db_close.php')
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
		echo "<a href=Historydoor.php?page_section=$page_section&type_select=$type_select&start_date=$start_date&end_date=$end_date&limit1=$limit1&cabinet_number=$cabinet_number&machine_select=$machine_select>[PREV]</a>"; 
		echo "</td>";
		$page_section = $page_section + 1;
		
	}

for($i = 1 + $page_number_limit*($page_section-1); $i <= $show_page; $i++){
	echo "<td style='font-size:36px;'>";
	$limit1 = ($i-1)*$number_of_list;
	if($i == $now_page){ echo "<B><a style='color: #6a1b9a'; href=Historydoor.php?page_section=$page_section&type_select=$type_select&start_date=$start_date&end_date=$end_date&limit1=$limit1&cabinet_number=$cabinet_number&machine_select=$machine_select>[$i]</a></B>"; }
	else{echo "<a href=Historydoor.php?page_section=$page_section&type_select=$type_select&start_date=$start_date&end_date=$end_date&limit1=$limit1&cabinet_number=$cabinet_number&machine_select=$machine_select>[$i]</a>";}
	echo "</td>";
}

if($page_section < $total_page_section){
		echo "<td style='font-size:36px;'>";
		$limit1 = $limit1 + $number_of_list;
		$page_section = $page_section+1;
		echo "<a href=Historydoor.php?page_section=$page_section&type_select=$type_select&start_date=$start_date&end_date=$end_date&limit1=$limit1&cabinet_number=$cabinet_number&machine_select=$machine_select>[NEXT]</a>";
		echo "</td>";
		$page_section = $page_section-1;
	}
	


?>
				</tr>
			</table>
		</div>
</body>
</html>