<?php

// Tumblr用のライブラリの読み込み
require './tumblr-oauth-library.php' ;

// セッションスタート
session_start() ;

// HTML用
$html = '' ;

// Tumblrでの認証が終了してリダイレクト時、アクセストークンを取得
if( isset($_GET['oauth_token']) && !empty($_GET['oauth_token']) && is_string($_GET['oauth_token']) && isset($_GET['oauth_verifier']) && !empty($_GET['oauth_verifier']) && is_string($_GET['oauth_verifier']) && isset($_SESSION['oauth_token_secret']) && !empty($_SESSION['oauth_token_secret']) && is_string($_SESSION['oauth_token_secret']) )
{
    // アクセストークンをリクエストする
    $data = tumblr_oauth( 'https://www.tumblr.com/oauth/access_token' , 'POST' , array( 'oauth_token' => $_GET['oauth_token'] , 'oauth_token_secret' => $_SESSION['oauth_token_secret'] , 'oauth_verifier' => $_GET['oauth_verifier']) ) ;

    // 配列に変換
    $query = get_query( $data ) ;

    // セッション終了
    $_SESSION = array() ;
    session_destroy() ;

    // エラー判定
    if( !$query )
    {
        $html .= '<p>アクセストークンの取得に失敗しました…。もう一度、認証をするには、<a href="' . explode( '?' , $_SERVER['REQUEST_URI'] )[0] . '">こちら</a>をクリックして下さい。</p>' ;
    }
    else
    {
        // 情報の整理
        $oauth_token = rawurldecode( $query["oauth_token"] ) ;
        $oauth_token_secret = rawurldecode( $query['oauth_token_secret'] ) ;

        // 出力する
        $html .=  '<h2>実行結果</h2>' ;
        $html .=  '<dl>' ;
        $html .=  	'<dt>アクセストークン</dt>' ;
        $html .=  		'<dd>' . $oauth_token . '</dd>' ;
        $html .=  	'<dt>アクセストークンシークレット</dt>' ;
        $html .=  		'<dd>' . $oauth_token_secret . '</dd>' ;
        $html .=  '</dl>' ;
    }

    // 取得したデータ
    $html .= '<h2>取得したデータ</h2>' ;
    $html .= '<p>下記のデータを取得できました。</p>' ;
    $html .= 	'<h3>JSON</h3>' ;
    $html .= 	'<p><textarea rows="8">' . $data . '</textarea></p>' ;

    // アプリケーション連携の解除
    $html .= '<h2>アプリケーション連携の解除</h2>' ;
    $html .= '<p>このアプリケーションとの連携は、下記設定ページで解除することができます。</p>' ;
    $html .= '<p><a href="https://www.tumblr.com/settings/apps" target="_blank">https://www.tumblr.com/settings/apps</a></p>' ;
}

// 初回アクセス時、リクエストトークンを取得して、Tumblrの認証画面にリダイレクトする
else
{
    // リクエストトークンを取得する
    $data = tumblr_oauth( 'https://www.tumblr.com/oauth/request_token' , 'POST' ) ;

    // 取得した文字列を変換
    if( !$query = get_query( $data ) )
    {
        $html .= '<p>リクエストトークンの取得に失敗しました…。もしかしたら「コンシューマーキー」「シークレットキー」の設定が違っているかもしれません…。</p>' ;
        
    }
    else
    {
        // セッションに保存
        session_regenerate_id( true ) ;
        $_SESSION['oauth_token_secret'] = rawurldecode( $query['oauth_token_secret'] ) ;

        // 認証画面へリダイレクト
        header( 'Location: https://www.tumblr.com/oauth/authorize?oauth_token=' . $query['oauth_token'] ) ;
    }
}

?>

<?php
// ブラウザに[$html]を出力 (HTMLのヘッダーとフッターを付けましょう)
echo $html ;
?>