<?php
require_once(dirname(__FILE__) . '/define.php');

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

		public function get_initial_lessons(){
			$sql =	sprintf("SELECT distinct(label) FROM questions;");
			$r = $this->_query($sql);
			if ( ! $r) return FALSE;

			$labels = array();
			while ($row = $r->fetchArray()) $labels[] = $row["label"];
			natsort($labels);

			$ret =	array();
			foreach($labels as $label) {
				$def = array("label"=>$label, "status"=>"locked", "trophy"=>"none", "icon"=>"lock");
				if ($label == $labels[0]) {
          $def["status"] = "active";
          $def["icon"] = "pencil";
        }
				$ret[] = $def;
			}
			return $ret;
		}

		public function get_questions($label){
			$sql = sprintf("SELECT * FROM questions WHERE label='%s';",
				$this->escapeString($label));

			$r = $this->_query($sql);
			if ( ! $r) return FALSE;

			$ret = array();
			while ($row = $r->fetchArray()) {
					$ret[] =	array(
            "id" => $row["id"],
						"label" => $row["label"],
						"question" => $row["question"],
						"options" => array($row["answer1"], $row["answer2"])
					);
			}
			return $ret;
		}

		public function get_state($student_id){
			$sql = sprintf("SELECT * FROM user_states WHERE student_id = '%s';",
				$this->escapeString($student_id));

			$r = $this->querySingle($sql, true);
			if (empty($r)) return FALSE;

			return json_decode($r['state']);
		}

		public function set_state($content){
      $exists = $this->get_state($content->student_id);

      if ($exists) {
        $sql = sprintf("UPDATE user_states SET state='%s' WHERE student_id='%s';",
          $this->escapeString(json_encode($content)), $this->escapeString($content->student_id));
      } else {
        $sql = sprintf("INSERT INTO user_states (student_id, state) VALUES ('%s', '%s');",
          $this->escapeString($content->student_id), $this->escapeString(json_encode($content)));
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

class mysqlDB extends mysqli
{
	public function __construct(){
		parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_error()) {
      die(sprintf('Connect Error (%s) %s',
						mysqli_connect_errno(),
						mysqli_connect_error()));
    }
		if ( ! parent::set_charset('utf8')) {
			die('Error loading character set');
		}
	}


	public function get_nickname($student_id){
		$sql = sprintf("SELECT nickname FROM t_nickname WHERE student_id = '%s'", $student_id);
		return $this->_query($sql);
	}

	/**
	 * レッスン一覧情報を取得
	 *
	 * @param string $student_id ユーザーID
	 * @return array レッスン情報
	 */
	public function list_lesson($student_id = NULL){
		$sql = "SELECT distinct(label) FROM m_question ORDER BY label ASC";
		$result = $this->_query($sql);

		while($obj = $result->fetch_assoc()) {
			$r[] = $obj['label'];
		}
		natsort($r);
		return $r;
	}

	/**
	 * レッスンの設問情報を取得
	 *
	 * @param integer レッスン番号
	 * @return array 設問・解答リスト（10件)
	 */
	public function get_lesson($lesson_num){

	}

	/**
	 * 不正解問題の取得
	 *
	 * @param string $student_id ユーザーID
	 * @return array 設問・解答リスト
	 */
	public function list_incorrect($student_id){

	}

	/**
	 * 不正解問題の記録
	 *
	 * @param string $student_id ユーザーID
	 * @param integer $question_id 設問ID
	 * @return boolean 処理成否
	 */
	public function set_incorrect($student_id, $question_id){

	}

	public function add_master($label, $question, $ans1, $ans2){
		$sql = sprintf("INSERT INTO m_question ('label', 'question', 'answer1', 'answer2') VALUES ('%s','%s','%s','%s');",
			$this->real_escape_string($label),
			$this->real_escape_string($question),
			$this->real_escape_string($ans1),
			$this->real_escape_string($ans2));

		return $this->_query($sql);
	}

	public function clear_master(){
		$sql = "DELETE FROM m_question WHERE id > 0;";
		return $this->_query($sql);
	}

	private function _query($sql){
		$result = $this->query($sql);
		if ( ! $result) {
			if (DEBUG) printf("Error: %s\n", $this->error);
    }
		return $result;
	}
}
