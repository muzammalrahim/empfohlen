<?php if ( ! defined( 'ABSPATH' ) ) exit; 


$empfohlen_setting_options = get_option( 'emp_setting' );
$emp_currency = $empfohlen_setting_options['emp_currency']; // Currency
$current_user = wp_get_current_user();
$userData = $current_user->data;
// $test =  get_term_by('id', 8);
 // echo "<pre> get_current_user_id "; print_r( get_current_user_id() ); echo "</pre> ";  
 // echo "<pre> userData  "; print_r($userData  ); echo "</pre> ";  

// echo '<p> Overview </p>';

 $project = new WP_Query( 
 			array( 
 				'post_type' => 'project', 
 				'posts_per_page' => 10 ,
 				'meta_query' => array(
					array(
						'key' => 'members',  
						'value' => '"' . get_current_user_id() . '"',  
						'compare' => 'LIKE'
					),
				),

 
 			) 
 	);
  
  // echo "<pre> project  "; print_r(  $project ); echo "</pre> ";  
  echo '<div class="projectList">'; 

  ?>
  	
  	<div class="row project_header project_item">
  			<div class="p_pay">Pay</div>
  			<div class="p_pay">Info</div>
  			<div class="p_title">Title</div>
  			<div class="p_keyword">keyword</div>
  			<div class="p_request">Request</div>
  	</div>
  
  <?php

	 	while ( $project->have_posts() ) : $project->the_post(); 	
	 		 include(EMPFOHLEN_DIR.'public/partials/member/project_row.php');
	  endwhile; 
  echo '</div>';
  ?>


<style type="text/css">
	.project_item{
		margin: 5px;
		border-bottom: 1px solid #9E9E9E;
  }

  .project_item .p_content{ display: none;  }
  .project_item.show_detail .p_content{ display: block !important;  }

  .project_item .p_info { width: 100%; display:block;  }
	.project_item .p_pay { width: 10%; display: inline-block;  }
	
	.project_item .p_info_btn { width: 10%; display: inline-block;  }
	.project_item .p_title {  width: 40%; display: inline-block; }
	.project_item .p_keyword {  width: 20%; display: inline-block; }
	.project_item .p_kwd {  border: 1px solid black; }
	.project_item .p_request  { width: 15%; display: inline-block;}
	.project_item  .btn.btn-sm {
		padding: 0.8em 0.5em;
    font-size: 1.4rem;
    border-radius: 0.4em; 
  }

</style>