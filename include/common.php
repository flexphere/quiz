<?php

function get_state($student_id){
  $db =  new DB();
  $state = $db->get_state($student_id);
  if ( ! $state) {
    $state = get_initial_state($student_id);
    $db->set_state($state);
  }
  $db->close();
  return $state;
}

function get_questions($label, $limit=10){
  $db =  new DB();
  $questions = $db->get_questions($label);
  shuffle($questions);
  $ret =  array_slice($questions, 2, 10);
  return $ret;
}

function get_initial_state($student_id){
  $db = new DB();
  $initial_state = json_encode(array(
    "student_id"=>$student_id,
    "page"=>"index",
    "nickname"=> NULL,
    "lessons"=> $db->get_initial_lessons(),
    "revise"=>array()
  ));
  $db->close();
  return json_decode($initial_state);
}

function get_active_lesson($state){
  foreach ($state->lessons as $lesson) {
    if ($lesson->status == 'active') {
      return $lesson->label;
    }
  }
}

function set_state_complete($state){
  foreach ($state->lessons as $index => &$lesson){
    if ($lesson->status == active){
      if ($lesson->trophy == 'none') {
        $lesson->trophy =  'half';
      } else {
        $lesson->status = 'complete';
        $lesson->trophy = 'full';
        $lesson->icon = 'check';

        $next_lesson = &$state->lessons[$index + 1];
        $next_lesson->status = 'active';
        $next_lesson->trophy = 'none';
        $next_lesson->icon = 'pencil';
      }
      break;
    }
  }
  return $state;
}

function set_state_fail($state){
  foreach ($state->lessons as $index => &$lesson){
    if ($lesson->status == active){
      if ($lesson->trophy == 'half') {
        $lesson->trophy = 'none';
      }
      break;
    }
  }
  return $state;
}



/**
 * デバッグ用変数出力
 * @param mixed 出力対象
 */
function debug($var){
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
}

/**
 * 指定先へリダイレクト
 * @param string リダイレクト先URL/パス
 */
function redirect($path){
  header("Location: " . $path);
  exit;
}

/**
 * echoショートカット
 * @param mixed 表示内容
 */
function _($value) {
  echo $value;
}

/**
 * $_POSTの内容へアクセスするショートカット
 * @param string キー
 * @param bool 内容出力フラグ
 * @return mixed キーに対応する値
 */
function _p($key, $echo=FALSE){
  $value = isset($_POST[$key]) ? $_POST[$key] : '';
  if ($echo) echo $value;
  return $value;
}

/**
 * $_SESSIONの内容へアクセスするショートカット
 * @param string キー
 * @param bool 内容出力フラグ
 * @return mixed キーに対応する値
 */
function _s($key, $echo=FALSE){
  $value = isset($_SESSION[$key]) ? $_SESSION[$key] : '';
  if ($echo) echo $value;
  return $value;
}

/**
 * $_COOKIEの内容へアクセスするショートカット
 * @param string キー
 * @param bool 内容出力フラグ
 * @return mixed キーに対応する値
 */
function _c($key, $echo=FALSE){
  $value = isset($_COOKIE[$key]) ? $_COOKIE[$key] : '';
  if ($echo) echo $value;
  return $value;
}
