<?php
/* Smarty version 3.1.28, created on 2018-06-06 14:40:52
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Company\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b1781f4b5e287_09846001',
  'file_dependency' => 
  array (
    '92e72be2e02c820c9ddd2eebf62a63d950faf7c0' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Company\\index.html',
      1 => 1528267251,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1781f4b5e287_09846001 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>子公司管理</title>
    <style>
    table {
        width: 600px;
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
<h2>子公司管理</h2>
<ul>
    <li>
        <a href="<?php echo U("Admin/Index/index");?>
">返回</a>
    </li>
    <li>
        <a href="<?php echo U("Admin/Company/update");?>
">新增子公司</a>
    </li>
</ul>
<table cellspacing="0" cellpadding="0" border="1">
    <caption>子公司列表</caption>
    <tr>
        <th>名称</th>
        <th>编辑</th>
        <th>删除</th>
    </tr>
    <?php
$_from = $_smarty_tpl->tpl_vars['companies']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_company_0_saved_item = isset($_smarty_tpl->tpl_vars['company']) ? $_smarty_tpl->tpl_vars['company'] : false;
$_smarty_tpl->tpl_vars['company'] = new Smarty_Variable();
$__foreach_company_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_company_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['company']->value) {
$__foreach_company_0_saved_local_item = $_smarty_tpl->tpl_vars['company'];
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</td>
        <td>
            <a href="<?php echo U("Admin/Company/update/update_id/".((string)$_smarty_tpl->tpl_vars['company']->value['id']));?>
">编辑</a>
        </td>
        <td>
            <a class="del" id="<?php echo $_smarty_tpl->tpl_vars['company']->value['id'];?>
">删除</a>
        </td>
    </tr>
    <?php
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_0_saved_local_item;
}
}
if ($__foreach_company_0_saved_item) {
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_0_saved_item;
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
                var base = "<?php echo U("Admin/Company/update/delete_id/");?>
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
