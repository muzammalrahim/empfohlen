(function( $ ) {
	'use strict';

	function toggleFab() {
		$('.prime').toggleClass('zmdi-comment-outline');
		$('.prime').toggleClass('zmdi-close');
		$('.prime').toggleClass('is-active');
		$('.prime').toggleClass('is-visible');
		$('#prime').toggleClass('is-float');
		$('.chat').toggleClass('is-visible');
		$('.fab').toggleClass('is-visible');
	}


	$(document).on('click','#prime',function(){
		toggleFab();
	});
	$(document).on('click','#chat_fullscreen_loader',function(e){
		$('.fullscreen').toggleClass('zmdi-window-maximize');
		$('.fullscreen').toggleClass('zmdi-window-restore');
		$('.chat').toggleClass('chat_fullscreen');
		$('.fab').toggleClass('is-hide');
		$('.header_img').toggleClass('change_img');
		$('.img_container').toggleClass('change_img');
		$('.chat_header').toggleClass('chat_header2');
		$('.fab_field').toggleClass('fab_field2');
		$('.chat_converse').toggleClass('chat_converse2');
	});


  // will use to add into member page to show login staff
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
					}else{
						$(this).children().find('.online_icon').addClass('offline');
					}
				});
			}

		});
	 


})( jQuery );
