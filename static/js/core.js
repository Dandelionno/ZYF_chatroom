var MainController = {
	wsUrl : "ws://192.168.1.128:9502",
	userid : 0,
	username : '',
	fd: -1,
	
	init: function()
	{
		var self = this;
		this.userid = $('#currUserId').val();
		this.username = $('#currUserName').val();
		if(self.username == '' || self.userid==0)
		{
			location.href = 'login.php';
		}
		
		
		var ws = new WebSocket(this.wsUrl);
		
		ws.onopen = function(evt) 
		{
			console.log("Connection open ...");
			
			if(self.username == '' || self.userid==0)
			{
				location.href = 'login.php';
			}
		};
		
		//接收到信息
		ws.onmessage = function(evt) 
		{			
			var msg_obj = JSON.parse(evt.data);
			
			if(msg_obj.type == 1)
			{//其他人的消息
				self.showMsg(1, msg_obj.data);
				
			}else if(msg_obj.type == 2)
			{//系统消息
				self.showMsg(3, msg_obj.data);
				
			}else if(msg_obj.type == 3)
			{//接收所有在线用户信息
				
				var onlineUserList = '';
				for(var i in msg_obj.data)
				{
					var onlineUserInfo = msg_obj.data[i];
					var tpl_onlineUser = $('#tpl_onlineUser').clone();
					tpl_onlineUser.find('.onlineUserPic img').attr('src', onlineUserInfo.image);
					tpl_onlineUser.find('.onlineUserInfo span').text(onlineUserInfo.username);
					
					onlineUserList += tpl_onlineUser.html();
				}				
				
				$('.onlineUserList').html($(onlineUserList));
				
			}else if(msg_obj.type == 4)
			{//程序信息
				
				if(msg_obj.data.fd && msg_obj.data.fd != undefined)
				{
					self.fd = msg_obj.data.fd;
					
					//把上线的用户信息告诉服务器，类型3			
					var data = {
						userid: self.userid,
						username: self.username,
						fd: self.fd
					}
					var msg_obj = self.formatMsg(data, 3)
					ws.send(msg_obj)
				}
				
			}
		};

		//关闭
		ws.onclose = function(evt) {	
			console.log("Connection closed.");
		}	
		
		
		
		//发送信息的按钮
		$(".sendbtn").on('click', function(){
			var msg = $.trim($('.msg').val());
			if(msg == ''){ return; }
			
			var data = {
				user:{
					userid: self.userid,
					username: self.username,
					image: $('.userpic img').attr('src')
				},
				msg: msg,
			};
			var msg_obj = self.formatMsg(data, 1);
			ws.send(msg_obj);	
			
			self.showMsg(2, data);
			$('.msg').val('').focus();
		});
		
		//点击用户头像进入用户中心
		$('.act_gotoUserCenter').on('click', function(){
			location.href = 'index.php?m=usercenter&id=';
		});
	},
	
	
	formatMsg: function(data, type)
	{
		if(!type){ type = 1; }
		
		var msg_obj = {
			data: data,
			type: type
		}
		msg_obj = JSON.stringify(msg_obj);
		
		return msg_obj;
	},
	
	//显示信息到消息板上
	showMsg: function(type, data)
	{
		console.log(data)
		if(type==1)//显示别人发的消息
		{
			var msgItem = $(this.getMsgTpl(type));
			msgItem.find('.userChatPic img').attr('src', data.user.image);
			msgItem.find('.msg_con').text(data.msg);
		}else if(type==2)//显示自己发的消息
		{
			var msgItem = $(this.getMsgTpl(type));
			msgItem.find('.userChatPic img').attr('src', data.user.image);
			msgItem.find('.msg_con').text(data.msg);
		}else if(type == 3)//系统消息
		{
			var msgItem = $(this.getMsgTpl(type));
			msgItem.find('.msg_con').text(data);
		}
		
		$(".chatbody_center_msgboard").append(msgItem);
	},
	
	getMsgTpl: function(type)
	{
		var msgTpl = '';
		if(type==1)//显示别人发的消息
		{
			msgTpl += '<div class="msgitem msgitem_other">';
			msgTpl += '<div class="userChatPic">';
			msgTpl += '<img src="">';
			msgTpl += '</div>';
			msgTpl += '<span class="msg_con"></span></div>';
			msgTpl += '<div class="clear"></div>';
		}else if(type==2)//显示自己发的消息
		{
			msgTpl += '<div class="msgitem msgitem_self">';
			msgTpl += '<div class="userChatPic">';
			msgTpl += '<img src="">';
			msgTpl += '</div>';
			msgTpl += '<span class="msg_con"></span></div>';
			msgTpl += '<div class="clear"></div>';
		}else if(type == 3)//系统消息
		{
			msgTpl += '<div style="text-align:center;"><div class="msgitem msgitem_sys"><span class="msg_con"></span></div></div>';
			msgTpl += '<div class="clear"></div>';
		}		
		
		return msgTpl;
	}
}


