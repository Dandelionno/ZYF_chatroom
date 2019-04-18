<?php
/* Smarty version 3.1.33, created on 2018-10-08 15:11:54
  from '/home/wwwroot/swoole/client/tpl/layout.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bbb033a7b3ef7_18694720',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '80e3210e9a3a73e9288c38bf9554a470865a1a4f' => 
    array (
      0 => '/home/wwwroot/swoole/client/tpl/layout.html',
      1 => 1538982258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bbb033a7b3ef7_18694720 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $_smarty_tpl->tpl_vars['GV']->value['page']['title'];?>
</title>
		
		
		<link rel="stylesheet" type="text/css" href="<?php echo V_SERVER_HOST;?>
/static/css/style.css">
		<link rel="stylesheet" href="<?php echo '<?=';?>V_SERVER_HOST<?php echo '?>';?>/static/addons/font-awesome/css/font-awesome.min.css">
		<?php echo '<script'; ?>
 type="text/javascript" src="http://code.jquery.com/jquery-latest.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo '<?=';?>V_SERVER_HOST<?php echo '?>';?>/static/js/jquery.cookie.js"><?php echo '</script'; ?>
>
	</head>
	<body>
		<div class="mainContainer">
			<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['GV']->value['page']['module']).".html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
		</div>
	</body>
</html><?php }
}
