<?php

namespace Command\Model\Data;

class CommandList extends TableModel
{
    protected $name = 'command_list';

    public function getRecord($command)
    {
        // Selectのインスタンスを取得
        $select = $this->getSql()->select();

        // WHERE条件指定
        $select->where(array(
            'command_name' => $command,
            'del_flg' => '0',
        ));

        //OrderBy指定
        $select->order(array('order'));

        // 実行
        $rowset = $this->selectWith($select);
        return $rowset;
    }
}
