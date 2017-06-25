<?php
namespace Command\Model\Data;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class TableModel extends TableGateway
{
    // テーブル名
    protected $name;

    public function __construct($adapter = null)
    {
        if ($adapter == null) {
            $adapter = GlobalAdapterFeature::getStaticAdapter();
        }
        parent::__construct($this->name, $adapter);
    }
}
