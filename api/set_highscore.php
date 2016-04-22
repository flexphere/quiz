<?php
//require_once(dirname(dirname(dirname(__FILE__))) . "/config_shuyaku/config_li.php");
//f_checking();
$student_id = $_COOKIE['mem_id'];

require_once(dirname(dirname(__FILE__)) . '/include/db.php');
session_start();

if ( ! isset($_SESSION['label'])) {
	die('no label');
}
if ( ! isset($_SESSION['nickname'])) {
	die('no nick');
}
if ( ! isset($_POST['score'])) {
	die('no score');
}
if ( ! is_numeric($_POST['score'])) {
	die('score not integer');
}

$db = new DB();
$result = $db->set_highscore($student_id, $_SESSION['nickname'], $_POST['score'], $_SESSION['label']);
$db->close();

header("Content-Type: application/json; charset=utf-8");
print(json_encode($result));
