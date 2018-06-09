<?php

namespace Admin\Controller;

use Think\Controller;

class RecordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty(session('operator'))) {#登录检查
            $this->Redirect('Admin/Index/login');
        }
        $this->records = D('records');
        $this->items = M('items');
    }

    public function index()
    {
        $this->assign([
            'item' => $this->items->where(['id' => I('get.itemid')])->select()[0],
            'records' => $this->records->Relation(true)->where(['deleted' => 0, 'itemid' => I('get.itemid')])->select()
        ]);
        $this->display();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (I('get.update_id')) {//修改数据
                if (I('post.person')) {//数据不为空
                    $this->records->where(['id' => I('get.update_id')])->save([
                        'itemid' => I('get.itemid'),
                        'person' => I('post.person'),
                        'status' => I('post.status'),
                        'comment' => I('post.comment')
                    ]);
                }
            } else {//新增数据
                if (I('post.person')) {//数据不为空
                    $this->records->add([
                        'itemid' => I('get.itemid'),
                        'operatorid' => session('operator')['id'],
                        'time' => date('Y-m-d H:i:s', time()),
                        'person' => I('post.person'),
                        'status' => I('post.status'),
                        'comment' => I('post.comment')
                    ]);
                }
            }
            $this->redirect('Admin/Record/index', ['itemid' => I('get.itemid')]);
        }
        if (I('get.update_id')) {#准备修改
            $this->assign([
                'record' => $this->records->where(['deleted' => 0, 'id' => I('get.update_id')])->select()[0]
            ]);
        } elseif (I('get.delete_id')) {#删除
            $this->records->where(['deleted' => 0, 'id' => I('get.delete_id')])->save([
                'deleted' => 1
            ]);
            $this->redirect('Admin/Record/index', ['itemid' => I('get.itemid')]);
        } #else 准备新增
        $this->display();
    }

}