<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}


// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = array();
    $dataOK = TRUE;
    
    // Get and validate the username and password fields
    $username = test_input($_POST["username"]);
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }

    $password = test_input($_POST["password"]);
    $passwordRegex = "/^.{8}$/";
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }

    // Check whether the fields are not empty
    if ($dataOK) {

        // Connect to the database and verify the connection
        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);

            // TODO 9a: use PDO::query() to get the uid, first_name, last_name, and avatar_url
            //          of users that match the username and password
            $query = "SELECT fname, lname, dob, avatar FROM users WHERE username='$username'
            AND passwd = '$password'"; 
            $result = $db->query($query);

            if (!$result) {
                // handle errors
                $errors["Database Error"] = "Could not retrieve user information";
            } elseif ($row = $result->fetch()) {
                // If there's a row, we have a match and login is successful!
                
                // TODO 10a: start a session
                session_start();
                // TODO 10b: store the uid, first_name, last_name, and avatar_url fields from $row into the $_SESSION superglobal variable
                $_SESSION["user_id"]=$row["user_id"];
                $_SESSION["fname"]=$row["fname"];
                $_SESSION["lname"]=$row["lname"];
                $_SESSION["avatar"]=$row["avatar"];
            
                // TODO 10d: Close the database connection and redirect the user to the loginHistory.php page.
                $db = null;
                header("Location:jokelist.php");
                
                exit();
            } 
            
            $db = null;

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

    } else {

        $errors[] = "You entered a blank data while logging in.";
    }
    if(!empty($errors)){
        foreach($errors as $message) {
            echo $message . "<br />\n";
        }
    }

}
?>


<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/design.css" />
    <!-- JS file containing event handlers added here -->
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>Super Funny</h1>
        </header>
        <main id="main-left">

        </main>
        <main id="main-center">
            <form class="auth-form" id="log-form" action="jokelist.php" method="post">
                <p class="input-field">
                    
                    <!-- label for the username input -->
                     <label for="username"> Username: </label> 
                    <!-- username input box -->
                    <input type="text" name="username" id="username"> </input></p> 
                    <p id="error-text-username" class="error-text <?= isset($errors["username"])?'':'hidden' ?>">Username is invalid</p>

                <p class="input-field">
                    
                    <!-- label for the password input -->
                    <label for="password"> Password: </label> 
                    <!-- password input box -->
                    <input type="password" name="password" id ="password"></input></p>
                    <p id="error-text-password" class="error-text <?= isset($errors["password"])?'':'hidden' ?>">Password is invalid</p>

                <p class="input-field">

                    <input type="submit" value="login"> </input>
                     </form>
                </p>
            </form>
            <div class="foot-note">
                
                Don't have an account? <a href="signup.php">signup</a>
             
                <!-- add signup link -->
            </div>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">Laughter Therapy</p>
        </footer>
    </div>
    <!-- JS file containing event registration added here -->
    
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>