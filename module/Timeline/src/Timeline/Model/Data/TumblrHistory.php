<?php
namespace Timeline\Model\Data;

class TumblrHistory extends TableModel
{
    protected $name = 'tumblr_history';

    public function insertHistory($param)
    {
        // Insertのインスタンスを取得
        $insert = $this->getSql()->insert();

        //Insert句指定
        $insert->values($param);

        // 実行
        $result = $this->insertWith($insert);
        return $result;
    }
}
