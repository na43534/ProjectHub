<?php

  //================================
  // バリデーション関数
  //================================

  $err_msg = array();

  //バリデーション関数（未入力チェック）
  function validRequired($str, $key){
    if($str === ''){ //金額フォームなどを考えると数値の０はOKにし、空文字はダメにする
      global $err_msg;
      $err_msg[$key] = MSG01;
    }
  }
  //バリデーション関数（Email形式チェック）
  function validEmail($str, $key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG02;
    }
  }
  //バリデーション関数（Email重複チェック）
  function validEmailDup($email){
    global $err_msg;
    //例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
      $data = array(':email' => $email);
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);
      // クエリ結果の値を取得
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      //array_shift関数は配列の先頭を取り出す関数です。クエリ結果は配列形式で入っているので、array_shiftで1つ目だけ取り出して判定します
      if(!empty(array_shift($result))){
        $err_msg['email'] = MSG08;
      }
    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
  //バリデーション関数（同値チェック）
  function validMatch($str1, $str2, $key){
    if($str1 !== $str2){
      global $err_msg;
      $err_msg[$key] = MSG03;
    }
  }
  //バリデーション関数（最小文字数チェック）
  function validMinLen($str, $key, $min = 6){
    if(mb_strlen($str) < $min){
      global $err_msg;
      $err_msg[$key] = MSG05;
    }
  }
  //バリデーション関数（最大文字数チェック）
  function validMaxLen($str, $key, $max = 256){
    if(mb_strlen($str) > $max){
      global $err_msg;
      $err_msg[$key] = MSG06;
    }
  }
  //バリデーション関数（半角チェック）
  function validHalf($str, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG04;
    }
  }
  //電話番号形式チェック
  function validTel($str, $key){
    if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG10;
    }
  }
  //郵便番号形式チェック
  function validZip($str, $key){
    if(!preg_match("/^\d{7}$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG11;
    }
  }
  //半角数字チェック
  function validNumber($str, $key){
    if(!preg_match("/^[0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG17;
    }
  }
  //固定長チェック
  function validLength($str, $key, $len = 8){
    if( mb_strlen($str) !== $len ){
      global $err_msg;
      $err_msg[$key] = $len . MSG14;
    }
  }
  //パスワードチェック
  function validPass($str, $key){
    //半角英数字チェック
    validHalf($str, $key);
    //最大文字数チェック
    validMaxLen($str, $key);
    //最小文字数チェック
    validMinLen($str, $key);
  }
  //selectboxチェック
  function validSelect($str, $key){
    if(!preg_match("/^[0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG15;
    }
  }
  //エラーメッセージ表示
  function getErrMsg($key){
    global $err_msg;
    if(!empty($err_msg[$key])){
      return $err_msg[$key];
    }
  }

?>
