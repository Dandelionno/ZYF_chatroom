<?php
/* Smarty version 3.1.33, created on 2018-10-08 17:42:05
  from '/home/wwwroot/swoole/client/tpl/client.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bbb266d4a9079_81851398',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f92c1dcb683d660c0026884b32195a9e02ab6226' => 
    array (
      0 => '/home/wwwroot/swoole/client/tpl/client.html',
      1 => 1538990830,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bbb266d4a9079_81851398 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="chatbox">
	<div class="chathead">
		<div class="title"><span>ChatRoom</span></div>
	</div>
	
	<div class="chatbody">
		<!-- 左边 -->
		<div class="chatbody_left">	
			<div class="onlineUserList">
				
			</div>	
		</div>
		
		<!-- 中间 -->
		<div class="chatbody_center">
			<div class="chatbody_center_msgboard">
				
				
			</div>
			
			
			<div class="chatbody_center_inputbox">
				<div class="inputboard">
					<textarea name="msg" class="msg"></textarea>
				</div>
				<div class="sendbtnbox">
					<button type="button" class="btn sendbtn">Send</button>
				</div>
			</div>
		</div>
		
		<!-- 右边 -->
		<div class="chatbody_right">
			<div class="userpic act_gotoUserCenter">
				<img alt="头像" src="<?php echo $_smarty_tpl->tpl_vars['TV']->value['currUserInfo']['image'];?>
">
				<input id="currUserId" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['TV']->value['currUser']['userid'];?>
">
				<input id="currUserName" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['TV']->value['currUser']['username'];?>
">
			</div>
		</div>
	</div>
	<div class="clear"></div>
		
	<div class="chatfoot">
			
	</div>
</div>
	


<!-- 在线用户模板 -->
<div id="tpl_onlineUser" style="display: none;">
	<div class="onlineUser">
		<div class="onlineUserPic">
			<img alt="头像" src="">
		</div>
		<div class="onlineUserInfo">
			<span></span>
		</div>
		<div class="clear"></div>							
	</div>	
</div>
	
	


<?php echo '<script'; ?>
 src="<?php echo V_SERVER_HOST;?>
/static/js/core.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	$(document).ready(function(){
				
		MainController.init();
	})		
<?php echo '</script'; ?>
><?php }
}
