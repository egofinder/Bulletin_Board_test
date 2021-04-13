<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>Version</title>
    <?php $manufacturer = $_GET["manufacturer"];
          $program_id = $_GET["program_id"];
          $paytable_id = $_GET["paytable_id"];
          $version = $_GET["version"];
          $location = $_GET["location"]; ?>
          
<!--.................Main CSS file for Administrator Menu.........................-->
<link rel="stylesheet" type="text/css" href="./css/css.css">
</head>

<body>

<div>
  <table id='table'>
    <tr>
    <th id='header' style='font-size:55px; height: 80px;' colspan='2'>GAME INFO</th>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>MANUFACTURER</th>
     <td style='font-size:40px'><?php echo $manufacturer; ?></td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>PROGRAM ID</th>
     <td style='font-size:40px'><?php echo $program_id; ?></td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>PAYTABLE ID</th>
     <td style='font-size:40px'><?php echo $paytable_id; ?></td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>VERSION</th>
     <td style='font-size:40px'><?php echo $version; ?></td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>LOCATION of INSTALLATION</th>
     <td style='font-size:40px'><?php echo $location; ?></td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>BIOS SIGNATURE</th>
     <td style='font-size:30px'>XXXX</td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>OS SIGNATURE</th>
     <td style='font-size:30px'>XXXX</td>
    </tr>
    <tr>
     <th id='header' style='font-size:30px; height: 80px;'>GAME SIGNATURE</th>
     <td style='font-size:30px'>XXXX</td>
    </tr>
  </table>
</div>

</body>
</html>
