<?php
namespace Command\Model;

use Command\Model\Data\Command;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Update
{
    /*
     * 検索時カウントアップ
     */
    public function countUpCommand($data)
    {
        $adapter = GlobalAdapterFeature::getStaticAdapter();
        $connection = $adapter->getDriver()->getConnection();

        $list = new Command();

        $connection->beginTransaction();
        try {
            $result = $list->countUp($data);
        } catch (\Exception $e) {
            return false;
        }
        return $result;
    }
}
