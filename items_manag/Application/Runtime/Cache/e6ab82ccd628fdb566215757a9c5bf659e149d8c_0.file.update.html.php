<?php
/* Smarty version 3.1.28, created on 2018-06-06 15:57:34
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Item\update.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b1793ee789b03_24958689',
  'file_dependency' => 
  array (
    'e6ab82ccd628fdb566215757a9c5bf659e149d8c' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Item\\update.html',
      1 => 1528271853,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1793ee789b03_24958689 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>物品信息</title>
</head>
<body>
<h2>物品信息</h2>
<form action="" method="post">
    <dl>
        <dt>物品名称</dt>
        <dd>
            <input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" required="required"/>
        </dd>
        <dt>物品类型</dt>
        <dd>
            <select name="typeid">
                <?php
$_from = $_smarty_tpl->tpl_vars['types']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_type_0_saved_item = isset($_smarty_tpl->tpl_vars['type']) ? $_smarty_tpl->tpl_vars['type'] : false;
$_smarty_tpl->tpl_vars['type'] = new Smarty_Variable();
$__foreach_type_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_type_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$__foreach_type_0_saved_local_item = $_smarty_tpl->tpl_vars['type'];
?>
                <?php if ($_smarty_tpl->tpl_vars['item']->value['item_types']['id'] == $_smarty_tpl->tpl_vars['type']->value['id']) {?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['type']->value['id'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['type']->value['name'];?>
</option>
                <?php } else { ?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['type']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['type']->value['name'];?>
</option>
                <?php }?>
                <?php
$_smarty_tpl->tpl_vars['type'] = $__foreach_type_0_saved_local_item;
}
}
if ($__foreach_type_0_saved_item) {
$_smarty_tpl->tpl_vars['type'] = $__foreach_type_0_saved_item;
}
?>
            </select>
        </dd>
        <dt>所属子公司</dt>
        <dd>
            <select name="companyid">
                <?php
$_from = $_smarty_tpl->tpl_vars['companies']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_company_1_saved_item = isset($_smarty_tpl->tpl_vars['company']) ? $_smarty_tpl->tpl_vars['company'] : false;
$_smarty_tpl->tpl_vars['company'] = new Smarty_Variable();
$__foreach_company_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_company_1_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['company']->value) {
$__foreach_company_1_saved_local_item = $_smarty_tpl->tpl_vars['company'];
?>
                <?php if ($_smarty_tpl->tpl_vars['item']->value['subcompanies']['id'] == $_smarty_tpl->tpl_vars['company']->value['id']) {?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['company']->value['id'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</option>
                <?php } else { ?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['company']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</option>
                <?php }?>
                <?php
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_1_saved_local_item;
}
}
if ($__foreach_company_1_saved_item) {
$_smarty_tpl->tpl_vars['company'] = $__foreach_company_1_saved_item;
}
?>
            </select>
        </dd>
    </dl>
    <input type="button" value="返回" id="back"/>
    <input type="submit"/>
</form>
</body>
<?php echo '<script'; ?>
>
    document.getElementById('back').addEventListener('click',function () {
        location.href="<?php echo U("Admin/Item/index");?>
";
    });
<?php echo '</script'; ?>
>
</html><?php }
}
