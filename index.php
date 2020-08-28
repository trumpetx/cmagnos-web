<?php
include_once('db.php');


$user_chars = "#[^a-zA-Z0-9_\-]#";
$email_chars = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

$result = "";
$realmip = "";
$con = @mysql_connect($ip, $user, $pass);
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
    }
    if (!empty($_POST)) {
        if ((empty($_POST["username"]))||(empty($_POST["password"]))||(empty($_POST["email"]))||(empty($_POST["invite"]))||($_POST["invite"] != "MagmaCartaClub"))
        {
            $result = "> You did not enter all the required information.";
        }
        else
        {
            $username = strtoupper($_POST["username"]);
            $password = strtoupper($_POST["password"]);
            $password2 = strtoupper($_POST["password2"]);
            $email = strtoupper($_POST["email"]);
            if (strlen($username) < 4) {
                $result = "> Username too short.";
            };
            if (strlen($username) > 14) {
                $result = "> Username too long.";
            };
            if (strlen($password) < 3) {
                $result = "> Password too short.";
            };
            if (strlen($password) > 12) {
                $result = "> Password too long.";
            };
            if ($password!=$password2) {
                $result = "> Passwords do not match.";
            };
            if (strlen($email) < 10) {
                $result = "> Email was too short.";
            };
            if (strlen($email) > 50) {
                $result = "> Email was too long.";
            };
            if (preg_match($user_chars,$username)) {
                    $result = "> Username contained illegal characters.";
            };
            if (preg_match($user_chars,$password)) {
                    $result = "> Password contained illegal characters.";
            };
            if (!preg_match($email_chars,$email)) {
                    $result = "> Email was in an incorrect format.";
            };
            if (strlen($result) < 1)
            {
                $username = mysql_real_escape_string($username);
                $password = mysql_real_escape_string($password);
                $email = mysql_real_escape_string($email);
                unset($qry);
                $qry = @mysql_query("select username from " . mysql_real_escape_string($r_db) . ".account where username = '" . $username . "'", $con);
                if (!$qry) {
                    $result = "> Error querying database: " . mysql_error();
                }
                else
                {
                    if ($existing_username = mysql_fetch_assoc($qry)) {
                        foreach ($existing_username as $key => $value) {
                            $existing_username = $value;
                        };
                    };
                    $existing_username = strtoupper($existing_username);
                    if ($existing_username == strtoupper($_POST['username'])) {
                        $result = "> That username is already taken.";
                    }
                    else
                    {
                        unset($qry);
                        $qry = @mysql_query("select email from " . mysql_real_escape_string($r_db) . ".account where email = '" . $email . "'", $con);
                        if (!$qry) {
                            $result = "> Error querying database: " . mysql_error();
                        }
                        else
                        {
                            if ($existing_email = mysql_fetch_assoc($qry)) {
                                foreach ($existing_email as $key => $value) {
                                    $existing_email = $value;
                                };
                            };
                            if ($existing_email == strtoupper($_POST['email'])) {
                                $result = "> That email is already in use.";
                            }
                            else
                            {
                                unset($qry);
                                $sha_pass_hash = sha1(strtoupper($username) . ":" . strtoupper($password));
                                $register_sql = "insert into " . mysql_real_escape_string($r_db) . ".account (username, sha_pass_hash, email) values (upper('" . $username . "'),'" . $sha_pass_hash . "','" . $email . "')";
                                $qry = @mysql_query($register_sql, $con);
                                if (!$qry) {
                                    $result = "> Error creating account: " . mysql_error();
                                }
                                else
                                {
                                    $result = "> Account successfully created.";
                                };
                            };
                        };
                    };
                };
            };
        };
    };
};
?>

<?php include_once('header.php'); ?>


<table style="margin-left: auto; margin-right: auto; width: 75%">
    <tr><td style="width: 40%;">
        <h4>Account Creation</h4>
        <p class="red" id="regresult"><?php if(isset($result)){ echo $result; } ?>
        <form name="form" class="form" method="post" action="index.php">
            <input id="form__token" name="form[_token]" value="7XaIY8g-l6N51oQuzMtr8Ph3RJk6C9DEAjs-BpJUAbA" type="hidden">
            <table>
            <tr><td class="lcol">Username:</td><td class="rcol"><input id="form_username" name="username" required="required" class="mana-input" placeholder="Username" type="text"></td></tr>
            <tr><td class="lcol">Password:</td><td class="rcol"><input id="form_password_first" name="password" required="required" class="mana-input" placeholder="Password" type="password"></td></tr>
            <tr><td class="lcol">Confirm:</td><td class="rcol"><input id="form_password_second" name="password2" required="required" class="mana-input" placeholder="Repeat password" type="password"></td></tr>
            <tr><td class="lcol">Email:</td><td class="rcol"><input id="form_email" name="email" required="required" class="mana-input" placeholder="Email" type="email"></td></tr>
            <tr><td class="lcol">Invite Code:</td><td class="rcol"><input id="form_invite" name="invite" required="required" class="mana-input" placeholder="010101" type="password"></td></tr>
            <tr><td colspan=2>&nbsp;</td></tr>
            <tr><td></td>
            <td class="rcol">
                <button type="submit" id="form_save" name="form[save]" class="btn btn-primary">Register</button>
            </td></tr>
            </table>
        </form>
    </td><td style="width: 20%;"><td style="width: 40%; text-align: left;">
        <h4>Instructions</h4>
        <ul>
        <li>Download a 1.12.1 client from <a href="https://www.dkpminus.com/blog/vanilla-wow-download-1-12-1-client/" target="_new">here</a> (fast) or <a href="Elysium Project Game Client.zip" target="_new">here</a> (slow) 
        <li>
            Edit the content of the file <code>realmlist.wtf</code> to:<br/>
            <code>set realmlist <?php if(isset($realmip)){ echo $realmip; } else { echo "127.0.0.1";} ?></code>
        </li>
        <li>
            Launch Wow.exe (not the launcher)<br/>
            <img width=225 src="images/wowexe.png" >
        </li>
        <li>Play!</li>
        </ul>
    </td></tr>
</table>

<?php include_once('footer.php'); ?>