<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 2/8/15
 * Time: 3:41 PM
 */
include_once("attempt.php");
include_once("../../templates/tabletemplate.php");

/*
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['CALLING_PAGE'] = $_SERVER['REQUEST_URI'];
    header("Location: /~bswhitf1/login.php");
    exit;
}
*/

$table = new TableTemplate("Attempts");
$table->set_table_header(Attempt::get_table_header());

$attempts = Attempt::get_attempt_by_quiz(3);

foreach ($attempts as $a) {
    $table->add_table_data($a->to_table_row());
}

echo $table->get_final_page();

?>