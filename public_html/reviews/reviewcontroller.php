<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 4/1/15
 * Time: 3:25 PM
 */

include_once("../../mysqlconnector.php");
include_once("../../templates/sqlaction.php");
include_once("review.php");

class ReviewController {

    public static function get_review_by_id($id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM reviews WHERE id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $id);

        $statement->bind_result($id, $persons_id, $lessons_id, $title, $review, $date_submitted, $rating);

        $statement->fetch();

        $review = new Review($persons_id, $lessons_id, $title, $review, $date_submitted, $rating, $id);

        $statement->close();
        $db->close();

        return $review;
    }

    public static function get_reviews_by_lessons_id($lessons_id) {
        $db = DBConnector::get_db_connection();
        $sql = "SELECT * FROM reviews WHERE lessons_id=?";

        $statement = SQLAction::get_by_id_query($db, $sql, $lessons_id);

        return ReviewController::get_array_of_reviews($db, $statement);
    }

    public static function get_array_of_reviews($db, $statement){
        $statement->bind_result($id, $persons_id, $lessons_id, $title, $review, $date_submitted, $rating);

        $reviews = array();

        while ($statement->fetch()) {
            $reviews[] = new Review($persons_id, $lessons_id, $title, $review, $date_submitted, $rating, $id);
        }

        $db->close();
        $statement->close();

        return $reviews;
    }

    public static function get_table_header(){
        return "<tr><th>ID</th><th>Reviewer</th><th>Title</th><th>Review</th><th>Date Submitted</th>" .
            "<th>Rating</th><th></th></tr>";
    }
}