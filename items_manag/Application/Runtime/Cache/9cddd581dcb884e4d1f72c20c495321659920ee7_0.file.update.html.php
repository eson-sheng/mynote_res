<?php
/* Smarty version 3.1.28, created on 2018-06-06 10:27:42
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Operator\update.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b17469e156305_01226416',
  'file_dependency' => 
  array (
    '9cddd581dcb884e4d1f72c20c495321659920ee7' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Operator\\update.html',
      1 => 1528252058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b17469e156305_01226416 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>操作员信息</title>
</head>
<body>
<h2>操作员信息</h2>
<form action="" method="post">
    <dl>
        <dt>登录名</dt>
        <dd>
            <input name="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['operator']->value['name'];?>
" required="required"/>
        </dd>
        <dt>操作员类型</dt>
        <dd>
            <select name="type">
                <option value="normal" <?php if ($_smarty_tpl->tpl_vars['operator']->value['type'] == 'normal') {?>selected='selected'<?php }?>>普通人员</option>
                <option value="admin" <?php if ($_smarty_tpl->tpl_vars['operator']->value['type'] == 'admin') {?>selected='selected'<?php }?>>管理员</option>
            </select>
        </dd>
        <?php if (!$_smarty_tpl->tpl_vars['operator']->value) {?>
        <dt>密码</dt>
        <dd>
            <input name="pwd" type="password" placeholder="设置密码" required="required"/>
        </dd>
        <?php }?>
        <dt>所属子公司</dt>
        <dd>
            <select name="companyid">
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
                    <?php if ($_smarty_tpl->tpl_vars['operator']->value['companyid'] == $_smarty_tpl->tpl_vars['company']->value['id']) {?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['company']->value['id'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</option>
                    <?php } else { ?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['company']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</option>
                    <?php }?>
                <?php
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_0_saved_local_item;
}
}
if ($__foreach_company_0_saved_item) {
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_0_saved_item;
}
?>
            </select>
        </dd>
    </dl>
    <input id="back" type="button" value="返回"/>
    <input type="submit"/>
</form>
</body>
<?php echo '<script'; ?>
>
    document.getElementById('back').addEventListener('click',function () {
        location.href="<?php echo U("Admin/Operator/index");?>
";
    });
<?php echo '</script'; ?>
>
</html><?php }
}
