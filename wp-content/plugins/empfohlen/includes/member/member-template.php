<?php
/*
 * Template Name: MemberDasboard
 * Description: A Page Template with empfohlen member dashboard.
 */

get_header();



global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );


 $tmpl = get_query_var('tmpl');

 // echo "<pre> query_string "; print_r( $wp->request  ); echo "</pre> ";  
 // echo "<pre> wp_query "; print_r( $wp_query->query_vars  ); echo "</pre> ";  
 // echo "<pre> tmpl "; print_r( $tmpl  ); echo "</pre> ";  


 
  // echo "<pre> _GET "; print_r( $_GET ); echo "</pre> ";  

	$tmpl =  isset($_GET['tmpl'])?($_GET['tmpl']):'overview';
 // wp_query
 // echo "<pre> request "; print_r( $wp->request   ); echo "</pre> ";  
 // echo "<pre> request "; print_r( get_permalink()   ); echo "</pre> ";  
 // // $current_url = $current_url.'&tmpl=setting';
 // echo "<pre>  current_url "; print_r( $current_url ); echo "</pre> "; 


 $sef_current_url = home_url(add_query_arg(array(),$wp->request));
 // echo "<pre>  sef_current_url "; print_r( $sef_current_url ); echo "</pre> "; 
?>
	
	<div class="fusion-column-wrapper" style="width:100%;">
	<div class="content-area memberDashboard">
<!-- 		 <h4 style="text-align: center">Member Dashboard </h4> -->


		 <div class="tabs">
		 	
		 		<ul class="tabBar">
		 			<li class="<?= $tmpl == 'overview'? 'active': ''?>" name="overview"><a href="<?php echo get_permalink() ?>?tmpl=overview">Overview</a></li>
		 			<li class="<?= $tmpl == 'jobs'? 'active': ''?>" name="jobs"><a href="<?php echo get_permalink() ?>?tmpl=jobs"">Jobs</a></li>
		 			<li class="<?= $tmpl == 'setting'? 'active': ''?>" name="settings"><a href="<?php echo get_permalink() ?>?tmpl=setting"">Settings</a></li>
		 			<li class="<?= $tmpl == 'pay'? 'active': ''?>" name="transactions"><a href="<?php echo get_permalink() ?>?tmpl=pay"">Paying out</a></li>
		 		</ul>

		 </div>

		 <div class="content">
		 	<?php
		 	  if( $tmpl == 'overview' ){

		 	  	  load_template(EMPFOHLEN_DIR.'includes/member/templates/overview.php');

		 	  }elseif ($tmpl == 'jobs') {
		 	  	
		 	  	load_template(EMPFOHLEN_DIR.'includes/member/templates/jobs.php');
		 	  
		 	  }elseif ($tmpl == 'setting') {
		 	  
		 	  	load_template(EMPFOHLEN_DIR.'includes/member/templates/setting.php');
		 	  
		 	  }elseif ($tmpl == 'pay') {

		 	  	load_template(EMPFOHLEN_DIR.'includes/member/templates/pay.php');
		 	  
		 	  }
		 	?>
		 </div>

	</div> 
    </div>

<?php
get_footer();