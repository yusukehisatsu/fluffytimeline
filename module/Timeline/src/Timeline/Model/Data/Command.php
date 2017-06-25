<?php

namespace Command\Model\Data;

class Command extends TableModel
{
    protected $name = 'timeline';

    public function getRecord($command, $group)
    {
        // Selectのインスタンスを取得
        $select = $this->getSql()->select();

        //Select句指定
        $select->columns(array('command_name'));

        //Where条件指定
        $select->where->like('command_name', $command."%");
        $select->where->in('group_cd', $group);

        //OrderBy指定
        $select->order(array('group_cd','command_name'));

        // 実行
        $rowset = $this->selectWith($select);
        return $rowset;
    }

    public function countUp($command)
    {
        // Selectのインスタンスを取得
        $update = $this->getSql()->update();

        //Update句指定
        $update->set(array(
            'count' => new \Zend\Db\Sql\Predicate\Expression('count+1'),
        ));

        //Where句指定
        $update->where(array(
            'command_name' => $command,
        ));

        // 実行
        $result = $this->updateWith($update);
        return $result;
    }
}
