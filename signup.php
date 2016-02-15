<?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("php_includes/db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . $username . ' is available :-)</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' is already taken :-(</strong>';
	    exit();
    }
}

// Ajax calls this NAME CHECK code to execute
if(isset($_POST["emailcheck"])){
	include_once("php_includes/db_conx.php");
	$email = $_POST['emailcheck'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT id FROM users WHERE email='$email' LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $email_check = mysqli_num_rows($query);
        if ($email_check < 1) {
            echo '<strong style="color:#009900;">' . $email . ' is available</strong>';
            exit();
        } else {
            echo '<strong style="color:#F00;">' . $email . ' is taken</strong>';
            exit();
        }
    }
    else{
        echo '<strong style="color:#F00;">Invalid email!</strong>';
        exit();
    }
	
}

// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $msg = "First line of text\nSecond line of text";
    mail("bram.de.greef@hotmail.com","My subject",$msg);
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$p_hash = md5($p);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, ip, signup, lastlogin, notescheck)       
		        VALUES('$u','$e','$p_hash', '$ip',now(),now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username) VALUES ('$uid','$u')";
		$query = mysqli_query($db_conx, $sql);
		
		// Email the user their activation link
		$to = $e;							 
		$from = "bramdegreef@guidrbru.net23.net";
		$subject = 'Guidr Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Guidr Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"></a>Guidr Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.bramdegreef.byethost24.com/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "To: $to\r\n";
		$headers .= "From: $from\r\n";
		mail($to, $subject, $message, $headers);
		echo "signup_success";
		exit();
	}
	exit();
}
?>