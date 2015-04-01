<?php
require_once('../../mysqlconnector.php');
require_once('../../templates/sqlaction.php');
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 2/10/15
 * Time: 4:08 PM
 */
class Response extends SQLAction {
    private $id;
    private $questions_id;
    private $attempts_id;
    private $options_id;

    public function __construct($questions_id, $attempts_id, $options_id, $id=0)
    {
        $this->id = $id;
        $this->questions_id = $questions_id;
        $this->attempts_id = $attempts_id;
        $this->options_id = $options_id;
    }

    public function __destruct() {
    }

    public function __get($name) {
        return $this->$name;
    }

    public function to_table_row() {
        return "<tr><td>$this->id</td><td>$this->questions_id</td><td>$this->attempts_id</td>" .
        "<td>$this->options_id</td></tr>";
    }

    public static function add_response(Response $response) {
        //Check connection to database
        $db = DBConnector::get_db_connection();

        //Prepare the statement so we can bind data to it
        $sql = "INSERT INTO responses (questions_id, attempts_id, options_id) VALUES (?, ?, ?)";
        if (!$statement = $db->prepare($sql)) {
            echo "Prepare failed: ($db->errno) $db->error";
        }

        //Bind the parameters to the insert statement
        $statement->bind_param("iii", $response->questions_id, $response->attempts_id, $response->options_id);

        //Run query
        if (!$statement->execute()) {
            echo "Execution of prepared statement failed: ($statement->errno) $statement->error";
        }

        $statement->close();
        $db->close();
    }

    public static function delete_response($response_id) {
        $sql = "DELETE FROM responses WHERE id=?;";
        SQLAction::delete_by_id_query($sql, $response_id);
    }

    public static function get_response_by_id($response_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM responses WHERE id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $response_id);

        return Response::get_array_of_responses($statement, $db);
    }

    public static function get_response_by_person($persons_id) {
        //Check connection to database
        $db = DBConnector::get_db_connection();
        //TODO: this and this is a join
        //$sql = "SELECT * FROM responses WHERE responses.=" . $persons_id;

        //$result = $db->query($sql);

        //return $result->fetch_assoc();
    }

    public static function get_response_by_question($question_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM responses WHERE questions_id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $question_id);

        return Response::get_array_of_responses($statement, $db);
    }

    public static function get_response_by_option($option_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM responses WHERE options_id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $option_id);

        return Response::get_array_of_responses($statement, $db);
    }

    public static function get_response_by_attempt($attempt_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM responses WHERE attempts_id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $attempt_id);

        return Response::get_array_of_responses($statement, $db);
    }

    private static function get_array_of_responses($statement, $db) {
        $statement->bind_result($id, $questions_id, $attempts_id, $options_id);

        $responses = array();

        while ($statement->fetch()) {
            $responses[] = new Response($questions_id, $attempts_id, $options_id, $id);
        }

        $db->close();
        $statement->close();

        return $responses;
    }

    public static function get_table_header(){
        return "<tr><th>ID</th><th>Question ID</th><th>Attempt ID</th><th>Option ID</th></tr>";
    }
}

?>