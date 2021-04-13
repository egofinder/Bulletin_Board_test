<!DOCTYPE html>
<html	lang="en">
<head>
	<meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Bet History</title>
<?php 
include("common_setting.php");
include("db_connect.php");
?>
</head>

<body>
	<div id="topbox">
		<form action="Bethistory.php" method="get">
			<table id="table">
				<tr>
    				<th id="header" style="font-size:50px; height: 50px; margin: 0px; padding: 0px;">BETTING HISTORY</th>
    			</tr>
				</table>
				</div>
				<div id="topbox">
				<table id="table">
				<tr>
					<td id="topboxtd" style="width:20%;">GAME NO</td>
					<td id="topboxtd" style="width:25%;"><input style="font-size:36px; width:100%;"; type="text" name="game_number" placeholder="DD-NN"></td>
<?php
$game_number = $_GET["game_number"];
$list_number = $_GET["list_number"];
$machine_select = $_GET["machine_select"];
$cabinet_number = $_GET["cabinet_number"];
$list_number = $list_number - 1; //List number should start from 0.

if($machine_select == 'C'){
	echo "<input type='hidden' name='machine_select' value='C'>
	<input type='hidden' name='cabinet_number' value='$cabinet_number'>	
	<td id='topboxtd' style='width:25%;'>CABINET NO</td>
	<td id='topboxtd' style='width:20%;'>$cabinet_number</td>";
}

else{
	echo "<input type='hidden' name='machine_select' value='S'>
	<td id='topboxtd' style='width:25%;'>CABINET NO</td>
	<td id='topboxtd' style='width:20%;'><input style='font-size:36px; width:100%;' type='text' name='cabinet_number' placeholder='X'></td>";
}
?>

					<td id="topboxtd" style="width:10%;"><input class="btnExample" type="submit" value="SEARCH"></td>
				</tr>
			</table>
<input type="hidden" name="list_number" value = '1';>
<input type="hidden" name="page_section" value = '1';>
		</form>
	</div>


<?php
$page_section = $_GET["page_section"];
if(empty($page_section)){$page_section = 1;}
//////////////////Check whether game number in DB.//////////////////////////////////////////////////////////////////////////////////////////
	$game_number_temp = mysql_query("SELECT GN AS compare_array FROM dividend");
	while($game_number_array = mysql_fetch_assoc($game_number_temp)){ $game_number_compare_list1[] = $game_number_array['compare_array']; }
	$game_number_compare1 = in_array($game_number, $game_number_compare_list1);

	$game_number_temp = mysql_query("SELECT GN AS compare_array FROM userbet");
	while($game_number_array = mysql_fetch_assoc($game_number_temp)){ $game_number_compare_list2[] = $game_number_array['compare_array']; }
	$game_number_compare2 = in_array($game_number, $game_number_compare_list2);

///////////////////////Check whether cabinet number in DB.//////////////////////
	$cabinet_number_temp = mysql_query("SELECT CBN AS compare_array FROM userbet");
	while($cabinet_number_array = mysql_fetch_assoc($cabinet_number_temp)){ $cabinet_number_compare_list[] = $cabinet_number_array['compare_array']; }
	$cabinet_number_compare = in_array($cabinet_number, $cabinet_number_compare_list);

/////Different query by game number and cabinet number in DB or not.////////////
//모든 데이터 표시
	if(empty($game_number)&&empty($cabinet_number)){ $total_data = mysql_query("SELECT * FROM dividend ORDER BY DATE DESC");
	$count = mysql_num_rows($total_data);
	if($count > $page_number_limit){ $total_page_section = ceil($count/$page_number_limit); }
	else{ $page_number_limit = $count; }

	while($total_data_array = mysql_fetch_row($total_data))
	{
		$date_list[] = $total_data_array[1];
		$game_number_list[] = $total_data_array[2];
		$horse_entry_number_list[] = $total_data_array[3];
		$horse_rank_list[] = $total_data_array[4];
		$win_list[] = $total_data_array[5];
		$show_list[] = $total_data_array[6];
		$qu_list[] = $total_data_array[7];
		$ex_list[] = $total_data_array[8];
		$prize_score_list[] = '';
		$bet_score_list[] = '';
		$remain_credit_list[] = '';
		$userbet_win_list[] = '';
		$userbet_show_list[] = '';
		$userbet_qu_list[] = '';
		$userbet_ex_list[] = '';
	}
	echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
	echo $date_list[$list_number];
	echo"</td></tr></table></div>";
	}

