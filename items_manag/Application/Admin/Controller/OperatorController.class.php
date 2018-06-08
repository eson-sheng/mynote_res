<?php

namespace Admin\Controller;

use Think\Controller;

class OperatorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(empty(session('operator'))){#登录检查
            $this->Redirect('Admin/Index/login');
        }
        $this->companies = M('subcompanies');
        $this->operators = D('operators');
    }

    public function index()
    {
        $operators = $this->operators->Relation(true)->where(['deleted' => 0])->select();
        $this->assign([
            'operators' => $operators
        ]);
        $this->display();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (I('get.update_id')) {//修改数据
                if (I('post.name')) {//数据不为空
                    $this->operators->where(['id' => I('get.update_id')])->save([
                        'name' => I('post.name'),
                        'type' => I('post.type'),
                        'companyid' => I('post.companyid')
                    ]);
                }
            } else {//新增数据
                if (I('post.name') && I('post.pwd')) {//数据不为空
                    $this->operators->add([
                        'name' => I('post.name'),
                        'type' => I('post.type'),
                        'pwd' => md5(I('post.pwd')),
                        'companyid' => I('post.companyid')
                    ]);
                }
            }
            $this->redirect('Admin/Operator/index');
        }
        if (I('get.update_id')) {#准备修改
            $this->assign([
                'operator' => $this->operators->where(['deleted' => 0, 'id' => I('get.update_id')])->select()[0]
            ]);
        } elseif (I('get.delete_id')) {#删除
            $this->operators->where(['deleted' => 0, 'id' => I('get.delete_id')])->save([
                'deleted'=>1
            ]);
            $this->redirect('Admin/Operator/index');
        } #else 准备新增
        $this->assign([
            'companies' => $this->companies->where(['deleted' => 0])->select()
        ]);
        $this->display();
    }
}