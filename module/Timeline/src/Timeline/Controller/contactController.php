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

class contactController extends AbstractActionController
{
    public function indexAction()
    {
        //パラメータ取得
        $name = trim($this->params()->fromPost('name'));
        $mail = trim($this->params()->fromPost('mail'));
        $content = trim($this->params()->fromPost('content'));

        //エラーメッセージ
        $message = array();

        if(empty($name) && empty($content)){
            //初期表示

        }else {
            if (empty($name)) {
                $message = array_merge($message, array('name'=>'お名前を入力してください'));
            }
            if(empty($content)){
                $message = array_merge($message, array('content'=>'お問い合わせ内容を入力してください'));
            }
            if(empty($message)){

                // DB登録
                $insert = new Insert();
                $result = $insert->insertContact($name,$mail,$content);

                if($result>0){
                    $message = array_merge($message, array('success'=>'お問い合わせを受け付けました'));
                }else{
                    $message = array_merge($message, array('success'=>'お問い合わせの登録に失敗しました'));
                }
            }
        }

        //echo('<pre>');
        //var_dump($message);
        //echo('</pre>');

        return new ViewModel($message);
    }
}
