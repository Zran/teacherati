<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 4/2/15
 * Time: 12:29 AM
 */

include_once("../../mysqlconnector.php");
include_once("../../templates/sqlaction.php");
include_once("question.php");

class QuestionController {
    public static function get_question_by_id($questions_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM questions WHERE id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $questions_id);

        $statement->bind_result($id, $quizzes_id, $question);

        $statement->fetch();

        $question = new Question($quizzes_id, $questions_id, $id);

        return $question;
    }

    public static function get_questions_by_quizzes_id($quiz_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM questions WHERE quizzes_id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $quiz_id);

        $statement->bind_result($id, $quizzes_id, $question);

        $questions = array();

        while ($statement->fetch()) {
            $questions[] = new Question($quizzes_id, $question, $id);
        }

        $statement->close();
        $db->close();

        return $questions;
    }
}