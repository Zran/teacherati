<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 4/2/15
 * Time: 12:28 AM
 */

class Question {
    private $id;
    private $quizzes_id;
    private $question;

    /**
     * Question constructor.
     * @param $id
     * @param $quizzes_id
     * @param $question
     */
    public function __construct($quizzes_id, $question, $id=0) {
        $this->id = $id;
        $this->quizzes_id = $quizzes_id;
        $this->question = $question;
    }

    public function __get($name) {
        return $this->$name;
    }
}