<?php
/* Smarty version 3.1.28, created on 2018-06-05 18:14:36
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Index\login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b16628ca54889_05503896',
  'file_dependency' => 
  array (
    '211c1a8415046c9950d2eacaffa8dc1afe88f295' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Index\\login.html',
      1 => 1528193272,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b16628ca54889_05503896 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>操作员登录</title>
</head>
<body>
<h2>操作员登录</h2>
<form action="" method="post">
    <dl>
        <dt>登录名</dt>
        <dd>
            <input name="name" type="text"/>
        </dd>
        <dt>登录密码</dt>
        <dd>
            <input name="pwd" type="password"/>
        </dd>
    </dl>
    <input type="submit"/>
    <?php if (isset($_smarty_tpl->tpl_vars['err_info']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['err_info']->value;?>
 <?php }?>
</form>
</body>
</html><?php }
}