//캐비넷 번호 정보 표시
	else if(empty($game_number)&&$cabinet_number_compare == 1){
	$total_data = mysql_query("SELECT dividend.DATE, dividend.GN, dividend.HEC, dividend.RANK, dividend.WIN, dividend.DIV_SHOW, dividend.QU, dividend.EX,
								userbet.PS, userbet.BS, userbet.CS, userbet.WIN, userbet.DIV_SHOW, userbet.QU, userbet.EX
								FROM dividend, userbet
								WHERE DATE(dividend.DATE) = DATE(userbet.DATE) AND dividend.GN = userbet.GN
								AND userbet.CBN = '$cabinet_number' ORDER BY userbet.DATE DESC");
	$count = mysql_num_rows($total_data);
	if($count > $page_number_limit){ $total_page_section = ceil($count/$page_number_limit); }
	else{ $page_number_limit = $count; }

	while($total_data_array = mysql_fetch_row($total_data))
	{
		$date_list[] = $total_data_array[0];
		$game_number_list[] = $total_data_array[1];
		$horse_entry_number_list[] = $total_data_array[2];
		$horse_rank_list[] = $total_data_array[3];
		$win_list[] = $total_data_array[4];
		$show_list[] = $total_data_array[5];
		$qu_list[] = $total_data_array[6];
		$ex_list[] = $total_data_array[7];
		$prize_score_list[] = $total_data_array[8];
		$bet_score_list[] = $total_data_array[9];
		$remain_credit_list[] = $total_data_array[10];
		$userbet_win_list[] = $total_data_array[11];
		$userbet_show_list[] = $total_data_array[12];
		$userbet_qu_list[] = $total_data_array[13];
		$userbet_ex_list[] = $total_data_array[14];
	}
	echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
	echo $date_list[$list_number];
	echo"</td></tr></table></div>";
	}

	else if($game_number_compare2 == 1&&empty($cabinet_number)){
	$total_data = mysql_query("SELECT * FROM dividend
								WHERE GN = '$game_number'
								ORDER BY DATE DESC");
	$count = mysql_num_rows($total_data);
	if($count > $page_number_limit){ $dot_flag = 1; }
	else{ $page_number_limit = $count; $dot_flag = 0; }

	while($total_data_array = mysql_fetch_row($total_data))
	{
		$date_list[] = $total_data_array[1];
		$game_number_list[] = $total_data_array[2];
		$horse_entry_number_list[] = $total_data_array[3];
		$horse_rank_list[] = $total_data_array[4];
		$win_list[] = $total_data_array[5];
		$show_list[] = $total_data_array[6];
		$qu_list[] = $total_data_array[7];
		$ex_list[] = $total_data_array[8];
		$prize_score_list[] = '';
		$bet_score_list[] = '';
		$remain_credit_list[] = '';
		$userbet_win_list[] = '';
		$userbet_show_list[] = '';
		$userbet_qu_list[] = '';
		$userbet_ex_list[] = '';
	}
	echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
	echo $date_list[$list_number];
	echo"</td></tr></table></div>";
	}

//특정데이터 검색
	else if($game_number_compare2 == 1&&$cabinet_number_compare == 1){
	$total_data = mysql_query("SELECT dividend.DATE, dividend.GN, dividend.HEC, dividend.RANK, dividend.WIN, dividend.DIV_SHOW, dividend.QU, dividend.EX,
								userbet.PS, userbet.BS, userbet.CS, userbet.WIN, userbet.DIV_SHOW, userbet.QU, userbet.EX
								FROM dividend, userbet
								WHERE DATE(dividend.DATE) = DATE(userbet.DATE) AND dividend.GN = '$game_number' AND userbet.GN = '$game_number'
								AND userbet.CBN = '$cabinet_number' ORDER BY userbet.DATE DESC");
	$count = mysql_num_rows($total_data);
	if($count > $page_number_limit){ $total_page_section = ceil($count/$page_number_limit); }
	else{ $page_number_limit = $count; }

	while($total_data_array = mysql_fetch_row($total_data))
	{
		$date_list[] = $total_data_array[0];
		$game_number_list[] = $total_data_array[1];
		$horse_entry_number_list[] = $total_data_array[2];
		$horse_rank_list[] = $total_data_array[3];
		$win_list[] = $total_data_array[4];
		$show_list[] = $total_data_array[5];
		$qu_list[] = $total_data_array[6];
		$ex_list[] = $total_data_array[7];
		$prize_score_list[] = $total_data_array[8];
		$bet_score_list[] = $total_data_array[9];
		$remain_credit_list[] = $total_data_array[10];
		$userbet_win_list[] = $total_data_array[11];
		$userbet_show_list[] = $total_data_array[12];
		$userbet_qu_list[] = $total_data_array[13];
		$userbet_ex_list[] = $total_data_array[14];
	}
	echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
	echo $date_list[$list_number];
	echo"</td></tr></table></div>";
	}

//게임번호 정보 표시
	else if($game_number_compare1 == 1&&empty($cabinet_number)){
	$total_data = mysql_query("SELECT * FROM dividend
								WHERE GN = '$game_number'
								ORDER BY DATE DESC");
	$count = mysql_num_rows($total_data);
	if($count > $page_number_limit){ $total_page_section = ceil($count/$page_number_limit); }
	else{ $page_number_limit = $count; }

	while($total_data_array = mysql_fetch_row($total_data))
	{
		$date_list[] = $total_data_array[1];
		$game_number_list[] = $total_data_array[2];
		$horse_entry_number_list[] = $total_data_array[3];
		$horse_rank_list[] = $total_data_array[4];
		$win_list[] = $total_data_array[5];
		$show_list[] = $total_data_array[6];
		$qu_list[] = $total_data_array[7];
		$ex_list[] = $total_data_array[8];
		$prize_score_list[] = '';
		$bet_score_list[] = '';
		$remain_credit_list[] = '';
		$userbet_win_list[] = '';
		$userbet_show_list[] = '';
		$userbet_qu_list[] = '';
		$userbet_ex_list[] = '';
	}
	echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
	echo $date_list[$list_number];
	echo"</td></tr></table></div>";
	}

//그외의 경우
	else{
			$game_number_list[] = "";
			$horse_entry_number_list[$list_number] = "";
			$horse_rank_list[] = ",,";
			$win_list[$list_number] = ",,,,,,,,,,,";
			$show_list[$list_number] = ",,,,,,,,,,,";
			$qu_list[$list_number] = ",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
			$ex_list[$list_number] = "";
			$prize_score_list[] = "";
			$bet_score_list[] = "";
			$remain_credit_list[] = "";
			$userbet_win_list[$list_number] = ",,,,,,,,,,,";
			$userbet_show_list[$list_number] = ",,,,,,,,,,,";
			$userbet_qu_list[$list_number] = ",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
			$userbet_ex_list[$list_number] = "";
			echo"<div id='topbox'><table id='table'><tr><td id='topboxtd'>";
			echo "<B style='font-size:25px'>NO DATA FOUND</B><BR>";
			echo "</td></tr></table></div>";
		}

echo "<div id='topbox'><table id='table'><tr>";
echo "<td id='topboxtd' style='width:50%'>GAME NO: $game_number_list[$list_number]</td>";

if($cabinet_number_compare == 0){ echo "<td id='topboxtd' style='width:50%'>CABINET NO: </td></tr>"; }
else { echo "<td id='topboxtd' style='width:50%'>CABINET NO: $cabinet_number</td></tr>"; }
echo "</table></div>";

echo "<div id='topbox'><table id='table'>";
echo "<tr>";
echo "<td id='topboxtd' style='width:50%'>HORSE ENTRY: $horse_entry_number_list[$list_number]</td>";
$horse_rank = explode(",", $horse_rank_list[$list_number]);
echo "<td id='topboxtd' style='width:50%'>RANKING: <B style='color:blue;'>$horse_rank[0]</B> <B style='color:blue;'>$horse_rank[1]</B> <B style='color:blue;'>$horse_rank[2]</B></td></tr>";
echo "</table></div>";

echo "<div id='topbox'><table id='table'>";
echo "<tr>";
echo "<td id='topboxtd' style='width:50%'>Credits Wagered: $bet_score_list[$list_number]</td>";
echo "<td id='topboxtd' style='width:50%'>Credits Won: $prize_score_list[$list_number]</td></tr>";
echo "</table></div>";

echo "<div id='topbox'><table id='table'>";
echo "<tr>";
echo "<td id='topboxtd'>Credit Meter End: $remain_credit_list[$list_number]</td></tr>";
echo "</table></div>";

//표1의 첫번째 행
echo"<div id='bottombox'><table id='table'>
<tr><th id='tableheader'></th>";
for($i = 1; $i <= 12; $i++){ echo"<th id='tableheader'>$i</th>"; }
echo"</tr>";


//표1의 WIN에 배당정보 표시하기.
$win = explode(",", $win_list[$list_number]);
$show = explode(",", $show_list[$list_number]);

//표1의 WIN에 배팅정보 표시하기. 잘못된 케비넷 번호 입력시에 배팅정보는 공백으로 바꾼다.
if($cabinet_number_compare == 0){
	for($i = 0; $i <= 11; $i++){ $userbet_win[$i] = '';	$userbet_show[$i] = '';}
}
else{ $userbet_win = explode(",", $userbet_win_list[$list_number]);
	  $userbet_show = explode(",",  $userbet_show_list[$list_number]); 
}

//출전마수에 따른 공백데이터 채워주기.
switch ($horse_entry_number_list[$list_number]){
	case 8:
	for($i = 8; $i <= 11; $i++){
		$win[$i] ='';
		$userbet_win[$i] = '';
		$show[$i] ='';
		$userbet_show[$i] = '';
	}
		break;

	case 9:
		for($i = 9; $i <= 11; $i++){
		$win[$i] ='';
		$userbet_win[$i] = '';
		$show[$i] ='';
		$userbet_show[$i] = '';
	}
		break;

	case 10:
		for($i = 10; $i <= 11; $i++){
		$win[$i] ='';
		$userbet_win[$i] = '';
		$show[$i] ='';
		$userbet_show[$i] = '';
	}
		break;

	case 11:
		$win[11] ='';
		$userbet_win[11] = '';
		$show[11] ='';
		$userbet_show[11] = '';
		break;
}

echo"<tr>
<th id='tableheader'>WIN</th>";
for($i = 0; $i <= 11; $i++){ echo"<td id='tabledata'>$win[$i]<BR>$userbet_win[$i]</td>"; }
echo"</tr>";

echo "<tr>
<th id='tableheader'>SHOW<br></th>";
for($i = 0; $i <= 11; $i++){ echo"<td id='tabledata'>$show[$i]<BR>$userbet_show[$i]</td>"; }
echo"</tr>";

//QU 배당정보 표에 표시하기.
$qu = explode(",", $qu_list[$list_number]);

//QU 유저배팅정보 표시하기.
if($cabinet_number_compare == 0){ 
	for($i = 0; $i <= 65; $i++){ $userbet_qu[$i] = ''; }
}
else { $userbet_qu = explode(",", $userbet_qu_list[$list_number]); }

//출전마수에 따른 공백데이터 채워주기.
switch ($horse_entry_number_list[$list_number]){
	case 8:
		for($i = 28; $i <= 65; $i++){
			$qu[$i] ='';
			$userbet_qu[$i] ='';
		}
		break;
	case 9:
		for($i = 36; $i <= 65; $i++){
			$qu[$i] ='';
			$userbet_qu[$i] ='';
		}
		break;
	case 10:
		for($i = 45; $i <= 65; $i++){
			$qu[$i] ='';
			$userbet_qu[$i] ='';
		}
		break;
	case 11:
		for($i = 55; $i <= 65; $i++){
			$qu[$i] ='';
			$userbet_qu[$i] ='';
		}
		break;
}

echo"<tr>
<th id='tableheader' style='width:10%;'>QUINELLA</th>
<th id='tableheader'>1</th></tr>

<tr>
<th id='tableheader'>2<br></th>
<td id='tabledata'>$qu[0]<BR>$userbet_qu[0]</td>
<th id='tableheader'>2</th></tr>
			      		 
<tr><th id='tableheader'>3</th>";
for($i = 1; $i <= 2; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>3<br></th></tr>

<tr><th id='tableheader'>4</th>";
for($i = 3; $i <= 5; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>4<br></th></tr>

<tr><th id='tableheader'>5</th>";
for($i = 6; $i <= 9; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>5<br></th></tr>
								 
<tr><th id='tableheader'>6</th>";
for($i = 10; $i <= 14; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>6<br></th></tr>

<tr><th id='tableheader'>7</th>";
for($i = 15; $i <= 20; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>7<br></th></tr>
 
<tr><th id='tableheader'>8</th>";
for($i = 21; $i <= 27; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>8<br></th></tr>
								 
<tr><th id='tableheader'>9</th>";
for($i = 28; $i <= 35; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>9<br></th></tr>
								
<tr><th id='tableheader'>10</th>";
for($i = 36; $i <= 44; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>10<br></th></tr>
								 
<tr><th id='tableheader'>11</th>";
for($i = 45; $i <= 54; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>11<br></th></tr>

<tr><th id='tableheader'>12</th>";
for($i = 55; $i <= 65; $i++){ echo"<td id='tabledata'>$qu[$i]<BR>$userbet_qu[$i]</td>"; }
echo"<th id='tableheader'>12<br></th></tr>

</table></div>";




//EX 배당률
$ex = explode(",", $ex_list[$list_number]);

//EX 유저배팅정보 표시하기.
if($cabinet_number_compare == 0){ 
	for($i = 0; $i <= 142; $i++){ $userbet_ex[$i] = ''; }
	}
else{ $userbet_ex = explode(",", $userbet_ex_list[$list_number]); }

//표에 표시하기
switch ($horse_entry_number_list[$list_number]){
	case 8:
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>";
		for($i = 1; $i <= 7; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		for($i = 1; $i <= 4; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[8]<BR>$userbet_ex[8]</td>
		<th id='tableheader'>2</th>";
		for($i = 10; $i <= 15; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		for($i = 16; $i <= 19; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>3</th>";
		for($i = 16; $i <= 17; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>3</th>";
		for($i = 19; $i <= 23; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		for($i = 24; $i <= 27; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>4</th>";
		for($i = 24; $i <= 26; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>4</th>";
		for($i = 28; $i <= 31; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		for($i = 32; $i <= 35; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>5</th>";
		for($i = 32; $i <= 35; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>5</th>";
		for($i = 37; $i <= 39; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		for($i = 40; $i <= 43; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>6</th>";
		for($i = 40; $i <= 44; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>6</th>
		<td id='tabledata'>$ex[46]<BR>$userbet_ex[46]</td>
		<td id='tabledata'>$ex[47]<BR>$userbet_ex[47]</td>";
		for($i = 48; $i <= 51; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>7</th>";
		for($i = 48; $i <= 53; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>7</th>
		<td id='tabledata'>$ex[55]<BR>$userbet_ex[55]</td>";
		for($i = 56; $i <= 59; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>8</th>";
		for($i = 56; $i <= 62; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>";}
		echo"
		<th id='tableheader'>8</th>";
		for($i = 64; $i <= 67; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>9</th>";
		for($i = 1; $i <= 8; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>9</th>";
		for($i = 10; $i <= 12; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>10</th>";
		for($i = 1; $i <= 9; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>10</th>";
		for($i = 11; $i <= 12; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>11</th>";
		for($i = 1; $i <= 10; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>11</th>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>";
		for($i = 1; $i <= 11; $i++){ echo "<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>12</th>
		</tr>
		</table></div>";
		break;

	case 9:		
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>";
		for($i = 1; $i <= 8; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[9]<BR>$userbet_ex[9]</td>
		<th id='tableheader'>2</th>";
		for($i = 11; $i <= 17; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[18]<BR>$userbet_ex[18]</td>
		<td id='tabledata'>$ex[19]<BR>$userbet_ex[19]</td>
		<th id='tableheader'>3</th>";
		for($i = 21; $i <= 26; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>4</th>";
		for($i = 27; $i <= 29; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>4</th>";
		for($i = 31; $i <= 35; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>5</th>";
		for($i = 36; $i <= 39; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>5</th>";
		for($i = 41; $i <= 44; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>6</th>";
		for($i = 45; $i <= 49; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>6</th>";
		for($i = 51; $i <= 53; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>7</th>";
		for($i = 54; $i <= 59; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>7</th>";
		for($i = 61; $i <= 62; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>8</th>";
		for($i = 63; $i <= 69; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>8</th>";
		for($i = 71; $i <= 71; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>9</th>";
		for($i = 72; $i <= 79; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>9</th>";
		for($i = 1; $i <= 3; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>10</th>";
		for($i = 1; $i <= 9; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		<th id='tableheader'>10</th>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>11</th>";
		for($i = 1; $i <= 10; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		<th id='tableheader'>11</th>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>";
		for($i = 1; $i <= 11; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		<th id='tableheader'>12</th>
		</tr>
		</table></div>";
		break;

	case 10:
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>";
		for($i = 1; $i <= 9; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[10]<BR>$userbet_ex[10]</td>
		<th id='tableheader'>2</th>";
		for($i = 12; $i <= 19; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[20]<BR>$userbet_ex[20]</td>
		<td id='tabledata'>$ex[21]<BR>$userbet_ex[21]</td>
		<th id='tableheader'>3</th>";
		for($i = 23; $i <= 29; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>4</th>";
		for($i = 30; $i <= 32; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>4</th>";
		for($i = 34; $i <= 39; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>5</th>";
		for($i = 40; $i <= 43; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>5</th>";
		for($i = 45; $i <= 49; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>6</th>";
		for($i = 50; $i <= 54; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>6</th>";
		for($i = 56; $i <= 59; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>7</th>";
		for($i = 60; $i <= 65; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>7</th>";
		for($i = 67; $i <= 69; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>8</th>";
		for($i = 70; $i <= 76; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>8</th>";
		for($i = 78; $i <= 79; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		for($i = 1; $i <= 2; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		</tr>
		<tr>
		<th id='tableheader'>9</th>";
		for($i = 80; $i <= 87; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>9</th>
		<td id='tabledata'>$ex[89]<BR>$userbet_ex[89]</td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>10</th>";
		for($i = 90; $i <= 98; $i++){ echo "<td id='tabledata'>$ex[$i]<BR>$userbet_ex[$i]</td>"; }
		echo"
		<th id='tableheader'>10</th>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>11</th>";
		for($i = 1; $i <= 10; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		<th id='tableheader'>11</th>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>";
		for($i = 1; $i <= 11; $i++){ echo "<td id='tabledata'></td>"; }
		echo"
		<th id='tableheader'>12</th>
		</tr>
								</table></div>";
		break;
	case 11:
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>
		<td id='tabledata'>$ex[1]<BR>$userbet_ex[1]</td>
		<td id='tabledata'>$ex[2]<BR>$userbet_ex[2]</td>
		<td id='tabledata'>$ex[3]<BR>$userbet_ex[3]</td>
		<td id='tabledata'>$ex[4]<BR>$userbet_ex[4]</td>
		<td id='tabledata'>$ex[5]<BR>$userbet_ex[5]</td>
		<td id='tabledata'>$ex[6]<BR>$userbet_ex[6]</td>
		<td id='tabledata'>$ex[7]<BR>$userbet_ex[7]</td>
		<td id='tabledata'>$ex[8]<BR>$userbet_ex[8]</td>
		<td id='tabledata'>$ex[9]<BR>$userbet_ex[9]</td>
		<td id='tabledata'>$ex[10]<BR>$userbet_ex[10]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[11]<BR>$userbet_ex[11]</td>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[13]<BR>$userbet_ex[13]</td>
		<td id='tabledata'>$ex[14]<BR>$userbet_ex[14]</td>
		<td id='tabledata'>$ex[15]<BR>$userbet_ex[15]</td>
		<td id='tabledata'>$ex[16]<BR>$userbet_ex[16]</td>
		<td id='tabledata'>$ex[17]<BR>$userbet_ex[17]</td>
		<td id='tabledata'>$ex[18]<BR>$userbet_ex[18]</td>
		<td id='tabledata'>$ex[19]<BR>$userbet_ex[19]</td>
		<td id='tabledata'>$ex[20]<BR>$userbet_ex[20]</td>
		<td id='tabledata'>$ex[21]<BR>$userbet_ex[21]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[22]<BR>$userbet_ex[22]</td>
		<td id='tabledata'>$ex[23]<BR>$userbet_ex[23]</td>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[25]<BR>$userbet_ex[25]</td>
		<td id='tabledata'>$ex[26]<BR>$userbet_ex[26]</td>
		<td id='tabledata'>$ex[27]<BR>$userbet_ex[27]</td>
		<td id='tabledata'>$ex[28]<BR>$userbet_ex[28]</td>
		<td id='tabledata'>$ex[29]<BR>$userbet_ex[29]</td>
		<td id='tabledata'>$ex[30]<BR>$userbet_ex[30]</td>
		<td id='tabledata'>$ex[31]<BR>$userbet_ex[31]</td>
		<td id='tabledata'>$ex[32]<BR>$userbet_ex[32]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>4</th>
		<td id='tabledata'>$ex[33]<BR>$userbet_ex[33]</td>
		<td id='tabledata'>$ex[34]<BR>$userbet_ex[34]</td>
		<td id='tabledata'>$ex[35]<BR>$userbet_ex[35]</td>
		<th id='tableheader'>4</th>
		<td id='tabledata'>$ex[37]<BR>$userbet_ex[37]</td>
		<td id='tabledata'>$ex[38]<BR>$userbet_ex[38]</td>
		<td id='tabledata'>$ex[39]<BR>$userbet_ex[39]</td>
		<td id='tabledata'>$ex[40]<BR>$userbet_ex[40]</td>
		<td id='tabledata'>$ex[41]<BR>$userbet_ex[41]</td>
		<td id='tabledata'>$ex[42]<BR>$userbet_ex[42]</td>
		<td id='tabledata'>$ex[43]<BR>$userbet_ex[43]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>5</th>
		<td id='tabledata'>$ex[44]<BR>$userbet_ex[44]</td>
		<td id='tabledata'>$ex[45]<BR>$userbet_ex[45]</td>
		<td id='tabledata'>$ex[46]<BR>$userbet_ex[46]</td>
		<td id='tabledata'>$ex[47]<BR>$userbet_ex[47]</td>
		<th id='tableheader'>5</th>
		<td id='tabledata'>$ex[49]<BR>$userbet_ex[49]</td>
		<td id='tabledata'>$ex[50]<BR>$userbet_ex[50]</td>
		<td id='tabledata'>$ex[51]<BR>$userbet_ex[51]</td>
		<td id='tabledata'>$ex[52]<BR>$userbet_ex[52]</td>
		<td id='tabledata'>$ex[53]<BR>$userbet_ex[53]</td>
		<td id='tabledata'>$ex[54]<BR>$userbet_ex[54]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>6</th>
		<td id='tabledata'>$ex[55]<BR>$userbet_ex[55]</td>
		<td id='tabledata'>$ex[56]<BR>$userbet_ex[56]</td>
		<td id='tabledata'>$ex[57]<BR>$userbet_ex[57]</td>
		<td id='tabledata'>$ex[58]<BR>$userbet_ex[58]</td>
		<td id='tabledata'>$ex[59]<BR>$userbet_ex[59]</td>
		<th id='tableheader'>6</th>
		<td id='tabledata'>$ex[61]<BR>$userbet_ex[61]</td>
		<td id='tabledata'>$ex[62]<BR>$userbet_ex[62]</td>
		<td id='tabledata'>$ex[63]<BR>$userbet_ex[63]</td>
		<td id='tabledata'>$ex[64]<BR>$userbet_ex[64]</td>
		<td id='tabledata'>$ex[65]<BR>$userbet_ex[65]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>7</th>
		<td id='tabledata'>$ex[66]<BR>$userbet_ex[66]</td>
		<td id='tabledata'>$ex[67]<BR>$userbet_ex[67]</td>
		<td id='tabledata'>$ex[68]<BR>$userbet_ex[68]</td>
		<td id='tabledata'>$ex[69]<BR>$userbet_ex[69]</td>
		<td id='tabledata'>$ex[70]<BR>$userbet_ex[70]</td>
		<td id='tabledata'>$ex[71]<BR>$userbet_ex[71]</td>
		<th id='tableheader'>7</th>
		<td id='tabledata'>$ex[73]<BR>$userbet_ex[73]</td>
		<td id='tabledata'>$ex[74]<BR>$userbet_ex[74]</td>
		<td id='tabledata'>$ex[75]<BR>$userbet_ex[75]</td>
		<td id='tabledata'>$ex[76]<BR>$userbet_ex[76]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>8</th>
		<td id='tabledata'>$ex[77]<BR>$userbet_ex[77]</td>
		<td id='tabledata'>$ex[78]<BR>$userbet_ex[78]</td>
		<td id='tabledata'>$ex[79]<BR>$userbet_ex[79]</td>
		<td id='tabledata'>$ex[80]<BR>$userbet_ex[80]</td>
		<td id='tabledata'>$ex[81]<BR>$userbet_ex[81]</td>
		<td id='tabledata'>$ex[82]<BR>$userbet_ex[82]</td>
		<td id='tabledata'>$ex[83]<BR>$userbet_ex[83]</td>
		<th id='tableheader'>8</th>
		<td id='tabledata'>$ex[85]<BR>$userbet_ex[85]</td>
		<td id='tabledata'>$ex[86]<BR>$userbet_ex[86]</td>
		<td id='tabledata'>$ex[87]<BR>$userbet_ex[87]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>9</th>
		<td id='tabledata'>$ex[88]<BR>$userbet_ex[88]</td>
		<td id='tabledata'>$ex[89]<BR>$userbet_ex[89]</td>
		<td id='tabledata'>$ex[90]<BR>$userbet_ex[90]</td>
		<td id='tabledata'>$ex[91]<BR>$userbet_ex[91]</td>
		<td id='tabledata'>$ex[92]<BR>$userbet_ex[92]</td>
		<td id='tabledata'>$ex[93]<BR>$userbet_ex[93]</td>
		<td id='tabledata'>$ex[94]<BR>$userbet_ex[94]</td>
		<td id='tabledata'>$ex[95]<BR>$userbet_ex[95]</td>
		<th id='tableheader'>9</th>
		<td id='tabledata'>$ex[97]<BR>$userbet_ex[97]</td>
		<td id='tabledata'>$ex[98]<BR>$userbet_ex[98]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>10</th>
		<td id='tabledata'>$ex[99]<BR>$userbet_ex[99]</td>
		<td id='tabledata'>$ex[100]<BR>$userbet_ex[100]</td>
		<td id='tabledata'>$ex[101]<BR>$userbet_ex[101]</td>
		<td id='tabledata'>$ex[102]<BR>$userbet_ex[102]</td>
		<td id='tabledata'>$ex[103]<BR>$userbet_ex[103]</td>
		<td id='tabledata'>$ex[104]<BR>$userbet_ex[104]</td>
		<td id='tabledata'>$ex[105]<BR>$userbet_ex[105]</td>
		<td id='tabledata'>$ex[106]<BR>$userbet_ex[106]</td>
		<td id='tabledata'>$ex[107]<BR>$userbet_ex[107]</td>
		<th id='tableheader'>10</th>
		<td id='tabledata'>$ex[109]<BR>$userbet_ex[109]</td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>11</th>
		<td id='tabledata'>$ex[110]<BR>$userbet_ex[110]</td>
		<td id='tabledata'>$ex[111]<BR>$userbet_ex[111]</td>
		<td id='tabledata'>$ex[112]<BR>$userbet_ex[112]</td>
		<td id='tabledata'>$ex[113]<BR>$userbet_ex[113]</td>
		<td id='tabledata'>$ex[114]<BR>$userbet_ex[114]</td>
		<td id='tabledata'>$ex[115]<BR>$userbet_ex[115]</td>
		<td id='tabledata'>$ex[116]<BR>$userbet_ex[116]</td>
		<td id='tabledata'>$ex[117]<BR>$userbet_ex[117]</td>
		<td id='tabledata'>$ex[118]<BR>$userbet_ex[118]</td>
		<td id='tabledata'>$ex[119]<BR>$userbet_ex[119]</td>
		<th id='tableheader'>11</th>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<th id='tableheader'>12</th>
		</tr>
		</table></div>";
		break;

	case 12:
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>
		<td id='tabledata'>$ex[1]<BR>$userbet_ex[1]</td>
		<td id='tabledata'>$ex[2]<BR>$userbet_ex[2]</td>
		<td id='tabledata'>$ex[3]<BR>$userbet_ex[3]</td>
		<td id='tabledata'>$ex[4]<BR>$userbet_ex[4]</td>
		<td id='tabledata'>$ex[5]<BR>$userbet_ex[5]</td>
		<td id='tabledata'>$ex[6]<BR>$userbet_ex[6]</td>
		<td id='tabledata'>$ex[7]<BR>$userbet_ex[7]</td>
		<td id='tabledata'>$ex[8]<BR>$userbet_ex[8]</td>
		<td id='tabledata'>$ex[9]<BR>$userbet_ex[9]</td>
		<td id='tabledata'>$ex[10]<BR>$userbet_ex[10]</td>
		<td id='tabledata'>$ex[11]<BR>$userbet_ex[11]</td>
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[12]<BR>$userbet_ex[12]</td>
		<th id='tableheader'>2</th>
		<td id='tabledata'>$ex[14]<BR>$userbet_ex[14]</td>
		<td id='tabledata'>$ex[15]<BR>$userbet_ex[15]</td>
		<td id='tabledata'>$ex[16]<BR>$userbet_ex[16]</td>
		<td id='tabledata'>$ex[17]<BR>$userbet_ex[17]</td>
		<td id='tabledata'>$ex[18]<BR>$userbet_ex[18]</td>
		<td id='tabledata'>$ex[19]<BR>$userbet_ex[19]</td>
		<td id='tabledata'>$ex[20]<BR>$userbet_ex[20]</td>
		<td id='tabledata'>$ex[21]<BR>$userbet_ex[21]</td>
		<td id='tabledata'>$ex[22]<BR>$userbet_ex[22]</td>
		<td id='tabledata'>$ex[23]<BR>$userbet_ex[23]</td>
		</tr>
		<tr>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[24]<BR>$userbet_ex[24]</td>
		<td id='tabledata'>$ex[25]<BR>$userbet_ex[25]</td>
		<th id='tableheader'>3</th>
		<td id='tabledata'>$ex[27]<BR>$userbet_ex[27]</td>
		<td id='tabledata'>$ex[28]<BR>$userbet_ex[28]</td>
		<td id='tabledata'>$ex[29]<BR>$userbet_ex[29]</td>
		<td id='tabledata'>$ex[30]<BR>$userbet_ex[30]</td>
		<td id='tabledata'>$ex[31]<BR>$userbet_ex[31]</td>
		<td id='tabledata'>$ex[32]<BR>$userbet_ex[32]</td>
		<td id='tabledata'>$ex[33]<BR>$userbet_ex[33]</td>
		<td id='tabledata'>$ex[34]<BR>$userbet_ex[34]</td>
		<td id='tabledata'>$ex[35]<BR>$userbet_ex[35]</td>
		</tr>
		<tr>
		<th id='tableheader'>4</th>
		<td id='tabledata'>$ex[36]<BR>$userbet_ex[36]</td>
		<td id='tabledata'>$ex[37]<BR>$userbet_ex[37]</td>
		<td id='tabledata'>$ex[38]<BR>$userbet_ex[38]</td>
		<th id='tableheader'>4</th>
		<td id='tabledata'>$ex[40]<BR>$userbet_ex[40]</td>
		<td id='tabledata'>$ex[41]<BR>$userbet_ex[41]</td>
		<td id='tabledata'>$ex[42]<BR>$userbet_ex[42]</td>
		<td id='tabledata'>$ex[43]<BR>$userbet_ex[43]</td>
		<td id='tabledata'>$ex[44]<BR>$userbet_ex[44]</td>
		<td id='tabledata'>$ex[45]<BR>$userbet_ex[45]</td>
		<td id='tabledata'>$ex[46]<BR>$userbet_ex[46]</td>
		<td id='tabledata'>$ex[47]<BR>$userbet_ex[47]</td>
		</tr>
		<tr>
		<th id='tableheader'>5</th>
		<td id='tabledata'>$ex[48]<BR>$userbet_ex[48]</td>
		<td id='tabledata'>$ex[49]<BR>$userbet_ex[49]</td>
		<td id='tabledata'>$ex[50]<BR>$userbet_ex[50]</td>
		<td id='tabledata'>$ex[51]<BR>$userbet_ex[51]</td>
		<th id='tableheader'>5</th>
		<td id='tabledata'>$ex[53]<BR>$userbet_ex[53]</td>
		<td id='tabledata'>$ex[54]<BR>$userbet_ex[54]</td>
		<td id='tabledata'>$ex[55]<BR>$userbet_ex[55]</td>
		<td id='tabledata'>$ex[56]<BR>$userbet_ex[56]</td>
		<td id='tabledata'>$ex[57]<BR>$userbet_ex[57]</td>
		<td id='tabledata'>$ex[58]<BR>$userbet_ex[58]</td>
		<td id='tabledata'>$ex[59]<BR>$userbet_ex[59]</td>
		</tr>
		<tr>
		<th id='tableheader'>6</th>
		<td id='tabledata'>$ex[60]<BR>$userbet_ex[60]</td>
		<td id='tabledata'>$ex[61]<BR>$userbet_ex[61]</td>
		<td id='tabledata'>$ex[62]<BR>$userbet_ex[62]</td>
		<td id='tabledata'>$ex[63]<BR>$userbet_ex[63]</td>
		<td id='tabledata'>$ex[64]<BR>$userbet_ex[64]</td>
		<th id='tableheader'>6</th>
		<td id='tabledata'>$ex[66]<BR>$userbet_ex[66]</td>
		<td id='tabledata'>$ex[67]<BR>$userbet_ex[67]</td>
		<td id='tabledata'>$ex[68]<BR>$userbet_ex[68]</td>
		<td id='tabledata'>$ex[69]<BR>$userbet_ex[69]</td>
		<td id='tabledata'>$ex[70]<BR>$userbet_ex[70]</td>
		<td id='tabledata'>$ex[71]<BR>$userbet_ex[71]</td>
		</tr>
		<tr>
		<th id='tableheader'>7</th>
		<td id='tabledata'>$ex[72]<BR>$userbet_ex[72]</td>
		<td id='tabledata'>$ex[73]<BR>$userbet_ex[73]</td>
		<td id='tabledata'>$ex[74]<BR>$userbet_ex[74]</td>
		<td id='tabledata'>$ex[75]<BR>$userbet_ex[75]</td>
		<td id='tabledata'>$ex[76]<BR>$userbet_ex[76]</td>
		<td id='tabledata'>$ex[77]<BR>$userbet_ex[77]</td>
		<th id='tableheader'>7</th>
		<td id='tabledata'>$ex[79]<BR>$userbet_ex[79]</td>
		<td id='tabledata'>$ex[80]<BR>$userbet_ex[80]</td>
		<td id='tabledata'>$ex[81]<BR>$userbet_ex[81]</td>
		<td id='tabledata'>$ex[82]<BR>$userbet_ex[82]</td>
		<td id='tabledata'>$ex[83]<BR>$userbet_ex[83]</td>
		</tr>
		<tr>
		<th id='tableheader'>8</th>
		<td id='tabledata'>$ex[84]<BR>$userbet_ex[84]</td>
		<td id='tabledata'>$ex[85]<BR>$userbet_ex[85]</td>
		<td id='tabledata'>$ex[86]<BR>$userbet_ex[86]</td>
		<td id='tabledata'>$ex[87]<BR>$userbet_ex[87]</td>
		<td id='tabledata'>$ex[88]<BR>$userbet_ex[88]</td>
		<td id='tabledata'>$ex[89]<BR>$userbet_ex[89]</td>
		<td id='tabledata'>$ex[90]<BR>$userbet_ex[90]</td>
		<th id='tableheader'>8</th>
		<td id='tabledata'>$ex[92]<BR>$userbet_ex[92]</td>
		<td id='tabledata'>$ex[93]<BR>$userbet_ex[93]</td>
		<td id='tabledata'>$ex[94]<BR>$userbet_ex[94]</td>
		<td id='tabledata'>$ex[95]<BR>$userbet_ex[95]</td>
		</tr>
		<tr>
		<th id='tableheader'>9</th>
		<td id='tabledata'>$ex[96]<BR>$userbet_ex[96]</td>
		<td id='tabledata'>$ex[97]<BR>$userbet_ex[97]</td>
		<td id='tabledata'>$ex[98]<BR>$userbet_ex[98]</td>
		<td id='tabledata'>$ex[99]<BR>$userbet_ex[99]</td>
		<td id='tabledata'>$ex[100]<BR>$userbet_ex[100]</td>
		<td id='tabledata'>$ex[101]<BR>$userbet_ex[101]</td>
		<td id='tabledata'>$ex[102]<BR>$userbet_ex[102]</td>
		<td id='tabledata'>$ex[103]<BR>$userbet_ex[103]</td>
		<th id='tableheader'>9</th>
		<td id='tabledata'>$ex[105]<BR>$userbet_ex[105]</td>
		<td id='tabledata'>$ex[106]<BR>$userbet_ex[106]</td>
		<td id='tabledata'>$ex[107]<BR>$userbet_ex[107]</td>
		</tr>
		<tr>
		<th id='tableheader'>10</th>
		<td id='tabledata'>$ex[108]<BR>$userbet_ex[108]</td>
		<td id='tabledata'>$ex[109]<BR>$userbet_ex[109]</td>
		<td id='tabledata'>$ex[110]<BR>$userbet_ex[110]</td>
		<td id='tabledata'>$ex[111]<BR>$userbet_ex[111]</td>
		<td id='tabledata'>$ex[112]<BR>$userbet_ex[112]</td>
		<td id='tabledata'>$ex[113]<BR>$userbet_ex[113]</td>
		<td id='tabledata'>$ex[114]<BR>$userbet_ex[114]</td>
		<td id='tabledata'>$ex[115]<BR>$userbet_ex[115]</td>
		<td id='tabledata'>$ex[116]<BR>$userbet_ex[116]</td>
		<th id='tableheader'>10</th>
		<td id='tabledata'>$ex[118]<BR>$userbet_ex[118]</td>
		<td id='tabledata'>$ex[119]<BR>$userbet_ex[119]</td>
		</tr>
		<tr>
		<th id='tableheader'>11</th>
		<td id='tabledata'>$ex[120]<BR>$userbet_ex[120]</td>
		<td id='tabledata'>$ex[121]<BR>$userbet_ex[121]</td>
		<td id='tabledata'>$ex[122]<BR>$userbet_ex[122]</td>
		<td id='tabledata'>$ex[123]<BR>$userbet_ex[123]</td>
		<td id='tabledata'>$ex[124]<BR>$userbet_ex[124]</td>
		<td id='tabledata'>$ex[125]<BR>$userbet_ex[125]</td>
		<td id='tabledata'>$ex[126]<BR>$userbet_ex[126]</td>
		<td id='tabledata'>$ex[127]<BR>$userbet_ex[127]</td>
		<td id='tabledata'>$ex[128]<BR>$userbet_ex[128]</td>
		<td id='tabledata'>$ex[129]<BR>$userbet_ex[129]</td>
		<th id='tableheader'>11</th>
		<td id='tabledata'>$ex[131]<BR>$userbet_ex[131]</td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>
		<td id='tabledata'>$ex[132]<BR>$userbet_ex[132]</td>
		<td id='tabledata'>$ex[133]<BR>$userbet_ex[133]</td>
		<td id='tabledata'>$ex[134]<BR>$userbet_ex[134]</td>
		<td id='tabledata'>$ex[135]<BR>$userbet_ex[135]</td>
		<td id='tabledata'>$ex[136]<BR>$userbet_ex[136]</td>
		<td id='tabledata'>$ex[137]<BR>$userbet_ex[137]</td>
		<td id='tabledata'>$ex[138]<BR>$userbet_ex[138]</td>
		<td id='tabledata'>$ex[139]<BR>$userbet_ex[139]</td>
		<td id='tabledata'>$ex[140]<BR>$userbet_ex[140]</td>
		<td id='tabledata'>$ex[141]<BR>$userbet_ex[141]</td>
		<td id='tabledata'>$ex[142]<BR>$userbet_ex[142]</td>
		<th id='tableheader'>12</th>
		</tr>
		</table></div>";
		break;

	default:
		echo"<div id='bottombox'><table id='table'>
		<tr>
		<th id='tableheader' style='width:10%'>EXACTA</th>
		<th id='tableheader'>1</th>";
		for($i = 1; $i <= 11; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>2</th>
		<td id='tabledata'></td>
		<th id='tableheader'>2</th>";
		for($i = 1; $i <= 10; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>3</th>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		<th id='tableheader'>3</th>";
		for($i = 1; $i <= 9; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>4</th>";
		for($i = 1; $i <= 3; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>4</th>";
		for($i = 1; $i <= 8; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>5</th>";
		for($i = 1; $i <= 4; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>5</th>";
		for($i = 1; $i <= 7; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>6</th>";
		for($i = 1; $i <= 5; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>6</th>";
		for($i = 1; $i <= 6; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>7</th>";
		for($i = 1; $i <= 6; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>7</th>";
		for($i = 1; $i <= 5; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>8</th>";
		for($i = 1; $i <= 7; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>8</th>";
		for($i = 1; $i <= 4; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>9</th>";
		for($i = 1; $i <= 8; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>9</th>";
		for($i = 1; $i <= 3; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		</tr>
		<tr>
		<th id='tableheader'>10</th>";
		for($i = 1; $i <= 9; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>10</th>
		<td id='tabledata'></td>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>11</th>";
		for($i = 1; $i <= 10; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>11</th>
		<td id='tabledata'></td>
		</tr>
		<tr>
		<th id='tableheader'>12</th>";
		for($i = 1; $i <= 11; $i++){ echo"<td id='tabledata'></td>";}
		echo"
		<th id='tableheader'>12</th>
		</tr>
		</table></div>";
		break;
		}


/////////////////////////////Create Page Link///////////////////////////////////
					echo "<div class='link' align = 'center'>";
					echo "<table style = 'text-align: center'>";
					echo "<tr>";

					$show_page = $page_number_limit*$page_section+1;
					if($show_page > $count){$show_page = $count+1;}

					if(empty($game_number)&&empty($cabinet_number)){
	
						if($page_section > 1){ 
							$page_section = $page_section - 1;
							$i = $page_section*$page_number_limit;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=&list_number=$i>[PREV]</a>"; 
							echo "</td>";
							$page_section = $page_section + 1;
						}

						for($i = 1+ ($page_section-1)*$page_number_limit; $i < $show_page; $i++){
							echo "<td style='font-size:34px;'>";
							if(($list_number+1) == $i){echo "<B><a style='color: #6a1b9a;' href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=&list_number=$i>[$i]</a></B>";}
							else{ echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=&list_number=$i>[$i]</a>"; }
							echo "</td>";
						}

						if($page_section < $total_page_section){ 
							$page_section = $page_section + 1;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=&list_number=$i>[NEXT]</a>"; }
							echo "</td>";
							$page_section = $page_section - 1;
						}

					else if(empty($game_number)&&$cabinet_number_compare == 1){

						if($page_section > 1){ 
							$page_section = $page_section - 1;
							$i = $page_section*$page_number_limit;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=$cabinet_number&list_number=$i>[PREV]</a>";
							echo "</td>";
							$page_section = $page_section + 1;
						}

						for($i = 1+ ($page_section-1)*$page_number_limit; $i < $show_page; $i++){
							echo "<td style='font-size:34px;'>";
							if(($list_number+1) == $i){echo "<B><a style='color: #6a1b9a;' href=Bethistory.php?page_Section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=$cabinet_number&list_number=$i>[$i]</a></B>";}
							else{ echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=$cabinet_number&list_number=$i>[$i]</a>"; }
							echo "</td>";
						}

						if($page_section < $total_page_section){ 
							$page_section = $page_section + 1;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=&cabinet_number=$cabinet_number&list_number=$i>[NEXT]</a>"; }
							echo "</td>";
							$page_section = $page_section - 1;
					
						}

					else if($game_number_compare2 == 1&&empty($cabinet_number)){

						if($page_section > 1){ 
							$page_section = $page_section - 1;
							$i = $page_section*$page_number_limit;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[PREV]</a>";
							echo "</td>";
							$page_section = $page_section + 1;
						}

						for($i = 1+ ($page_section-1)*$page_number_limit; $i < $show_page; $i++){
							echo "<td style='font-size:34px;'>";
							if(($list_number+1) == $i){echo "<B><a style='color: #6a1b9a;' href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[$i]</a></B>";}
							else{ echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[$i]</a>";  }
							echo "</td>";
						}

						if($page_section < $total_page_section){ 
							$page_section = $page_section + 1;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[NEXT]</a>"; }
							echo "</td>";
							$page_section = $page_section - 1;
					}

					else if($game_number_compare2 == 1&&$cabinet_number_compare == 1){
						
						if($page_section > 1){ 
							$page_section = $page_section - 1;
							$i = $page_section*$page_number_limit;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=$cabinet_number&list_number=$i>[PREV]</a>";
							echo "</td>";
							$page_section = $page_section + 1;
						}

						for($i = 1+ ($page_section-1)*$page_number_limit; $i < $show_page; $i++){
							echo "<td style='font-size:34px;'>";
							if(($list_number+1) == $i){echo "<B><a style='color: #6a1b9a;' href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=$cabinet_number&list_number=$i>[$i]</a></B>";}
							else{ echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=$cabinet_number&list_number=$i>[$i]</a>";  }
							echo "</td>";
						}

						if($page_section < $total_page_section){ 
							$page_section = $page_section + 1;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=$cabinet_number&list_number=$i>[NEXT]</a>"; }
							echo "</td>";
							$page_section = $page_section - 1;	
						}

					else if($game_number_compare1 == 1&&empty($cabinet_number)){

						if($page_section > 1){ 
							$page_section = $page_section - 1;
							$i = $page_section*$page_number_limit;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[PREV]</a>";
							echo "</td>";
							$page_section = $page_section + 1;
						}

						for($i = 1+ ($page_section-1)*$page_number_limit; $i < $show_page; $i++){
							echo "<td style='font-size:34px;'>";
							if(($list_number+1) == $i){echo "<B><a style='color: #6a1b9a;'href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[$i]</a></B>";}
							else{ echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[$i]</a>";  }
							echo "</td>";
						}

						if($page_section < $total_page_section){ 
							$page_section = $page_section + 1;
							echo "<td style='font-size:34px;'>";
							echo "<a href=Bethistory.php?page_section=$page_section&machine_select=$machine_select&game_number=$game_number&cabinet_number=&list_number=$i>[NEXT]</a>"; }
							echo "</td>";
							$page_section = $page_section - 1;	
						}
					else{}

include("db_close.php");
?>
</tr>
</table>
</div>
</body>
</html>