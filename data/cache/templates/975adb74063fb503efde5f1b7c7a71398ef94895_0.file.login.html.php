<?php
/* Smarty version 3.1.33, created on 2018-10-08 15:19:23
  from '/home/wwwroot/swoole/client/tpl/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bbb04fbce06b1_93121269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '975adb74063fb503efde5f1b7c7a71398ef94895' => 
    array (
      0 => '/home/wwwroot/swoole/client/tpl/login.html',
      1 => 1538983162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bbb04fbce06b1_93121269 (Smarty_Internal_Template $_smarty_tpl) {
?>
		<div class="mainContainer">
			<div class="loginBox">
				<div class="logo">ChatRoom</div>
				<div class="inputItem">
					<b class="adon fa fa-user-circle-o"></b>
					<input type="text" name="username" class="username" value="<?php if (isset($_smarty_tpl->tpl_vars['TV']->value['userInfo_rem']['username'])) {?> <?php echo $_smarty_tpl->tpl_vars['TV']->value['userInfo_rem']['username'];?>
 <?php }?>">
				</div>
				<div class="inputItem">
					<b class="adon fa fa-lock"></b>
					<input type="text" name="pwd" class="pwd" value="<?php if ($_smarty_tpl->tpl_vars['TV']->value['isRemember'] && isset($_smarty_tpl->tpl_vars['TV']->value['userInfo_rem']['pwd'])) {?> <?php echo $_smarty_tpl->tpl_vars['TV']->value['userInfo_rem']['pwd'];?>
 <?php }?>">
				</div>
				<div class="rempwd_item">
					<input type="checkbox" name="rempwd" class="rempwd" <?php if ($_smarty_tpl->tpl_vars['TV']->value['isRemember']) {?>checked<?php }?>>
					<span>记住密码</span>
				</div>
				<div class="inputItem">
					<button type="button" class="btn login_btn">登录</button>
				</div>
			</div>
		</div>
		
		<?php echo '<script'; ?>
 type="text/javascript">
			$(document).ready(function(){
				$(".login_btn").on('click', function(){
					var username = $(".username").val();
					var pwd = $(".pwd").val();
					var rempwd = $('.rempwd').prop("checked");
					
					var data = {
						username: username,
						pwd: pwd,
						rempwd: rempwd==true?'1':'0'
					}
					console.log(data)
					$.ajax({
	                    type:"post",
	    				url: "?act=login",
	    				data: data,
	    				dataType: "json",
	    				success: function(result)
	    				{
	                        if(result.result == true)
	                        {
	                        	location.href = result.data.url
	                        }else{
								alert(result.data)
	                        }	                        
	                    }
	                })
				});
			})
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
