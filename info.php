<?php
include_once('db.php');

$list="";
$i=0;
$user_chars = "#[^a-zA-Z0-9_\-]#";
$email_chars = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

$result = "";
$realmname;
$realmstatus = "<FONT COLOR=yellow>Unknown</FONT>";
$uptime = "N/A";
$accounts = "N/A";
$totalchars = "N/A";
$now = date("H:i:s");
$con = @mysql_connect($ip, $user, $pass);

function make_players_array(){
	global $con, $c_db, $pl_array, $maps_a;
    $i=0;
	$query = @mysql_query("SELECT name, race, class, online, level, gender, map, logout_time FROM " . mysql_real_escape_string($c_db) . ".characters ORDER BY `online` desc, `logout_time` desc   , `name` asc", $con);
	while($result = mysql_fetch_assoc($query))
	{
		$char_data = ($result['level']);
		$char_gender = ($result['gender']);
        if (strlen($maps_a[$result['map']])>0)
        {
            $res_pos=$maps_a[$result['map']];
        }
        else
        {
            $res_pos = "Unknown Zone";
        };

        $pl_array[$i] = Array($result['name'], $result['race'], $result['class'], $char_data, $res_pos, $char_gender, $result['online'] == 1, $result['logout_time']);
        $i++;
	}

    return $i;
}

if (!$con) {
	$result = "> Unable to connect to database: " . mysql_error();
}
else
{
    $qry = @mysql_query("select address from " . mysql_real_escape_string($r_db) . ".realmlist where id = 1", $con);
    if ($qry)
    {
        while ($row = mysql_fetch_assoc($qry))
        {
            $realmip = $row['address'];
        }
    };

    unset($qry);
    $qry = @mysql_query("select name from " . mysql_real_escape_string($r_db) . ".realmlist where id = 1", $con);
    if ($qry)
    {
        while ($row = mysql_fetch_assoc($qry))
        {
            $realmname = $row['name'];
        }
    };

    if (! $sock = @fsockopen($realmip, $realmport, $num, $error, 3))
    {
        $realmstatus = "<FONT COLOR=red>Offline</FONT>";
    }
    else
    {
        $realmstatus = "<FONT COLOR=green>Online</FONT>";
        fclose($sock);
    };

    unset($qry);
    $qry = @mysql_query("SELECT * FROM " . mysql_real_escape_string($r_db) . ".uptime ORDER BY `starttime` DESC LIMIT 1", $con);
    if ($qry)
    {
        $uptime_results = mysql_fetch_array($qry);

        if ($uptime_results['uptime'] > 86400) {
            $uptime =  round(($uptime_results['uptime'] / 24 / 60 / 60),2)." Days";
        }
        elseif($uptime_results['uptime'] > 3600) {
            $uptime =  round(($uptime_results['uptime'] / 60 / 60),2)." Hours";
        }
        else
        {
            $uptime =  round(($uptime_results['uptime'] / 60),2)." Min";
        }
    };

    unset($qry);
    $qry = @mysql_query("select Count(id) from " . mysql_real_escape_string($r_db) . ".account", $con);
    if ($qry)
    {
        while ($row = mysql_fetch_assoc($qry))
        {
            $accounts = $row['Count(id)'];
        }
    };

    unset($qry);
    $qry = @mysql_query("select Count(guid) from " . mysql_real_escape_string($c_db) . ".characters where online=1", $con);
    if ($qry)
    {
        while ($row = mysql_fetch_assoc($qry))
        {
            $onlineplayers = $row['Count(guid)'];
        }
    };

    $players=make_players_array();

    if (!$sort = &$_GET['s']) $sort=0;
    if (!$flag = &$_GET['f']) $flag=0;
    if ($flag==0) {	$flag=1; $sort_type='<'; }
    else {	$flag=0; $sort_type='>'; }
    $link=$_SERVER['PHP_SELF']."?f=".$flag."&s=";

    while ($i < $players)
	{
        $name=$pl_array[$i][0];
        $race=$pl_array[$i][1];
        $class=$pl_array[$i][2];
        $res_race = $def['character_race'][$race];
        $res_class = $def['character_class'][$class];
        $lvl=$pl_array[$i][3];
        $loc=$pl_array[$i][4];
        $gender=$pl_array[$i][5];
        $is_online=$pl_array[$i][6];
        $logout_timestamp= $pl_array[$i][7];
        $logout_time=date("Y-m-d h:i", $logout_timestamp);
        $list.= "<tr class='" . ($is_online ? "online" : "offline") . "'>
        <td><a class='$res_class' href='character.php?n=$name'>$name</a></td>
        <td align=center><img alt='$res_race' src='".$img_base."race/".$race."-$gender.gif' height=18 width=18></td>
        <td align=center><img alt='$res_class' src='".$img_base."class/$class.gif' height=18 width=18></td>
        <td align=center>$lvl</td>
        <td>$loc</td>
        <td>" . ($is_online ? "<span class='hidden'>9999999999$name</span>Online" : "<span class='hidden'>$logout_timestamp</span>Offline since $logout_time") . "</td>
        </tr>";
        $i++;
	}
};
?>

<?php include_once('header.php'); ?>

<h2>Realm: <?php if(isset($realmname)){ echo $realmname; } else { echo "Lightbringer";} ?></h2>
<h3>Status: <?php echo $realmstatus; ?></h3>
<table style="margin-left: auto; margin-right: auto;">
    <tr><td class="lcol">Server Time:</td><td class="rcol"><?= $now; ?></td></tr>
    <tr><td class="lcol">Server Uptime:</td><td class="rcol"><?= $uptime; ?></td></tr>
    <tr><td class="lcol">Total Accounts:</td><td class="rcol"><?= $accounts; ?></td></tr>
    <tr><td class="lcol">Total Characters:</td><td class="rcol"><?php if(isset($players)){ echo $players; } else { echo "0";} ?></td></tr>
    <tr><td class="lcol">Players Online:</td><td class="rcol"><?php if(isset($onlineplayers)){ echo $onlineplayers; } else { echo "0";} ?></td></tr>
</table>
<table width="100%" id="status-table" class="table table-bordered table-striped table-dark dataTable no-footer">
    <thead>
        <tr>
            <th align="left">Name</td>
            <th align="center" width=40>Race</td>
            <th align="center" width=40>Class</td>
            <th align="center" width=40>Level</td>
            <th align="left" width=100>Zone</td>
            <th align="left">Status</td>
        </tr>
    </thead>
    <tbody>
        <?php echo $list ?>
    </tbody>
</table>

<?php include_once('footer.php'); ?>
