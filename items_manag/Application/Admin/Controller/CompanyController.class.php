<?php

namespace Admin\Controller;

use Think\Controller;

class CompanyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(empty(session('operator'))){#登录检查
            $this->Redirect('Admin/Index/login');
        }
        $this->companies = M('subcompanies');
    }

    public function index(){
        $this->assign([
            'companies'=>$this->companies->where(['deleted'=>0])->select()
        ]);
        $this->display();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (I('get.update_id')) {//修改数据
                if (I('post.name')) {//数据不为空
                    $this->companies->where(['id' => I('get.update_id')])->save([
                        'name' => I('post.name')
                    ]);
                }
            } else {//新增数据
                if (I('post.name')) {//数据不为空
                    $this->companies->add([
                        'name' => I('post.name')
                    ]);
                }
            }
            $this->redirect('Admin/Company/index');
        }
        if (I('get.update_id')) {#准备修改
            $this->assign([
                'company' => $this->companies->where(['deleted' => 0, 'id' => I('get.update_id')])->select()[0]
            ]);
        } elseif (I('get.delete_id')) {#删除
            $this->companies->where(['deleted' => 0, 'id' => I('get.delete_id')])->save([
                'deleted'=>1
            ]);
            $this->redirect('Admin/Company/index');
        } #else 准备新增
        $this->display();
    }

}