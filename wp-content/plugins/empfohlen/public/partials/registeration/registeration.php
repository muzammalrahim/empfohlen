<?php if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly ?>


<?php
	
	// echo "EMPFOHLEN_DIR = ".EMPFOHLEN_DIR;
	// echo "<br / > get_template_directory_uri = ".get_template_directory_uri();
	// echo "<br / > EMPFOHLEN_URI = ".EMPFOHLEN_URI;

  wp_register_script(	'emp_reg_script', EMPFOHLEN_URI. 'public/js/ajax-registration.js', array('jquery'), null, false);
  wp_enqueue_script(	'emp_reg_script');
  wp_localize_script( 'emp_reg_script', 'emp_reg_vars', array('emp_ajax_url' => admin_url( 'admin-ajax.php' ),));

  // var ajax_url = emp_reg_vars.emp_ajax_url;

?>


 <form id="emp_registration_form" class="emp_form" action="" method="POST">
	<fieldset>
		
		<!--
		<p>
			<label for="emp_user_uid"><?php _e('Member ID', 'emp'); ?></label>
			<input name="emp_user_uid" id="emp_user_uid" class="" type="text"/>
		</p> 
		-->

		<div class="emp_reg_message">
			
		</div>

		<p>
			<label for="emp_user_Login"><?php _e('Username', 'emp'); ?></label>
			<input name="emp_user_login" id="emp_user_login" class="required" type="text"/>
		</p>

		<p>
			<label for="emp_user_first"><?php _e('First Name', 'emp'); ?></label>
			<input name="emp_user_first" id="emp_user_first" type="text"/>
		</p>

		<p>
			<label for="emp_user_last"><?php _e('Surname', 'emp'); ?></label>
			<input name="emp_user_last" id="emp_user_last" type="text"/>
		</p>

		<p>
			<label for="emp_user_email"><?php _e('Email', 'emp'); ?></label>
			<input name="emp_user_email" id="emp_user_email" class="required" type="email"/>
		</p>

		<p>
			<label for="password"><?php _e('Password', 'emp'); ?></label>
			<input name="emp_user_pass" id="password" class="required" type="password"/>
		</p>
		<p>
			<label for="password_again"><?php _e('Password Again', 'emp'); ?></label>
			<input name="emp_user_pass_confirm" id="password_again" class="required" type="password"/>
		</p>

		<p>
			<label for="emp_user_birthday"><?php _e('Birthday', 'emp'); ?></label>
			<input name="emp_user_birthday" id="emp_user_birthday" type="text"/>
		</p>


		<p>
			<label for="emp_user_address"><?php _e('Address', 'emp'); ?></label>
			<textarea rows="4" cols="50" name="emp_user_address" id="emp_user_address"></textarea>
		</p>


		<div>
			<h4>Relevant information</h4>
			<?php

				$skill = get_terms( 
						'skill', 
						array(
							'hide_empty' 		=> false,
							'parent'            => 0,
						)
					);

				 // echo "<pre>  skill "; print_r( $skill ); echo "</pre> ";  

			if(!empty($skill)){
				foreach ($skill as $skey => $p_skill) {
					if( $p_skill->count > 0 ){
						$c_skills = get_terms('skill', array('parent'   => $p_skill->term_id, 'hide_empty' => false));
						 // echo "<pre> c_skills "; print_r( $c_skills ); echo "</pre> ";  
						 if(!empty($c_skills)){ ?>

						 	<div class="skills_cont">
						 		<p><?php echo $p_skill->name; ?></p>
						 		<ul class="c_skills_list">
						 			<?php 
						 			foreach ($c_skills as $cskey => $c_skill) { ?>
						 					<li class="row cskill_<?php echo $c_skill->term_id ?>">
						 						<label class="selectit">
						 							<input 
						 								value="<?php echo $c_skill->term_id; ?>" 
						 								type="checkbox" 
						 								name="tax_skill[<?php echo $c_skill->term_id;?>]" 
						 								id="in-skill-<?php echo $c_skill->term_id ?>"> <?php echo $c_skill->name; ?>
						 						</label>
						 					</li>
						 			<?php
						 			}
						 			?>
						 		</ul>
						 		 <!-- c_skills_list end -->
						 	</div>
						 	<?php
						 }
					}
				}
			}


			?>
		</div>


		
		
		
		
		
		<p>
			<input type="hidden" name="emp_register_nonce" value="<?php echo wp_create_nonce('emp-register-nonce'); ?>"/>
			<input id="emp_register_btn" type="submit" value="<?php _e('Register Your Account', 'emp'); ?>"/>
		</p>
	</fieldset>
</form>