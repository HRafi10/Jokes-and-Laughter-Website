<?php
    session_start();
    require_once("db.php");
    /*
    // Check whether the user has logged in or not.
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    } else {
    */
        $joketitle = $_SESSION['joke_title'];
        
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $query=$db->query("SELECT jokeID, user_id, joke_title, full_joke, post_time FROM jokes WHERE joke_title = '$joketitle';", PDO::FETCH_ASSOC);
        if($row = $query->fetch()){
            $_SESSION["jokeID"]=$row["jokeID"];
            $_SESSION["user_id"]=$row["user_id"];


        }
        else {
            // handle errors
            $errors["Database Error"] = "Could not retrieve user information";
        }
        $query=null;
        $db=null;
    
        } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    // retriving joke detail data for the joke
   
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); //encodes
        return $data;
    }
    $errors = array();
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $rating = $_GET["rating"];
        $ratRegex = '/[0-9]/';
        $dataOK = TRUE;

    if (!preg_match($ratRegex , $rating)) {
        $errors["rating"] = "Invalid rating";
        $dataOK = FALSE;
       }

       
       $jID = $_SESSION["jokeID"];
       $userID =  $_SESSION["user_id"];


  if ($dataOK) {
    // Connect to the database and verify the connection
    try {

        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $query = "INSERT INTO ratings (jokeID,rating,user_id)
        VALUES('$jID','$rating','$userID');";
        $result = $db->exec($query);
        header("Location: jokedetail.php");
        $query = null;
        $db=null;
        exit();

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
   }
    
    }
?>





<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/design.css" />
    <script src="js/eventHandlers.js"></script>

</head>

<body>
    <div id="container-login-history">
        <header id="header-login-history">
            <h1>Super Funny <a class="logout" href="jokelist.php">Joke List</a></h1>
        </header>
        <main id="main-left-login-history">

        </main>
        <section>
            <h2> Joke Details</h2>
        </section>

        <aside id="joke-list">
            <div class="all-info">
        <?php
           
           print_r($row);
        ?>
                 <p><?=$row['jokeID']?></p>
                <p><?=$row['user_id']?></p>
                <p><?=$row['joke_title']?></p>
                <p><?=$row['full_joke']?></p>

                <form action="jokedetail.php" class="rating-form" method="get">  
                       <input type="button" value="decrease" id="decrease" onclick="decreaseValue()">
                       <label for="rating">Enter a rating between 1 & 5: </label>
                       <input type="number" min="1" max="5" required id="rating" name="rating">
                       <p id="error-text-rating" class="error-text <?= isset($errors["rating"])?'':'hidden' ?>">Rating is invalid</p>
                       <input type="button" value="Increase" id="increase" onclick="increaseValue()">
                       <input type="submit"  id = "subjoke" value="rate it" class="rate" > 
                       <div id = "latest-rating"> </div>
                </form>
            
            </div>
            <?php
           $_SESSION["joke_id"]=$row["jokeID"];
            $query= null;
            $db=null;
            ?>
            
        </aside>
        <main id="main-right-login-history">

        </main>
        <footer id="footer-login-history">
            <p class="footer-text">Laughter Therapy</p>
        </footer>
    </div>
    <script src="js/eventRegisterJokedetail.js"></script> 
</body>

</html>