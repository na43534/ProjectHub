<?php
  //================================
  // ログ
  //================================
  //ログを取るか
  ini_set('log_errors','on');
  //ログの出力ファイルを指定
  ini_set('error_log','../includes/log/php.log');

  //================================
  // デバッグ
  //================================
  //デバッグフラグ
  $debug_flg = true;
  //デバッグログ関数
  function debug($str){
    global $debug_flg;
    if(!empty($debug_flg)){
      error_log('デバッグ：'.$str);
    }
  }

  function debugLogStart(){
    debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
    debug('セッションID：'.session_id());
    debug('セッション変数の中身：'.print_r($_SESSION,true));
    debug('現在日時タイムスタンプ：'.time());
    if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
      debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
    }
  }
?>
