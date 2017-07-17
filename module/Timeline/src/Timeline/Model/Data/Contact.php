<?php
namespace Timeline\Model\Data;

class Contact extends TableModel
{
    protected $name = 'contact';

    public function insertContent($registname,$mail,$content)
    {
        // Insertのインスタンスを取得
        $insert = $this->getSql()->insert();

        //Insert句指定
        $insert->values(array(
            'name' => $registname,
            'mail' => $mail,
            'content' => $content,
        ));

        // 実行
        $result = $this->insertWith($insert);
        return $result;
    }
}
