<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

// This variables will keep track of errors and form values
// we find while processing the form but we'll make them global
// so we can display POST results on the form when there's an error.
$errors = array();
$firstName = "";
$lastName = "";
$username = "";
$password = "";
$dob = "";

    // Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If we got here through a POST submitted form, process the form

    // Collect and validate form inputs
    $firstName = test_input($_POST["fname"]);
    $lastName = test_input($_POST["lname"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $dob = test_input($_POST["date-of-birth"]);;
    
    // Form Field Regular Expressions
    $nameRegex = "/^[a-zA-Z]+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^.{8}$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    
    // Validate the form inputs against their Regexes 
    $dataOK = TRUE;
    if (!preg_match($nameRegex, $firstName)) {
        $errors["fname"] = "Invalid First Name";
        $dataOK = FALSE;
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors["lname"] = "Invalid Last Name";
        $dataOK = FALSE;
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["dob"] = "Invalid DOB";
        $dataOK = FALSE;
    }

    // Declare $target_file here so we can use it later
    $target_file = "";
    if ($dataOK) {
        // TODO 4a: try to make a MySQL connection
        /* ??? */ try{
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            
            // TODO 5a: write a SQL query that counts matches for the username in the Loggers table
            $query = "SELECT COUNT(*) FROM users WHERE username='$username'";

            // TODO 5b: use PDO::query() to run the query
            $result = $db->query($query);

            // TODO 5c: use PDOStatement::fetchColumn() to get the value of the first result of the query
            $matches = $result->fetchColumn();

            // If that email address is not already taken
            if ($matches == 0) {

                // TODO 6a: use PDO::exec() with an INSERT INTO statement to store the user's details in the Loggers table.
                //          Hint: Use "avatar_stub" as a temporary value for avatar_url.
            
                $query = "INSERT INTO users (fname,lname,username, dob, passwd)
                VALUES('$firstName','$lastName','$username','$dob','$password')";
                $result = $db->exec($query);

                if (!$result) {
                    $errors["Database Error:"] = "Failed to insert user";
                } else {
                    // Directory where the avatars will be uploaded.
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["profile-photo"]["name"]);
                    $uploadOk = TRUE;
                
                    // Fetch the image filetype
                    $imageFileType = strtolower(pathinfo($_FILES["profile-photo"]["name"],PATHINFO_EXTENSION));
                    $imageFileName = strtolower(pathinfo($_FILES["profile-photo"]["name"],PATHINFO_FILENAME));
                    // Check whether the file exists in the uploads directory
                    if (file_exists($target_file)) {
                        $errors["profilephoto"] = "Sorry, file already exists. ";
                        $uploadOk = FALSE;
                    }
                        
                    // Check whether the file is not too large
                    if ($_FILES["profile-photo"]["size"] > 1000000) {
                        $errors["profilephoto"] = "File is too large. Maximum 1MB. ";
                        $uploadOk = FALSE;
                    }

                    // Check image file type
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        $errors["profilephoto"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                        $uploadOk = FALSE;
                    }
                                    
                    // Check if $uploadOk still TRUE after validations
                    if ($uploadOk) {
                        // Move the user's avatar to the uploads directory and capture the result as $fileStatus.
                        $fileStatus = move_uploaded_file($_FILES["profile-photo"]["tmp_name"], $target_file);

                        // Check $fileStatus:
                        if (!$fileStatus) {
                            // The user's avatar file could not be moved
                            // TODO 8a: add a suitable error message to errors array be displayed on the page
                            $errors["Server Error"] = "avatar file couldn't be uploaded";

                            // TODO 8b: use PDO::exec() with a DELETE FROM statement to remove the temporary user record
                            $query = "DELETE FROM users WHERE username='$username'";
                            $result = $db->exec($query);
                            if (!$result) {
                                $errors["Database Error"] = "could not delete user when avatar upload failed";
                            }

                            $db = null;
                        } else {
                            // TODO 6d: use PDO::exec() to UPDATE the user's avatar_url field 
                            //          in the Loggers table so that we can easily use it.
                            $query =  "UPDATE users SET avatar= '$target_file' WHERE username= '$username'";
                            $result = $db->exec($query);
                            if (!$result) {
                                $errors["Database Error:"] = "could not update avatar_url";
                            } else {
                                // TODO 7a: close the database connection
                                $db = null;
                                // TODO 7b: redirect the user to the login page
                                header("Location: login.php");
                                // TODO 7c: exit the php script
                                exit();

                            }
                        }
                    } // image was uploadOk
                } // Insert user query worked
            } else {
                // The email address was found in the Users table 
                $errors["Account Taken"] = "A user with that username already exists.";
            }
            
        // TODO 4b: catch and report any db errors
        } catch (PDOException $e) {
            echo "PDO Error >> " . $e->getMessage() . "\n<br />";
        }
        

    } // $dataOk was TRUE

    if (!empty($errors)) {
        foreach($errors as $error => $message) {
            print("$error: $message \n<br />");
        }
    }

} // submit method was POST
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
            <form class="auth-form" id="reg-form" action="login.php" method="post" enctype="multipart/form-data">
                <p class="input-field">
                  
                    <!-- label for the first name input -->
                    <label for="fname"> First name: </label> 
                    <input type="text" name="fname" id="fname" value="<?= $firstName ?>"></input></p>
                    <p id="error-text-fname" class="error-text <?= isset($errors['fname'])?'':'hidden' ?>">First name is invalid</p>
                
                <p class="input-field">
            
                    <!-- label for the last name input -->
                    <label for="lname"> Last name: </label> 
                    <!-- last name input box -->
                    <input type="text" name="lname" id="lname" value="<?= $lastName ?>" > </input></p>
                    <p id="error-text-lname" class="error-text <?= isset($errors['lname'])?'':'hidden' ?>">Last name is invalid</p>

                <p class="input-field">

                    <label for="username"> Username: </label>
                    <!-- label for the username input -->
                    <input type="text" name="username" id="username" value="<?= $username ?>"></input></p>
                    <p id="error-text-username" class="error-text <?= isset($errors['username'])?'':'hidden' ?>">Username is invalid</p>

                <p class="input-field">

                    <label for="password"> Password: </label> 
                    <!-- label for the password input -->
                    <input type="password" name="password" id="password" value="<?= $password ?>"></input></p>
                    <p id="error-text-password" class="error-text <?= isset($errors['password'])?'':'hidden' ?>">Password is invalid</p>

                <p class="input-field">

                    <label for="confirm-password"> confirm-password: </label> 
                    <!-- label for the confirm-password input -->
                    <input type="password" name="confirm-password" id="confirm-password"></input></p>
                    

                <p class="input-field">
                   
                    <!-- label for the date of birth input -->
                    <label for="date-of-birth"> date-of-birth: </label> 
                    <!-- date of birth input box -->
                    <input type="date" name="date-of-birth" id="date-of-birth" value="<?= $dob ?>"></input></p>
                    <p id="error-text-dob" class="error-text <?= isset($errors['dob'])?'':'hidden' ?>">Date of birth is invalid</p>

                <p class="input-field">
                    
                    <label for="profile-photo"> Profile-photo: </label> 
                    <!-- label for the profile image input -->
                    <input type="file" name="profile-photo" accept="image/*" id="profile-photo"> </input></p>
                    <p id="error-text-profilephoto" class="error-text <?= isset($errors['profilephoto'])?'':'hidden' ?>">Profile photo is invalid</p>

                <p class="input-field">
                    
                   <input type="submit" value="signup"></input>

                </p>
            </form>
            <div class="foot-note">
    
                Already an user?
                <a href="login.php">Login</a>

                <!-- add login link -->
            </div>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">Laughter Therapy</p>
        </footer>
    </div>
    <!-- JS file containing event registration added here -->
    <script src="js/eventRegisterSignup.js"></script>
</body>

</html>