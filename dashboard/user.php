<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$email = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["email"])){
	$email = $_GET['email'];
} else {
    header("location: http://vas-y.comlu.com");
    exit();	
}
// Select the member from the users table
$sql = "SELECT * FROM Leerlingen WHERE email='$email' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "That user does not exist or is not yet activated, press back";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($user_ok == true && $email == $log_email){
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
    <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/loginSignup.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
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
                <a class="navbar-brand" href="index.html">Vas-y</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right navbarDashboard">
                    <li>
                        <a href="dashboard/berichten.html"><span class="glyphicon glyphicon-envelope"></span> Berichten</a>
                    </li>
                    <li>
                        <a href="dashboard/account.html"><img src="../img/user.png" class="img-circle" width="20" height="20"> Mijn account</a>
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
                <li><a href="index.html">Dashboard</a></li>
                <li><a href="berichten.html">Berichten</a></li>
                <li><a href="leerkrachten.html">Leerkrachten</a></li>
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

            <div class="pressedDiv col-sm-12">
                <div class="tab-content">
                    <div id="#Leerkracht">
                        leerkracht
                    </div>
                    <div id="#Vak">
                        vak
                    </div>
                    <div id="#School">
                        scholen
                    </div>
                    <div id="#Les">
                        overzicht lessen
                    </div>
                </div>
            </div>

        </div>
    </div>


</body>

</html>