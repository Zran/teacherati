<?php
require_once('../../mysqlconnector.php');
require_once('../../templates/sqlaction.php');
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 2/4/15
 * Time: 9:28 PM
 */

class Attempt {
    private $id;
    protected $persons_id;
    protected $quizzes_id;
    protected $attempt_date;
    protected $attempt_number;
    protected $score;

    public function __construct($persons_id, $quizzes_id, $attempt_date, $attempt_number, $score, $id = 0)
    {
        $this->id = $id;
        $this->persons_id = $persons_id;
        $this->quizzes_id = $quizzes_id;
        $this->attempt_date = $attempt_date;
        $this->attempt_number = $attempt_number;
        $this->score = $score;
    }

    public function __destruct() {
    }

    /**
     * @param mixed $attempt_number
     */
    public function set_attempt_number($attempt_number)
    {
        $this->attempt_number = $attempt_number;
    }

    /**
     * @param mixed $score
     */
    public function set_score($score)
    {
        $this->score = $score;
    }

    public function __get($name) {
        return $this->$name;
    }

    public static function add_attempt(Attempt $attempt) {
        //Check connection to database
        $db = DBConnector::get_db_connection();

        //Prepare the statement so we can bind data to it
        $sql = "INSERT INTO attempts (persons_id, quizzes_id, attempt_date, attempt_number, score) VALUES (?, ?, ?, ?, ?)";
        if (!$statement = $db->prepare($sql)) {
            echo "Prepare failed: ($db->errno) $db->error";
        }

        //Bind the parameters to the insert statement
        $statement->bind_param("iisii", $attempt->persons_id, $attempt->quizzes_id, $attempt->attempt_date, $attempt->attempt_number, $attempt->score);

        //Run query
        if (!$statement->execute()) {
            echo "Execution of prepared statement failed: ($statement->errno) $statement->error";
        }

        $statement->close();
        $db->close();
    }

    public static function update_attempt(Attempt $attempt) {
        //Check connection to database
        $db = DBConnector::get_db_connection();

        //TODO: bind this
        $sql = "SELECT * FROM attempts WHERE id=" . $attempt->id;

        $result = $db->query($sql);

        if (!($result->num_rows == 1)) {
            die("Attempt not found in the database!");
        }

        //Prepare the statement so we can bind data to it
        $sql = "UPDATE attempts SET attempt_date = ?, attempt_number = ?, score = ? WHERE id=?;";
        if (!$statement = $db->prepare($sql)) {
            echo "Prepare failed: ($db->errno) $db->error";
        }

        //Bind the parameters to the insert statement
        $statement->bind_param("siii", $attempt->attempt_date, $attempt->attempt_number, $attempt->score, $attempt->id);

        //Run query
        if (!$statement->execute()) {
            echo "Execution of prepared statement failed: ($statement->errno) $statement->error";
        }

        $statement->close();
        $db->close();
    }

    public static function delete_attempt($attempt_id) {
        //Prepare the statement so we can bind data to it
        $sql = "DELETE FROM attempts WHERE id=?;";
        SQLAction::delete_by_id_query($sql, $attempt_id);
    }

    public static function get_attempt_by_id($attempt_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM attempts WHERE id=" . $attempt_id;

        $statement = SQLAction::get_by_id_query($db, $sql, $attempt_id);

        return Attempt::get_array_of_attempts($statement, $db);
    }

    public static function get_attempt_by_person($person_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM attempts WHERE persons_id=" . $person_id;

        $statement = SQLAction::get_by_id_query($db, $sql, $person_id);

        return Attempt::get_array_of_attempts($statement, $db);
    }

    public static function get_attempt_by_quiz($quiz_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM attempts WHERE quizzes_id=?;";

        $statement = SQLAction::get_by_id_query($db, $sql, $quiz_id);

        return Attempt::get_array_of_attempts($statement, $db);
    }

    private static function get_array_of_attempts($statement, $db) {
        $statement->bind_result($id, $person_id, $quiz_id, $attempt_date, $attempt_number, $score);

        $attempts = array();

        while ($statement->fetch()) {
            $attempts[] = new Attempt($person_id, $quiz_id, $attempt_date, $attempt_number, $score, $id);
        }

        $db->close();
        $statement->close();

        return $attempts;
    }

    public static function get_table_header() {
        return "<tr><th>ID</th><th>Person ID</th><th>Quiz ID</th><th>Attempt Date</th>" .
        "<th>Attempt Number</th><th>Score</th></tr>";
    }

    public function to_table_row() {
        return "<tr><td>$this->id</td><td>$this->persons_id</td><td>$this->quizzes_id</td>" .
        "<td>$this->attempt_date</td><td>$this->attempt_number</td><td>$this->score</td></tr>";
    }

}

?>