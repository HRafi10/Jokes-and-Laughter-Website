<?php
    session_start();
    require_once("db.php");
    //$firstname = $_SESSION["fname"]; 
    // Connect to the database and verify the connection
   if(!empty($_GET['post-joke']))
   {
    
    header("Location:postjoke.php");
   }

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
   
    // geting list for recent 20 jokes
    $query = $db->query("SELECT users.username, users.avatar, jokes.joke_title, jokes.full_joke, jokes.post_time
    FROM users
    INNER JOIN jokes ON users.user_id = jokes.user_id ORDER BY users.user_id DESC LIMIT 20;", PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/design.css" />

</head>

<body>
    <div id="container-login-history">
        <header id="header-login-history">
            <h1>Super Funny <a class="logout" href="logout.php">Logout</a></h1>
        </header>
        <main id="main-left-login-history">

        </main>
        <section>
            <h2>Search jokes by topics 
            <div class="search-container">
                <form action="">
                  <input type="text" placeholder="Search.." name="search">
                  <button type="submit">search</button>
                </form>
            </div>
            </h2>
            <div id="user-data">
            
            <p><?php echo $_SESSION["fname"]; ?></p>
                <!--  link with class="update-info" -->
                <form name= "postjoke" method = "get" action="postjoke.php" >
                <p>Want to post your joke and make us laugh?</p>
                <input type="submit" name="post-joke" value="Do it"/>
             </form> 
            </div>
        </section>

        <aside id="joke-list">
            <h2> All Jokes </h2>
            <table>
        <tr><th>Username</th><th>Avatar</th><th>Joke Title</th><th>Joke</th><th>Post Time</th></tr>
            <?php
            while($row = $query->fetch()) {

                //Switch out of PHP to emit HTML with fewer echoes!
                ?>
                <tr>
                    <td><?=$row['username']?></td><td><?=$row['avatar']?></td>
                    <td><a href="jokedetail.php"><?=$row['joke_title']?></a></td>
                    <td><?=$row['full_joke']?></td>
                    <td><?=$row['post_time']?></td>
                </tr>
        
                <?php //Switch back to PHP to end the loop
            }
           //$_SESSION["joke_title"]=$row["joke_title"];
           $query=null;
           $db = null;
            ?>
            </table>
        </aside>
        <main id="main-right-login-history">

        </main>
        <footer id="footer-login-history">
            <p class="footer-text">Laughter Therapy</p>
        </footer>
    </div>
</body>

</html>