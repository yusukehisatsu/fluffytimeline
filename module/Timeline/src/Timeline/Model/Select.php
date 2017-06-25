<?php
namespace Command\Model;

use Command\Model\Data\Command;
use Command\Model\Data\CommandList;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Select
{
    /*
     * オートコンプリート
     */
    public function selectCommand($data,$group)
    {
        $adapter = GlobalAdapterFeature::getStaticAdapter();
        $connection = $adapter->getDriver()->getConnection();

        $list = new Command();

        $connection->beginTransaction();
        try {
            $rowset = $list->getRecord($data,$group);
        } catch (\Exception $e) {
            return false;
        }
        return $rowset;
    }

    /*
     * リスト取得
     */
    public function selectList($data)
    {
        $adapter = GlobalAdapterFeature::getStaticAdapter();
        $connection = $adapter->getDriver()->getConnection();

        $list = new CommandList();

        $connection->beginTransaction();
        try {
            $rowset = $list->getRecord($data);
        } catch (\Exception $e) {
            return false;
        }
        return $rowset;
    }
}
