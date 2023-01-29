<?php

session_start();
require_once("db.php");
/*
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
} else {
*/
    $firstName = $_SESSION["fname"];
    $lastName = $_SESSION["lname"];
    $user_id = $_SESSION["user_id"];
    $avatar = $_SESSION["avatar"];


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
$jokeName = "";
$fullJoke = "";


    // Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If we got here through a POST submitted form, process the form

    // Collect and validate form inputs
    $jokeName = test_input($_GET["jokename"]);
    $fullJoke = test_input($_GET["fulljoke"]);
    
    // Form Field Regular Expressions
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    
    // Validate the form inputs against their Regexes 
    $dataOK = TRUE;

    if (!preg_match($unameRegex, $jokeName)) {
        $errors["jokename"] = "Invalid jokename";
        $dataOK = FALSE;
    }
    
    if($fullJoke == null || $fullJoke == "" ) {
        $dataOK = FALSE;
        $errors["fulljoke"] = "Joke is empty";
    }

    $tm=date("Y-m-d-h-i-s",time()); // getting current time

    if ($dataOK) {
        try{
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            
                $query = "INSERT INTO jokes (joke_title,full_joke,user_id, post_time)
                VALUES('$jokeName','$fullJoke','$user_id','$tm')";
                $result = $db->exec($query);

                if (!$result) {
                    $errors["Database Error:"] = "Failed to insert jokes";
                } else {
                
                                
                                header("Location: jokelist.php");
                                $db = null;
                                // TODO 7c: exit the php script
                                exit();

                        }
            }
        
        catch (PDOException $e) {
            echo "PDO Error >> " . $e->getMessage() . "\n<br />";
        }
        

    } // $dataOk was TRUE

    if (!empty($errors)) {
        foreach($errors as $error => $message) {
            print("$error: $message \n<br />");
        }
    }

} // submit method was GET
?>


<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/design.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>Super Funny <a class="logout" href="logout.php">Logout</a></h1>
        </header>
        <main id="main-left">

        </main>
        <main id="main-center">
            <form class="jform" id="jform" action="jokelist.php" method="get" enctype="text/plain">
                <p class="input-field">
                    
                    <!-- label for the username input -->
                     <label for="jokename"> Jokename: </label> 
                    <!-- username input box -->
                    <input type="text" id="jokename" name="jokename"> </input></p>
                    <p id="error-text-jokename" class="error-text <?= isset($errors["jokename"])?'':'hidden' ?>">Username is invalid</p>
                
                <p> character Count: <b id="char-count"> 0 </b> 
                
                </p>
                
                <p class="input-field">
                    
                    <!-- label for the joke input -->
                    <label for="fulljoke"> post your joke: </label> 
                    <!-- joke input box -->
                    <textarea id="fulljoke" name="fulljoke" rows="5" cols="20">
                    </textarea></p>
                    <p id="error-text-jokename" class="error-text <?= isset($errors["fulljoke"])?'':'hidden' ?>">Username is invalid</p>

                <p class="input-field">

                    <input type="submit" id="sub" value="submit"> </input>
                     </form>
                </p>
            </form>
            <div class="fnote">
                
                <a href="jokelist.php">Return to Home</a>
             
    
            </div>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">Laughter Therapy</p>
        </footer>
    </div>
    <script src="js/eventRegisterPostJokes.js"></script>
</body>

</html>