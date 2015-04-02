<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 4/1/15
 * Time: 11:56 PM
 */

include_once("quizcontroller.php");
include_once("../questions/questioncontroller.php");
include_once("../options/option.php");
include_once("../options/optioncontroller.php");
include_once("../../templates/quiztemplate.php");

//TODO: Add attempts logic to make sure a user only took it the allow number of times

//Check if the user is logged in
session_start();

$authenticated = false;
$persons_id = 0;
if (isset($_SESSION['persons_id'])) {
    $persons_id = $_SESSION['persons_id'];
    $authenticated = true;
}

//Get the lesson_id
$lesson_id = null;
if ( !empty($_GET['lesson_id'])) {
    $lesson_id = $_REQUEST['lesson_id'];
}

//If no ID set, just reroute them back to list of lessons
if ( $lesson_id == null ) {
    header("Location: ../lessons/index.php");
}

$lesson_id = 2;

//Get the quiz for this lesson.
$quiz = QuizController::get_quiz_by_lesson_id($lesson_id);

//TODO: Check if quiz even exist.

//Start rendering the quiz page.
$quiz_page = new QuizTemplate($quiz->title);

//Get an array of questions
$questions = QuestionController::get_questions_by_quizzes_id($quiz->id);

//For each question, get an array of options, and render the page.
foreach ($questions as $q) {
    $options = OptionController::get_options_by_question_id($q->id);

    $quiz_page->add_question($q, $options);
}

echo $quiz_page->get_final_page();