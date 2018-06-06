<?php
/* Smarty version 3.1.28, created on 2018-06-06 14:19:29
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Operator\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b177cf1704e05_40414032',
  'file_dependency' => 
  array (
    'fa01c89097a29a1a88cb0bc73a997d5b1d847a3c' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Operator\\index.html',
      1 => 1528265965,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b177cf1704e05_40414032 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>操作员管理</title>
    <style>
        table {
            width: 700px;
            text-align: center;
        }

        th:nth-last-child(1), th:nth-last-child(2) {
            width: 60px;
        }
        a{
            text-decoration: underline;
            color: #0000ee;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h3>操作员管理</h3>
<ul>
    <li>
        <a href="<?php echo U("Admin/Index/index");?>
">返回</a>
    </li>
    <li>
        <a href="<?php echo U("Admin/Operator/update");?>
">新增操作员</a>
    </li>
</ul>
<table cellpadding="0" cellspacing="0" border="1">
    <caption>操作员列表</caption>
    <tr>
        <th>登录名</th>
        <th>类型</th>
        <th>所属子公司</th>
        <th>编辑</th>
        <th>删除</th>
    </tr>
    <?php
$_from = $_smarty_tpl->tpl_vars['operators']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_operator_0_saved_item = isset($_smarty_tpl->tpl_vars['operator']) ? $_smarty_tpl->tpl_vars['operator'] : false;
$_smarty_tpl->tpl_vars['operator'] = new Smarty_Variable();
$__foreach_operator_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_operator_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['operator']->value) {
$__foreach_operator_0_saved_local_item = $_smarty_tpl->tpl_vars['operator'];
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['operator']->value['name'];?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['operator']->value['type'] == 'admin') {?>管理员<?php } else { ?>普通人员<?php }?></td>
        <td><?php echo $_smarty_tpl->tpl_vars['operator']->value['subcompanies']['name'];?>
</td>
        <td>
            <a href="<?php echo U("Admin/Operator/update/update_id/".((string)$_smarty_tpl->tpl_vars['operator']->value['id']));?>
">编辑</a>
        </td>
        <td>
            <a class="del" id="<?php echo $_smarty_tpl->tpl_vars['operator']->value['id'];?>
">删除</a>
        </td>
    </tr>
    <?php
$_smarty_tpl->tpl_vars['operator'] = $__foreach_operator_0_saved_local_item;
}
}
if ($__foreach_operator_0_saved_item) {
$_smarty_tpl->tpl_vars['operator'] = $__foreach_operator_0_saved_item;
}
?>
</table>
</body>
<?php echo '<script'; ?>
>
    var dels = document.getElementsByClassName('del');
    for (var i = 0; i < dels.length; i++) {
        var each = dels[i];
        each.addEventListener('click', function () {
            if (confirm('确认删除？')) {
                var id = this.getAttribute('id');
                var base = "<?php echo U("Admin/Operator/update/delete_id/");?>
";
                base = base.substr(0, base.lastIndexOf('.')) + '/';
                var href = base + id + '.html';
                location.href = href;
            }

        });
    }
<?php echo '</script'; ?>
>
</html><?php }
}
