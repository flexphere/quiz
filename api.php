<?php
require_once('include/define.php');
require_once('include/common.php');
require_once('include/db.php');


//REQUEST_METHODチェック
if ($_SERVER['REQUEST_METHOD'] != 'POST') error_response('METHOD NOT ACCEPTABLE');

//student_id(ログイン)チェック
if ( ! $student_id = _c('mem_id')) error_response(LOGIN_URL, 301);

//student_id整合性チェック
//if (_c('student_id') && _p('student_id') != $student_id) error_response('STUDENT_ID MISMTCH');

//actionチェック
$action = _p('action');
if ( ! function_exists($action)) error_response('NO SUCH ACTION');


// $student_id =  '123';
// $action =  'get_state';

//action実行
$db = new DB();
$state = $db->get_state($student_id);
call_user_func($action, $db, $state);
$db->close();


/**
 *  actions定義
 */

/*
 * ニックネーム登録
 */
function set_nickname($db, $state){
  $state->nickname = _p('nick');
  $db->set_state($state);
}

/*
 * 不正解時に保存
 */
function set_incorrect($db, $state){
  if ( ! in_array(_p('qid'), $state->revise)) {
    $state->revise[] = _p('qid');
    $db->set_state($state);
  }
}

/*
 * 全問正解の場合
 */
function set_complete($db, $state){
  $state = set_state_complete($state);
  $db->set_state($state);
}

/*
 * 全問正解できなかった場合
 */
function set_fail($db, $state){
  $state = set_state_fail($state);
  $db->set_state($state);
}

/*
 * ユーザーにあった問題を10問ピックアップ
 */
function get_question($db, $state){
  $label = get_active_lesson($state);
  $questions = get_questions($label);
  response($questions);
}


/**
 *  responses定義
 */
function response($json){
  header("Content-Type: application/json; charset=utf-8");
  print(json_encode($json));
}

function error_response($msg='不正アクセス', $status=500){
  header("Content-Type: text/html; charset=utf-8", true, $status);
  if (DEBUG) echo($msg);
  exit;
}
