<?php
require_once('include/db.php');

$db = new DB();
$db->clear_master();

$ins = 0;
$data = file('questions.csv', FILE_SKIP_EMPTY_LINES);
foreach ($data as $line){
	$line = trim($line);
	list($label, $img, $en, $ja) = explode(',', $line);
	$res = $db->add_questions($label, $img, $en, $ja);
	if ($res) $ins++;
}
$db->close();

header("Content-Type:text/html;Charset=utf-8");
print($ins . '件登録しました');
