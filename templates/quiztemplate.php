<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 3/14/15
 * Time: 3:55 PM
 */

class QuizTemplate {
    private $heading;
    private $quiz_data;
    private $tail;

    private $question_number = 1;

    //TODO: Modify this to use basetemplate
    public function __construct($quiz_name)
    {
        $this->heading = "<!DOCTYPE html>
<html>
<head>
	<title>{'Quiz - ' . $quiz_name}</title>
	<meta http-equiv='content-type' content='text/html;charset=utf-8' />
    <link rel='stylesheet' type='text/css' href='https://bootswatch.com/cosmo/bootstrap.min.css'>
</head>
<body>
	<div class='container'>
		<h1>$quiz_name</h1>
		<hr>
		<form action='save-attempt.php'>";
        $this->tail = "<hr>
			<button type='submit' class='btn btn-primary' style='float:right;'>Submit</button>
		</form>
	</div>
</body>
</html>";
    }

    public function add_question($question, $options_array) {
        //TODO: Figure out the question->body
        $question_text = $this->question_number . ") " . $question->body;
        $question_html = "<div class='row'>
				<div class='col-md-2'></div>
				<div class='col-md-8'>
					<legend>$question_text</legend>
					<div class='form-group'>";
        foreach ($options_array as $option) {
            //TODO: Figure out the and $options->id
            $question_html = $question_html . "<label>
							<input type='radio' name='question_{$this->question_number}_choice' id='$option->id' value='$option->id'>
							Me
						</label>
						</br>";
        }
        $question_html = $question_html . "</div>
				</div>
			</div>";
        $this->quiz_data = $this->quiz_data . $question_html;
        $this->question_number += 1;
    }

    public function get_final_page() {
        return $this->heading . $this->quiz_data . $this->tail;
    }
}