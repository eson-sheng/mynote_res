<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class RecordsModel extends RelationModel{
    protected $_link=[
        'operators'=>[
            'mapping_type'=>self::BELONGS_TO,
            'foreign_key'=>'operatorid'
        ],
        'items'=>[
            'mapping_type'=>self::BELONGS_TO,
            'foreign_key'=>'itemid'
        ]
    ];
}