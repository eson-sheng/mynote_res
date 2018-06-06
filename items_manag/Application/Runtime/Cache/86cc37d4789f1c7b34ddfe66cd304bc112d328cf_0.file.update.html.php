<?php
/* Smarty version 3.1.28, created on 2018-06-06 14:28:11
  from "E:\xampp\htdocs\items_manag\Application\Admin\View\Company\update.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_5b177efb29bf88_92364503',
  'file_dependency' => 
  array (
    '86cc37d4789f1c7b34ddfe66cd304bc112d328cf' => 
    array (
      0 => 'E:\\xampp\\htdocs\\items_manag\\Application\\Admin\\View\\Company\\update.html',
      1 => 1528266489,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b177efb29bf88_92364503 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>子公司信息</title>
</head>
<body>
<h2>子公司信息</h2>
<form action="" method="post">
    <dl>
        <dt>名称</dt>
        <dd>
            <input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
"/>
        </dd>
    </dl>
    <input type="button" value="返回" id="back"/>
    <input type="submit"/>
</form>
</body>
<?php echo '<script'; ?>
>
    document.getElementById('back').addEventListener('click',function () {
        location.href="<?php echo U("Admin/Company/index");?>
";
    });
<?php echo '</script'; ?>
>
</html><?php }
}
