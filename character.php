<?php
include_once('db.php');

$result = "";
$con = @mysql_connect($ip, $user, $pass);
if (!$con) {
	$result = "> Unable to connect to database: " . mysql_error();
}
else
{
  $qry = @mysql_query("SELECT name, equipmentCache FROM ". mysql_real_escape_string($c_db) . ".characters WHERE name='".mysql_real_escape_string ($_GET['n'])."'", $con);
  if ($qry)
  {
    if ($row = mysql_fetch_assoc($qry))
    {
      $name = $row['name'];
      $equipmentCache = preg_split('/\s+/', $row['equipmentCache']);
      $items = [];
      foreach($equipmentCache as $item){
        if($item != "0"){
          $items[] = "<a href='https://classic.wowhead.com/item=$item' class='icononly' target='_new' data-wowhead='item=$item&domain=classic'>$item</a>";
        } else {
          $items[] = "&nbsp;";
        }
      }
    }
  };
  unset($qry);
};
?>

<?php include_once('header.php'); ?>
<?php if(isset($name)) { ?>
  <table class="armory">
    <tr><td><?=$items[0]?></td><td style="width: 400px;"><h2><?=$name?></h2></td><td><?=$items[18]?></td></tr>
    <tr><td><?=$items[2]?></td><td></td><td><?=$items[10]?></td></tr>
    <tr><td><?=$items[4]?></td><td></td><td><?=$items[12]?></td></tr>
    <tr><td><?=$items[28]?></td><td></td><td><?=$items[14]?></td></tr>
    <tr><td><?=$items[8]?></td><td></td><td><?=$items[20]?></td></tr>
    <tr><td> </td><td></td><td><?=$items[22]?></td></tr>
    <tr><td> </td><td></td><td><?=$items[24]?></td></tr>
    <tr><td><?=$items[16]?></td><td></td><td><?=$items[26]?></td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr><td></td><td><?=$items[30]?><span style="margin-left: 25px; margin-right: 25px;">&nbsp;</span><?=$items[32]?><span style="margin-left: 25px; margin-right: 25px;">&nbsp;</span><?=$items[34]?></td><td></td></tr>
  </table>

  <script>var whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true, iconSize: 'large'};</script>
  <script src="https://wow.zamimg.com/widgets/power.js"></script>
<?php } ?>
<?php include_once('footer.php'); ?>