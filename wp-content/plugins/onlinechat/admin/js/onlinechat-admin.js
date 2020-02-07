(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function() {
		var OffSet = 0;
		var Vexists = true;
		var win = $('.msg_card_body');

		$('#userslist').dataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": ajax_url.users,
				"action": "users_datatables",
				"type": "GET",
			},
		} );

		$('#onlineusers').dataTable({
			"processing": true,
			"serverSide": true,
			"bPaginate": false,
			"bLengthChange": false,
			"fnDrawCallback": function() {
				$("#onlineusers thead").remove();
			},
			"columnDefs": [
				{
					"targets": [1],
					"visible": false,
					"searchable": true
				},

			],
			"bInfo": false,
			"ajax": {
				"url": ajax_url.onlineusers,
				"action": "online_users",
				"type": "GET",
			},
		});

		var oTable = $('#onlineusers').DataTable();
		$('.search').keyup(function(){
			oTable.search( $(this).val() ).draw();
		})
		function save_message() {
			var message = $('.type_msg').val();
			var room = $('.msg_head').children().find('.send_message_to').attr("data-c");
			if(message === '')
				return false;
			var to = $('.send_message_to').attr('data-id');
			var name = 'Hamid Raza';
			var chat_message = {
				name: name,
				message: message,
				to: to,
				room_id: room,
			}
			jQuery('.msg_card_body').append('<div class="d-flex justify-content-end mb-4">' +
				'<div class="msg_cotainer_send">'+ message +
					'<span class="msg_time_send">'+new Date().toLocaleTimeString()+'</span>' +
					'</div><div class="img_cont_msg"><img src="https://static.turbosquid.com/Preview/001214/650/2V/boy-cartoon-3D-model_D.jpg"class="rounded-circle user_img_msg">' +
					'</div>' +
				'</div>').animate({scrollTop: $('.msg_card_body').prop("scrollHeight")}, 500);

			$('.type_msg').val('');
			$.ajax({
				type: "POST",
				url: ajax_url.messages,
				dataType: "json",
				data: chat_message,
				action:"users_messages",
				success: function(response, textStatus, jqXHR) {
					//console.log(response);
					//console.log(textStatus);
					//console.log(jqXHR.responseText);
				},
				error: function(msg) {}
			});
		}
		
		function set_pusher(room) {
			var pusher = new Pusher('873fa5b09013497c369d', {
				cluster: 'ap2',
				forceTLS: true
			});
			//var room =  $('.msg_head').children().find('.send_message_to').attr("data-c");
			 room = parseInt(room);
			var channel = pusher.subscribe('my-channel'+room);
			channel.bind('my-event', function(data) {
				if(data){
					var chat_room = '';
					chat_room = $('.send_message_to').attr('data-c');
					var me = $('.chat-con').attr('data-id');
					if(chat_room == parseInt(data.room) && data.sender != me && data.events == 'message' ){ //append into chat body if chat is active
						$('.msg_card_body').append('<div class="d-flex justify-content-start mb-4">'+
							'<div class="img_cont_msg"><img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg"></div>'
							+ '<div class="msg_cotainer">'+ data.message +
							'<span class="msg_time">'+new Date().toLocaleTimeString()+'</span>'+
							'</div></div>').animate({scrollTop: $('.msg_card_body').prop("scrollHeight")}, 500);
					}else if(data.sender != me && data.events == 'message'){
						$('.displayusers').each(function(){
							var room = $(this).children().find('.online_icon').attr('data-c');
							if(data.room == parseInt(room )){
								var Ncounter = $(this).children().find('.counter_messages').text();
								Ncounter = parseInt(Ncounter)+1;
								$(this).children().find('.counter_messages').text(Ncounter);
								$(this).children().find('.counter_messages').removeClass('hidden');
							}
						});
					}else if(data.events == 'status' && data.sender != me){ // is_typing
						$('.displayusers').each(function(){
							var roomtyping = $(this).children().find('.online_icon').attr('data-c');
							if(data.status == 'in' && roomtyping == parseInt(data.room)){
								$(this).children().find('.is_typing').text('Typing...');
							}else{
								$(this).children().find('.is_typing').text(' ');
							}
						});
					}
				}
			});
		}

		function set_pusher_for_user_status() { // check user is logged in or not // call this functions where you want to show user login status added in messages page
			var pusher = new Pusher('873fa5b09013497c369d', {
				cluster: 'ap2',
				forceTLS: true
			});

			var channel = pusher.subscribe('userstatus');
			channel.bind('my-event', function(data) {
				if(data.status){
					var user_id = data.users.id;
					var activeUser = $('.msg_head').children().find('.send_message_to').attr('data-id');
					if(user_id == parseInt(activeUser) ){
						$('.msg_head').children().find('.online_icon').removeClass('offline');
					}
					$('.displayusers').each(function(){
						var user = $(this).children().find('.online_icon').attr('data-id');
						if(user_id == parseInt(user)){
							$(this).children().find('.online_icon').removeClass('offline');
							$(this).children().find('.last_status').text('Online').css('color','#4cd137');
						}else{
							$(this).children().find('.online_icon').addClass('offline');
						}
					});
				}

			});
		}

		function CheckChatRoom(room,OffSet){ // Get users Messages
			//console.log(OffSet+': '+ OffSet);
			Pusher.logToConsole = true;
			var CheckRoom = {
				message:'CheckRoom',
				room: room,
				OffSet:OffSet
			};
			$.ajax({
				type: "POST",
				url: ajax_url.get_messages,
				dataType: "json",
				data: CheckRoom,
				action:"get_users_messages",
				beforeSend: function(){
					$('.loader').show();
				},
				success: function(response) {
					$('.loader').hide();
					var total_message = response.total > 1 ? response.total +' Messages': response.total +' Message';
					$('.msg_head').find('.total_messages').text(total_message)
					if( OffSet > response.total){
						Vexists = false;
					}
					console.log(OffSet);
					console.log(response.total);
					if(response.chat_room){
						$('.msg_head').children().find('.send_message_to').attr("data-c",response.chat_room);
					}else if(response.data){
						var len = response.data.length;
						var res = response.data;
						var html = '';
						for(var i=len; i > 0; i--){
							var id = res[i-1].id;
							if(response.sender == res[i-1].sender) {
								html += '<div class="d-flex justify-content-end mb-4">' +
									'<div class="msg_cotainer_send">' + res[i-1].message +
									'<span class="msg_time_send">' + res[i-1].create_at + '</span>' +
									'</div><div class="img_cont_msg"><img src="https://static.turbosquid.com/Preview/001214/650/2V/boy-cartoon-3D-model_D.jpg"class="rounded-circle user_img_msg">' +
									'</div>' +
									'</div>';
							}else{
								html += '<div class="d-flex justify-content-start mb-4">'+
									'<div class="img_cont_msg"><img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg"></div>'
									+ '<div class="msg_cotainer">'+ res[i-1].message +
									'<span class="msg_time">' + res[i-1].create_at + '</span>'+
									'</div></div>';
							}
						}
						var old_height = win.height();
						var old_scroll = win.scrollTop();
						$('.msg_card_body').prepend(html);
						win.scrollTop(old_scroll + $(document).height() - old_height);
					}else {

					}

				},
				error: function(msg) {}
			});
		}
		win.on('scroll',function() {
			if(win.scrollTop() == 0){
				var room =  $('.msg_head').children().find('.send_message_to').attr("data-c");
				if( Vexists === false ){
					if( $(document).find(".NoMoreData").length==false ){
						$('.msg_card_body').prepend('<p class="NoMoreData">No More .... </p>');
					}
					return false;
				}else{

					OffSet = OffSet+15;
					CheckChatRoom(room,OffSet)
				}
			}
		});




		// Trigger when Enter key pressed.
		var input = document.getElementById("type_msg");
		input.addEventListener("keyup", function(event) {
			if (event.keyCode === 13 && !event.shiftKey) {
				event.preventDefault();
				save_message();
			}
		});


		$(document).on('click', '.send_btn', function(e) {
			e.preventDefault();
			save_message();
		});


		// message chat box menu
		$('#action_menu_btn').click(function(){
			$('.action_menu').toggle();
		});
		$(document).on('click','.displayusers',function(){
			var open_chat = $(this).children().find('.online_icon').attr("data-id");
			var room = $(this).children().find('.online_icon').attr("data-c");
			var username = $(this).children().find('.user_name').text();
			$('.msg_head').children().find('.send_message_to').attr("data-id",open_chat);
			$('.msg_head').children().find('.send_message_to').attr("data-c",room);
			$('.msg_head').children().find('.user_name').html('');
			$('.msg_head').children().find('.user_name').html(username);
			$('.msg_card_body').empty();
			Vexists = true;
			CheckChatRoom(room,OffSet=0);
			set_pusher()
		});
		// on load open top user chat
		setTimeout(function(){
			var open_chat = $('.displayusers').first().find('.online_icon').attr("data-id");
			var room = $('.displayusers').first().find('.online_icon').attr("data-c");
			var username =  $('.displayusers').first().find('.user_name').text();
			$('.msg_head').children().find('.send_message_to').attr("data-id",open_chat);
			$('.msg_head').children().find('.send_message_to').attr("data-c",room);
			$('.msg_head').children().find('.user_name').html('');
			$('.msg_head').children().find('.user_name').html(username);
			$('.msg_card_body').empty();
			if(room){
				set_pusher_for_user_status(); // logged in or not
				CheckChatRoom(room,OffSet=0);
				$('.displayusers').each(function(){ // Set trigers for all users listed in the sidebar to receive messages and notigfications
					var room =  $(this).children().find('.online_icon').attr("data-c");
					room = parseInt(room);
					set_pusher(room);
				});
			}
		}, 10000);



		function notifications(status){
			var room =  $('.msg_head').children().find('.send_message_to').attr("data-c");
			var user_id =  $('.chat-con').attr("data-id");
			var chat_message = {
				status: status,
				room_id: room,
				user_id: user_id,
			}
			$.ajax({
				type: "POST",
				url: ajax_url.update_notifications,
				dataType: "json",
				data: chat_message,
				action:"users_notifications",
				success: function(response) {
					if(response.room){
						$('.displayusers').each(function () {
							var room = $(this).children().find('.online_icon').attr('data-c');
							if(parseInt(room) == response.room){
								$(this).children().find('.counter_messages').text('0');
								$(this).children().find('.counter_messages').addClass(' hidden');
							}
						});
					}
				},
				error: function(msg) {}
			});
		}

		$(".type_msg").focusin(function(){
			notifications('in');
		});
		$(".type_msg").focusout(function(){
			notifications('out');
		});
	} );
})( jQuery );






