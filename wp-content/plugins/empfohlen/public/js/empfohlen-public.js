(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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


	

	 

	 $(document).ready(function(){

	 	console.log(' d ready   ');
	 	
	 	// request button click 
	 	jQuery('body').on('click','.p_request_btn',function(){
	 		console.log(' click  ');

	 		var project_item = jQuery(this).closest('.project_item'); 
	 		var pid = parseInt(jQuery(this).data('pid')); 
	 		console.log(' pid = ', pid);

	 		var data = {
	 			pid: pid,
	 			action : 'project_submit_request'
	 		};

	 		var r = confirm("Are you sure you want to submit request!");
		  if (r == true) {
		    console.log(' confirm true ');
		    // Collect data from inputs			     
		    var ajax_url = emp_vars.emp_ajax_url;
		    // Do AJAX request
		    $.ajax({
		        url: ajax_url,
		       	type: 'POST',
		        dataType: 'json',
		        data: data,
		        // dataType: "json",
		        // contentType: 'application/json; charset=utf-8',
		        success: function (response) {
		        		 // response = jQuery.parseJSON(response);
		        		 console.log('success response = ', response);
		        		 if( response && response.status == 'success') {
		        		 	console.log('response.status = ', response.status);
		        		 	$(project_item).replaceWith(response.row_html);
		        		 } 
		        		 // $('.emp_reg_message').html('<p>'+response.message+'</p>');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		        	 console.log('error jqXHR ');
		           console.log(textStatus, errorThrown);
		        }
		    });




		  }  



	 	});
	 	// p_request_btn click end here.  


	 	// project info button click 
	 	jQuery('body').on('click','.p_info_btn',function(){

	 		console.log(' p_info click '); 
	 		var pid = parseInt(jQuery(this).data('pid')); 

	 		jQuery(this).closest('.project_item').toggleClass('show_detail', 5000);


	 	}); 
	 	// p_info button click end 
	 	// 
	 	// add class to body on tab change

		jQuery(function() {
			var loc = window.location.href; // returns the full URL
			// console.log(loc);
			if(/jobs/.test(loc)){
				$('#main').addClass('jobs');

			} else if(/overview/.test(loc)){
			$('#main').addClass('overview');
			}else if(/setting/.test(loc)){
			$('#main').addClass('setting');
			}else if(/pay/.test(loc)){
			$('#main').addClass('pay');
			}
		});
     
		// jQuery('.tabs li').click(function(e) {
		// jQuery(this).addClass('current');
		// //.siblings().removeClass('current');
		// });
          
     

	 });// doc ready end 


})( jQuery );
