<?php
define("DB_SERVER", "localhost");
define("DB_NAME", "CIS355bswhitf1");
define("DB_USER", "CIS355bswhitf1");
define("DB_PASSWORD", "scarydoll");

/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 2/4/15
 * Time: 9:52 PM
 */
class DBConnector {

    public static function get_db_connection() {
        $mysqli  = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->connect_error) {
            //Figure out how to throw proper exception
            die("Connection failed: " . mysqli_connect_error());
        }
        else {
            return $mysqli;
        }
    }

}

/*$db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($db) {
    echo "Connected.<br/>";

    $sql = "SELECT id, role, first_name FROM persons LIMIT 0, 30;";
    //$sql = "show tables;";
    $result = $db->query($sql);

    echo '<pre>';
    var_dump($db);
    echo '</pre>';

    echo '<pre>';
    var_dump($result);
    echo '</pre>';

    //echo $result->fetch_all();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['id'] . ":id " . $row['role'] . " " . $row['first_name'];
        }
    }
    else {
        echo "0 results! <br/>";
    }
}*/

?>