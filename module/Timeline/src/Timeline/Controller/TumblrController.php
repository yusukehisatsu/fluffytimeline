<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Timeline\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Timeline\Model\Insert;

class TumblrController extends AbstractActionController
{
    public function indexAction()
    {
        //パラメータ取得
        $radio = $this->params()->fromQuery('radio');
        $photo = $this->params()->fromQuery('type');
        $url = $this->params()->fromQuery('url');
        $tag = $this->params()->fromQuery('tag');
        $speed = $this->params()->fromQuery('speed');
        $offset = $this->params()->fromQuery('offset');

        // Tumblr用のライブラリの読み込み
        require __DIR__ . '/tumblr-oauth-library.php';

        // 設定
        $consumer_key = 'OQwstKWw15xJyQePbwP4hxNcPdAWk5Hg42hQjjhKZMfjG6R52d';                                                                                            // コンシューマーキー
        $request_method = 'GET';

        if ($radio == 'self') { // 自分のタイムライン

            // セッションスタート
            session_start();

            // リダイレクト先設定
            $self_url = empty($_SERVER["HTTPS"]) ? "http://" : "https://";

            if (empty($_SESSION['access_token'])) { // 初回アクセス時
                $self_url .= $_SERVER["HTTP_HOST"] . '/oauth.php';
            } else {  // 認証済み
                $self_url .= $_SERVER["HTTP_HOST"] . '/timeline/tumblr?radio=dashboard&speed=' . $speed . '&type=' . $photo . '&offset=' . $offset;
            }

            // リダイレクト
            header("Location: {$self_url}");
            exit;

        } elseif ($radio == 'dashboard') { // 自分のタイムライン（リダイレクト後）

            // セッションスタート
            session_start();

            // リクエスト設定
            $request_url = 'https://api.tumblr.com/v2/user/dashboard';

            if (!empty($photo)) {
                $params = array('oauth_token' => $_SESSION['access_token'], 'oauth_token_secret' => $_SESSION['access_token_secret'], 'type' => 'photo', 'offset' => $offset);
            } else {
                $params = array('oauth_token' => $_SESSION['access_token'], 'oauth_token_secret' => $_SESSION['access_token_secret'], 'offset' => $offset);
            }

            // データ取得
            list($json, $header) = tumblr_oauth($request_url, $request_method, $params, 1);

        } elseif ($radio == 'other') { // 特定のブログ

            // URLの場合ドメインだけを取得
            if (substr($url, 0, 4) == 'http') {
                $url = parse_url($url, PHP_URL_HOST);
            }

            // リクエスト設定
            $request_url = 'https://api.tumblr.com/v2/blog/' . $url . '/posts';
            $params = array('api_key' => $consumer_key, 'offset' => $offset);

            // データ取得
            list($json, $header) = tumblr_oauth($request_url, $request_method, $params, 1);

        } elseif ($radio == 'tag') { // タグ検索

            // リクエスト設定
            $request_url = 'https://api.tumblr.com/v2/tagged';
            $params = array('api_key' => $consumer_key, 'tag' => $tag,'offset' => $offset);

            // データ取得
            list($json, $header) = tumblr_oauth($request_url, $request_method, $params, 1);
        }

        if (!empty($json)) {
            $array = json_decode($json, true);
        } else {
            $array = array('status' => 'no');
        }
        $array = array_merge($array, array('type' => $radio));
        $array = array_merge($array, array('offset' => $offset));
        $array = array_merge($array, array('speed' => (!empty($speed) ? $speed * 1000 : '3000')));

        //履歴取得
        $db_params = array(
            'type' => $radio,
            'offset' => $offset,
            'speed' => $speed,
            'url' => $url,
            'tag' => $tag,
            'photo' => $photo,
        );
        $insert = new Insert();
        $result = $insert->insertTumblrHistory($db_params);

        //echo('<pre>');
        //var_dump($array);
        //echo('</pre>');

        return new ViewModel($array);
    }
}
