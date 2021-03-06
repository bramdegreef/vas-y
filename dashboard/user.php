<?php
include_once("../php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$email = "";
$joindate = "";
$lastsession = "";
$id = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["id"])){
	$id = $_GET['id'];
} else {
    header("location: http://vas-y.comlu.com");
    exit();	
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "That user does not exist or is not yet activated, press back";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($user_ok == true && $id == $log_id){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
    $voornaam = $row["Voornaam"];
    $familienaam = $row["Familienaam"];
    $school = $row["School"];
    $signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Vas-y</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/loginSignup.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script type="text/javascript">
        $("document").ready(function () {
            var right = document.getElementById('messagesDiv').style.height;
            var left = document.getElementById('profileInfoDiv').style.height;
            if (left > right) {
                document.getElementById('profileInfoDiv').style.height = left;
            } else {
                document.getElementById('messagesDiv').style.height = right;
            }
        });
    </script>
</head>

<body>

    <!--Nav bar-->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="user.php?id=<?php echo $log_id;?>">Vas-y</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right navbarDashboard">
                    <li>
                        <a href="berichten.php"><span class="glyphicon glyphicon-envelope"></span> Berichten</a>
                    </li>
                    <li>
                        <a href="account.php"><img src="../img/user.png" class="img-circle" width="20" height="20"> Mijn account</a>
                    </li>
                    <li>
                        <a href="#" onclick="tryLogout()"><span class="glyphicon glyphicon-log-out"></span> Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-sm-3" id="leftDash">
            <ul id="menu">
                <li><a href="user.php?id=<?php echo $log_id;?>">Dashboard</a></li>
                <li><a href="berichten.php">Berichten</a></li>
                <li><a href="leerkrachten.php">Leerkrachten</a></li>
                <li><a href="#Afspraken">Jouw afspraken</a></li>
            </ul>
        </div>

        <div class="col-sm-8" id="rightDash">
            <h1>Dashboard:</h1>

            <div class="col-sm-3 pressedDiv" id="profileInfoDiv">
                <img src="../img/user_student.png" class="img-circle" id="profilePic">
                <p>Leerling:
                    <?php echo $voornaam; echo " "; echo $familienaam;?>
                </p>
                <p>School:
                    <?php echo $school;?>
                </p>
                <!--<p>Klas X</p>-->
                <p>Owner:
                    <?php echo $isOwner;?>
                </p>
            </div>

            <div class="pressedDiv rightPressedDiv col-sm-8" id="messagesDiv">
                <b> Berichten</b> <span class="glyphicon glyphicon-envelope"></span>
                <br>
                <div id="messagesBox">
                    Je hebt geen nieuwe berichten
                </div>
            </div>

            <div class="pressedDiv col-sm-11">
                
                <table id="messages">
                    <tr>
                        <th colspan="2">
                            MELDINGEN:
                        </th>
                    </tr>
                    <tr>
                        <td width="1%"><img src="../img/exclamation.png" /></td>
                        <td>Je hebt momenteel geen nieuwe meldingen</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>


</body>

</html>