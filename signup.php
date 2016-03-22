<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["firstName"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$firstName = preg_replace('#[^a-z0-9]#i', '', $_POST['firstName']);
	$lastName = preg_replace('#[^a-z0-9]#i', '', $_POST['lastName']);
    $gender = $_POST['gender'];
    $email = $_POST['email'];
	$password = $_POST['password'];
    $school = $_POST['school'];
    
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM Leerlingen WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
    if ($u_check > 0){ 
        echo "The email you entered is alreay taken";
        exit();
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$password_hash = md5($password);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO Leerlingen (voornaam, familienaam, geslacht, email, password, school, ip, signup, lastlogin, notescheck)       
		        VALUES('$firstName','$lastName', '$gender', '$email', '$password_hash', '$school', '$ip',now(),now(),now())";
		
        if(mysqli_query($db_conx, $sql)){
            // Create directory(folder) to hold each user's files(pics, MP3s, etc.)
            //if (!file_exists("user/$email")) {
            //    mkdir("user/$email", 0755);
            //}
            echo "signup_success";
        }
        else{
            echo "failed to create account";
        }
		exit();
	}
	exit();
}
?>