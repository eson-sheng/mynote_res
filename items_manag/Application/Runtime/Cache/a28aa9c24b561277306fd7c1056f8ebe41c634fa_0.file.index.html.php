<?php
/* Smarty version 3.1.28, created on 2018-06-06 14:12:50
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Index\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b177b622d6908_07165619',
  'file_dependency' => 
  array (
    'a28aa9c24b561277306fd7c1056f8ebe41c634fa' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Index\\index.html',
      1 => 1528265566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b177b622d6908_07165619 ($_smarty_tpl) {
$_smarty_tpl->tpl_vars['operator'] = new Smarty_Variable(session('operator'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'operator', 0);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>操作员选项</title>
</head>
<body>
<h2>操作员选项</h2>
<p><?php if ($_smarty_tpl->tpl_vars['operator']->value['type'] == 'admin') {?>管理员<?php } else { ?>普通人员<?php }?>：<?php echo $_smarty_tpl->tpl_vars['operator']->value['name'];?>
</p>
<ul>
    <li>
        <a href="<?php echo U("Admin/Item/index");?>
">物品查看</a>
    </li>
    <?php if ($_smarty_tpl->tpl_vars['operator']->value['type'] == 'admin') {?>
    <li>
        <a href="<?php echo U("Admin/Company/index");?>
">子公司管理</a>
    </li>
    <li>
        <a href="<?php echo U("Admin/Operator/index");?>
">操作员管理</a>
    </li>
    <?php }?>
    <li>
        <a href="<?php echo U("Admin/Index/logout");?>
">注销</a>
    </li>
</ul>
</body>
</html><?php }
}
