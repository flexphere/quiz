<?php
$student_id = $_COOKIE['mem_id'];

require_once(dirname(dirname(__FILE__)) . '/include/db.php');
session_start();
$label = isset($_SESSION['label']) ? $_SESSION['label'] : 'food1';

$db = new DB();
$data = new stdClass();

//ranking
$data->ranking = $db->get_ranking($label);

//score
$data->highscore = $db->get_highscore($student_id, $label);

//question
$data->questions = $db->get_questions($label);

$db->close();

header("Content-Type: application/json; charset=utf-8");
print(json_encode($data));
?>
