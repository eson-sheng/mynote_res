<?php

namespace Admin\Controller;

use Think\Controller;

class ItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->types = M('item_types');
        $this->companies = M('subcompanies');
        $this->items = D('items');
    }

    public function index()
    {
        $this->assign([
            'items' => $this->items->Relation(true)->where(['deleted' => 0])->select()
        ]);
        $this->display();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (I('get.update_id')) {//修改数据
                if (I('post.name')) {//数据不为空
                    $this->items->where(['id' => I('get.update_id')])->save([
                        'name' => I('post.name'),
                        'typeid' => I('post.typeid'),
                        'companyid' => I('post.companyid')
                    ]);
                }
            } else {//新增数据
                if (I('post.name')) {//数据不为空
                    $this->items->add([
                        'name' => I('post.name'),
                        'typeid' => I('post.typeid'),
                        'companyid' => I('post.companyid')
                    ]);
                }
            }
            $this->redirect('Admin/Item/index');
        }
        if (I('get.update_id')) {#准备修改
            $this->assign([
                'item' => $this->items->Relation(true)->where(['deleted' => 0, 'id' => I('get.update_id')])->select()[0]
            ]);
        } elseif (I('get.delete_id')) {#删除
            $this->items->where(['deleted' => 0, 'id' => I('get.delete_id')])->save([
                'deleted' => 1
            ]);
            $this->redirect('Admin/Item/index');
        } #else 准备新增
        $this->assign([
            'types' => $this->types->where(['deleted' => 0])->select(),
            'companies'=>$this->companies->where(['deleted'=>0])->select()
        ]);
        $this->display();
    }

}