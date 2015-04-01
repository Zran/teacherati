<?php
/**
 * Created by IntelliJ IDEA.
 * User: brad
 * Date: 3/19/15
 * Time: 2:53 PM
 */

abstract class BaseTemplate {

    protected function get_footer() {
        return "</div>
</body>
</html>";
    }

    protected function get_header($title) {
        return "<!DOCTYPE html>
<html>
<head>
	<title>$title</title>
	<meta http-equiv='content-type' content='text/html;charset=utf-8' />
    <link rel='stylesheet' type='text/css' href='https://bootswatch.com/cosmo/bootstrap.min.css'>
</head>
<body>
	<div class='container'>";
    }

    public abstract function get_final_page();
}