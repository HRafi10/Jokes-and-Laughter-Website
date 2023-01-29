<?php
// Task 9: In the logout.php page, start the session, destroy the session, 
//         and redirect the user to the login.php page.

session_start();

header("Location: login.php");
session_unset(); 

session_destroy();


exit();
?>
