<?php
/* Smarty version 3.1.28, created on 2018-06-06 15:11:35
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Item\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b1789273f3b86_03762482',
  'file_dependency' => 
  array (
    'f7e2008d851312da91ef3a0d42321dd095c780c5' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Item\\index.html',
      1 => 1528269054,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1789273f3b86_03762482 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>物品管理</title>
    <style>
        table {
            width: 900px;
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
<h2>物品管理</h2>
<ul>
    <li>
        <a href="<?php echo U("Admin/Index/index");?>
">返回</a>
    </li>
    <li>
        <a href="<?php echo U("Admin/Item/update");?>
">新增物品</a>
    </li>
</ul>
<table cellspacing="0" cellpadding="0" border="1">
    <caption>物品列表</caption>
    <tr>
        <th>物品名称</th>
        <th>所属公司</th>
        <th>类型</th>
        <th>编辑</th>
        <th>删除</th>
    </tr>
    <?php
$_from = $_smarty_tpl->tpl_vars['items']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$__foreach_item_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_item_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$__foreach_item_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['subcompanies']['name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['item_types']['name'];?>
</td>
        <td>
            <a href="<?php echo U("Admin/Item/update/update_id/".((string)$_smarty_tpl->tpl_vars['item']->value['id']));?>
">编辑</a>
        </td>
        <td>
            <a id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="del">删除</a>
        </td>
    </tr>
    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_local_item;
}
}
if ($__foreach_item_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_item;
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
                var base = "<?php echo U("Admin/Item/update/delete_id/");?>
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
