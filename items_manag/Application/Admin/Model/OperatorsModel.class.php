<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class OperatorsModel extends RelationModel{
    protected $_link=[
        'subcompanies'=>[
            'mapping_type'=>self::BELONGS_TO,
            'foreign_key'=>'companyid'
        ]
    ];
}