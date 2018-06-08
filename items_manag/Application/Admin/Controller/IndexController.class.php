<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->operators = M('operators');
    }

    public function login()
    {
        if (session('operator')) {
            $this->redirect('Admin/Index/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $operator = $this->operators->where(['name' => I('post.name')])->select()[0];
            if ($operator['pwd'] === md5(I('post.pwd'))) {
                session('operator', $operator);
                $this->redirect('Admin/Index/index');
            }else{
                $this->assign([
                    'err_info'=>'登录失败，请检查登录名和密码'
                ]);
            }
        }
        $this->display();
    }

    public function logout(){
        session('operator',null);
        $this->redirect('Admin/Index/login');
    }

    public function index(){
        if(empty(session('operator'))){#登录检查
            $this->Redirect('Admin/Index/login');
        }
        $this->display();
    }
}