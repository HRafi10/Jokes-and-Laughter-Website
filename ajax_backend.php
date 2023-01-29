<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}
$jokeID = $_SESSION["joke_id"];
$rating = $_REQUEST["q"];
// TODO 5a: Get the username field from the incoming request.

if ($rating > 0) {

    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $query="UPDATE ratings SET rating='$rating' WHERE jokeID='$jokeID';";
        $db->prepare($query);

        $query = "SELECT ratings.rating FROM ratings INNER JOIN jokes on (ratings.jokeID = jokes.jokeID) WHERE jokeID='$jokeID';";
        $result = $db->query($query, PDO::FETCH_ASSOC);
        // Create an empty array
        //$jsonArray = array();

        // TODO 5b: Loop the '$result' variable to store each row in the '$jsonArray' array.
        /*while($row = $result->fetch())
        {
            $jsonArray['rating'] = $row['rating'];

        }*/
        // TODO 5c: Encode the array into a JSON object and send it back to the client as a response.
        echo json_encode($result->fetchAll());

        // Close the database connection
        $db = null;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
