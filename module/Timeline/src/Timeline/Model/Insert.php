<?php
namespace Timeline\Model;

use Timeline\Model\Data\Contact;
use Timeline\Model\Data\TumblrHistory;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Insert
{
    /*
     * 問い合わせ登録
     */
    public function insertContact($name,$mail,$content)
    {
        $adapter = GlobalAdapterFeature::getStaticAdapter();
        $connection = $adapter->getDriver()->getConnection();

        $list = new Contact();

        $connection->beginTransaction();
        try {
            $result = $list->insertContent($name,$mail,$content);
        } catch (\Exception $e) {
            return false;
        }
        return $result;
    }

    /*
     * Tumblr履歴登録
     */
    public function insertTumblrHistory($param)
    {
        $adapter = GlobalAdapterFeature::getStaticAdapter();
        $connection = $adapter->getDriver()->getConnection();

        $list = new TumblrHistory();

        $connection->beginTransaction();
        try {
            $result = $list->insertHistory($param);
        } catch (\Exception $e) {
            return false;
        }
        return $result;
    }
}
