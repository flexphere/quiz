<?php
 /*
 読み込みファイル名

 内容はUTF-8にて以下の書式に従って作成してください
 ----
 設問,選択肢(正解),選択肢(誤)
 設問,選択肢(正解),選択肢(誤)
 設問,選択肢(正解),選択肢(誤)
 ----
 */
 define('SRC_DATA', 'source.csv');



 /*************/


require_once(dirname(__FILE__) . '/../include/define.php');
require_once(dirname(__FILE__) . '/../include/common.php');


header("Content-type: text/html; charset=utf-8");

class DB extends SQLite3
{
    function __construct()
    {
        $this->open(dirname(dirname(__FILE__)) . '/sqlite.db');
    }

		public function add_master($label, $question, $ans1, $ans2){
			$sql = sprintf("INSERT INTO questions ('label', 'question', 'answer1', 'answer2') VALUES ('%s','%s','%s','%s');",
				$this->escapeString($label),
				$this->escapeString($question),
				$this->escapeString($ans1),
				$this->escapeString($ans2));
			return $this->_exec($sql);
		}

		public function clear_master(){
			$sql = "DELETE FROM question WHERE id > 0;";
			return $this->_exec($sql);
		}

		public function _exec($sql){
			$r = $this->exec($sql);
			if ( ! $r) {
				printf("%s (%s)", $this->sqlite_error_string  , $this->lastErrorCode);
			}
		}
}

$db = new DB();
$db->clear_master();

$lines = file(SRC_DATA);
$lesson = 1;
$cnt = 0;

foreach ($lines as $line){
	$line = mb_convert_encoding($line, 'utf-8', 'sjis-win');
	$data = array_map('strrev', explode(',', strrev(trim($line)), 4));
	$data = array_reverse($data);
	if (isset($data[3])) {
		if ($data[3] == 'ア' || $data[3] == 'イ') {
			register($db, $lesson, $data);
			$cnt++;
			if ($cnt % 15 == 0) $lesson++;
		}
	}
}
$db->close();

printf('%s問(%sLesson)登録しました', $cnt, $lesson);


function register($db, $lesson, $data){
	if ($data[3] == 'ア') {
		$db->add_master('Lesson'.$lesson, $data[0], $data[1], $data[2]);
	}
	if ($data[3] == 'イ') {
		$db->add_master('Lesson'.$lesson, $data[0], $data[2], $data[1]);
	}
}
