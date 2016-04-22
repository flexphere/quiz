<?php
require_once(dirname(__FILE__) . '/define.php');

class DB extends SQLite3
{
    function __construct()
    {
        $this->open(dirname(dirname(__FILE__)) . '/sqlite.db');
    }

		public function add_questions($label, $question, $ans1, $ans2){
			$sql = sprintf("INSERT INTO questions ('label', 'question', 'answer1', 'answer2') VALUES ('%s','%s','%s','%s');",
				$this->escapeString($label),
				$this->escapeString($question),
				$this->escapeString($ans1),
				$this->escapeString($ans2));
			return $this->_exec($sql);
		}

		public function clear_master(){
			$sql = "DELETE FROM questions;";
			$this->_exec($sql);

			$sql = "DELETE FROM sqlite_sequence WHERE name='questions';";
			return $this->_exec($sql);
		}

		public function get_questions($label){
			$sql = sprintf("SELECT * FROM questions WHERE label='%s';",
				$this->escapeString($label));

			$r = $this->_query($sql);
			if ( ! $r) return FALSE;

			$ret = array();
			while ($row = $r->fetchArray(SQLITE3_ASSOC)) $ret[] =	$row;
			return $ret;
		}

		public function get_ranking($label){
			$sql = sprintf("SELECT * FROM highscore WHERE label = '%s' ORDER BY score LIMIT 100;",
				$this->escapeString($label));

			$r = $this->_query($sql);
			if ( ! $r) return FALSE;

			$ret = array();
			while ($row = $r->fetchArray(SQLITE3_ASSOC)) $ret[] =	$row;
			return $ret;
		}

		public function get_highscore($student_id, $label){
			$sql = sprintf("SELECT * FROM highscore WHERE student_id = '%s' and label = '%s';",
				$this->escapeString($student_id), $this->escapeString($label));

			$r = $this->querySingle($sql, true);
      if ($r) return $r['score'];
			return FALSE;
		}

		public function set_highscore($student_id, $nickname, $score, $label){
			$exists = $this->get_highscore($student_id, $label);
      var_dump($exists);
      if ($exists) {
        $sql = sprintf(
					"UPDATE highscore SET score='%s', nickname='%s' WHERE student_id='%s' and label = '%s';",
          $this->escapeString($score),
					$this->escapeString($nickname),
					$this->escapeString($student_id),
					$this->escapeString($label)
				);
      } else {
        $sql = sprintf(
					"INSERT INTO highscore (student_id, nickname, score, label) VALUES ('%s', '%s', '%s', '%s');",
          $this->escapeString($student_id),
					$this->escapeString($nickname),
					$this->escapeString($score),
					$this->escapeString($label)
				);
      }
			return $this->_exec($sql);
		}

		private function _exec($sql){
			$r = $this->exec($sql);
			if ( ! $r) {
				if (DEBUG) {
					printf("%s (%s)", $this->lastErrorMsg()  , $this->lastErrorCode());
				}
				return FALSE;
			}
			return TRUE;
		}

		private function _query($sql){
			$r = $this->query($sql);
			if ( ! $r ) {
				if (DEBUG) {
					printf('ERROR: %s (%s)', $this->lastErrorMsg(), $this->lastErrorCode());
				}
				return FALSE;
			}
			return $r;
		}
}
