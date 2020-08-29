<?php
include_once('db.php');

$result = "";
$con = mysqli_connect($ip, $user, $pass);
if (!$con) {
	$result = "> Unable to connect to database: " . mysqli_error($con);
}
else
{
  $qry = mysqli_query($con, "SELECT name, equipmentCache FROM ". mysqli_real_escape_string($con, $c_db) . ".characters WHERE name='".mysqli_real_escape_string ($con, $_GET['n'])."'");
  if ($qry)
  {
    if ($row = mysqli_fetch_assoc($qry))
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
    <tr><td></td><td><?=$items[30]?><span class="spacer">&nbsp;</span><?=$items[32]?><span class="spacer">&nbsp;</span><?=$items[34]?></td><td></td></tr>
  </table>

  <script>var whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true, iconSize: 'large'};</script>
  <script src="https://wow.zamimg.com/widgets/power.js"></script>
<?php } ?>
<?php include_once('footer.php'); ?>
