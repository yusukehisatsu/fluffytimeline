<?php

// Tumblr用のライブラリの読み込み
require '../module/Timeline/src/Timeline/Controller/tumblr-oauth-library.php';

// セッションスタート
session_start() ;

// Tumblrでの認証が終了してリダイレクト時、アクセストークンを取得
if( isset($_GET['oauth_token']) && !empty($_GET['oauth_token']) && is_string($_GET['oauth_token']) && isset($_GET['oauth_verifier']) && !empty($_GET['oauth_verifier']) && is_string($_GET['oauth_verifier']) && isset($_SESSION['oauth_token_secret']) && !empty($_SESSION['oauth_token_secret']) && is_string($_SESSION['oauth_token_secret']) )
{
    // アクセストークンをリクエストする
    $data = tumblr_oauth( 'https://www.tumblr.com/oauth/access_token' , 'POST' , array( 'oauth_token' => $_GET['oauth_token'] , 'oauth_token_secret' => $_SESSION['oauth_token_secret'] , 'oauth_verifier' => $_GET['oauth_verifier']) ) ;

    // 配列に変換
    $query = get_query( $data ) ;

    // セッションに保存
    $_SESSION['access_token'] = rawurldecode( $query["oauth_token"] ) ;
    $_SESSION['access_token_secret'] = rawurldecode( $query["oauth_token_secret"] ) ;

    // Controllerにリダイレクト
    $self_url  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
    $self_url .= $_SERVER["HTTP_HOST"].'/timeline/tumblr?radio=dashboard';
    header( "Location: {$self_url}" ) ;
    exit;
}

// 初回アクセス時、リクエストトークンを取得して、Tumblrの認証画面にリダイレクトする
else
{
    // リクエストトークンを取得する
    $data = tumblr_oauth( 'https://www.tumblr.com/oauth/request_token' , 'POST' ) ;

    // 取得した文字列を変換
    if( !$query = get_query( $data ) )
    {
        error_log('リクエストトークンの取得に失敗しました…。もしかしたら「コンシューマーキー」「シークレットキー」の設定が違っているかもしれません…') ;
        
    }
    else
    {
        // セッションに保存
        $_SESSION['oauth_token'] = rawurldecode( $query['oauth_token'] ) ;
        $_SESSION['oauth_token_secret'] = rawurldecode( $query['oauth_token_secret'] ) ;

        // 認証画面へリダイレクト
        header( 'Location: https://www.tumblr.com/oauth/authorize?oauth_token=' . $query['oauth_token'] ) ;
    }
}

?>
