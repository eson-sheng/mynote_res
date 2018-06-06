<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class ItemsModel extends RelationModel{
    protected $_link=[
        'item_types'=>[
            'mapping_type'=>self::BELONGS_TO,
            'foreign_key'=>'typeid'
        ],
        'subcompanies'=>[
            'mapping_type'=>self::BELONGS_TO,
            'foreign_key'=>'companyid'
        ]
    ];
}