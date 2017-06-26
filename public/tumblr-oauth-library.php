<?php

// OAuthリクエスト用の関数
function tumblr_oauth( $request_url='' , $method='GET' , $params_b=array() , $response_header=0 )
{
    // 設定項目
    $consumer_key = 'OQwstKWw15xJyQePbwP4hxNcPdAWk5Hg42hQjjhKZMfjG6R52d' ;																							// コンシューマーキー
    $secret_key = '5HaVd8JrCH1Mc8WNvze4wo9WOTHx5zBptXelOHSkbvYoKzgVee' ;	 																			// コンシューマーシークレット
    $callback_url = ( !isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS']) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;		// このプログラムを設置するURL

    // リクエスト用のパラメータ
    $params_a = array
    (
        'oauth_callback' => $callback_url ,
        'oauth_consumer_key' => $consumer_key ,
        'oauth_nonce' => md5( microtime() ) ,
        'oauth_signature_method' => 'HMAC-SHA1' ,
        'oauth_timestamp' => time() ,
        'oauth_version' => '1.0' ,
    );

    // アクセストークンなど取得時と、データ取得時での差異をちょこちょこと調整する
    if( isset( $params_b['oauth_token'] ) )
    {
        $params_a['oauth_token'] = $params_b['oauth_token'] ;
        unset( $params_b['oauth_token'] , $params_a['oauth_callback'] ) ;
    }

    if( isset( $params_b['oauth_token_secret'] ) )
    {
        $oauth_token_secret = $params_b['oauth_token_secret'] ;
        unset( $params_b['oauth_token_secret'] ) ;
    }
    else
    {
        $oauth_token_secret = '' ;
    }

    if( isset($params_b['oauth_verifier']) )
    {
        $params_a['oauth_verifier'] = $params_b['oauth_verifier'] ;
        unset( $params_b['oauth_verifier'] ) ;
    }

    // リクエストボディの完成
    $request_body = http_build_query( $params_b ) ;

    // キーを作成する
    $signature_key = rawurlencode( $secret_key ) . '&' . rawurlencode( $oauth_token_secret ) ;

    // [$params_a]と[$params_b]を署名作成のため合体
    $params_c = array_merge( $params_a , $params_b ) ;

    // [$params_c]をアルファベット順に並び替える
    ksort( $params_c ) ;

    // 配列[$params_c]を[キー=値&キー=値...]の文字列に変換
    $signature_params = str_replace( array( '+' , '%7E' ) , array( '%20' , '~' ) , http_build_query( $params_c , '' , '&' ) ) ;

    // リクエストメソッド、リクエストURL、パラメータを、URLエンコードしてから[&]で繋ぎ、データを作成する
    $signature_data = rawurlencode( $method ) . '&' . rawurlencode( $request_url ) . '&' . rawurlencode( $signature_params ) ;

    // キー[$signature_key]とデータ[$signature_data]をHMAC-SHA1方式のハッシュ値に変換し、base64エンコードして、署名を作成する
    $signature = base64_encode( hash_hmac( 'sha1' , $signature_data , $signature_key , true ) ) ;

    // [$params_a]に署名を追加する
    $params_a['oauth_signature'] = $signature ;

    // ヘッダーを作成する
    $header_params = http_build_query( $params_a , '' , ',' ) ;

    // GETの場合、[$params_b]をリクエストURLの末尾に付ける
    if( $params_b && $method=='GET' )
    {
        $request_url .= '?' . http_build_query( $params_b , '' , '&' ) ;
    }

    // コンテキストを用意
    $context = array(
        'http' => array(
            'method' => $method ,
            'header' => array(
                'Authorization: OAuth ' . $header_params ,
            ),
        )
    ) ;

    // POSTメソッドの場合、コンテキストにリクエストボディを加える
    if( $request_body && $method != 'GET' )
    {
        $context['http']['content'] = $request_body ;
    }

    // CURLでリクエスト
    $curl = curl_init() ;

    // オプションのセット
    curl_setopt( $curl , CURLOPT_URL , $request_url ) ;
    curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
    curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $method ) ;
    curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;								// 証明書の検証を行わない
    curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;								// curl_execの結果を文字列で返す
    curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] ) ;			// ヘッダー
    if( isset($context['http']['content']) && !empty($context['http']['content']) )		// ボディ (POST時)
    {
        curl_setopt( $curl , CURLOPT_POSTFIELDS , $context['http']['content'] ) ;
    }
    curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;										// タイムアウトの秒数

    // 実行
    $res1 = curl_exec( $curl ) ;
    $res2 = curl_getinfo( $curl ) ;

    // 終了
    curl_close( $curl ) ;

    // 取得したデータ
    $response = substr( $res1, $res2['header_size'] ) ;									// 取得したデータ(JSONなど)
    $header = substr( $res1, 0, $res2['header_size'] ) ;								// レスポンスヘッダー (検証に利用したい場合にどうぞ)

    // 取得したデータを返却
    return ( !$response_header ) ? $response : array( $response , $header ) ;

}

// GETクエリ形式の文字列を配列に変換する関数
function get_query( $data = '' )
{
    // 文字列を[&]で区切って配列に変換する
    $ary = explode( '&' , $data ) ;

    // [&]が含まれていない場合は終了
    if( 2 > count( $ary ) )
    {
        return false ;
    }

    // 文字列を配列に整形する
    foreach( $ary as $items )
    {
        $item = explode( '=' , $items ) ;
        $query[ $item[0] ] = $item[1] ;
    }

    // 返却
    return $query ;
}