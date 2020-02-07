<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
//Exit if accessed directly 

get_header();



// do_action('submit_task_port');
 global $_SESSION;

 $success =  	$_SESSION['task_success'];
 $error 	= 	$_SESSION['task_error'];

 unset($_SESSION['task_success']);
 unset($_SESSION['task_error']);


$post->request = '';
$post->project = '';

 // echo "<pre> project "; print_r( $project->ID  ); echo "</pre> ";  
$current_user = wp_get_current_user();
$userData = $current_user->data;
$user_id = (int) $userData->ID;


$post->status = get_field('task_status', $post->ID);
$post->task_content = get_field('task_content', $post->ID);
$post->task_additional_info = get_field('task_additional_info', $post->ID);


$upload_dir = wp_get_upload_dir(); 
$dest_dir 	= $upload_dir['basedir'].'/userdata/'.$user_id.'/task/'.$post->ID; 
$task_files = scandir($dest_dir);

$ex_folders = array('..', '.');
$task_files = array_diff($task_files, $ex_folders);
$post->task_files = $task_files;

$download_dir = $upload_dir['baseurl'].'/userdata/'.$user_id.'/task/'.$post->ID;
$post->download_dir = $download_dir;

// echo "<pre>  task_files "; print_r( $task_files ); echo "</pre> ";  

// echo "<pre> post "; print_r( $post ); echo "</pre> ";  
// get project detail of this task 
$request_id = (int) get_field('request_id', $post->ID);
if(!empty($request_id)){
	$repest   		= get_post( $request_id);
	$post->repest = $repest;
	 // echo "<pre> repest "; print_r( $repest  ); echo "</pre> ";  

	 // get request project data 
	 if(!empty($repest)){
	 		$project_id = (int) get_field('select_project_id', $repest->ID);
	 		if(!empty($project_id)){
	 			$project   			= get_post($project_id);
	 			if(!empty($project)) {

	 					// get project meta data 
	 					$project->keyword 				= get_field('keyword', $project->ID);
	 					$project->timer_enable 		= get_field('timer_enable', $project->ID);
	 					$project->duration 				= get_field('duration', $project->ID);
	 					$project->pay 						= get_field('pay', $project->ID);
	 					$project->expiration_date = get_field('expiration_date', $project->ID);
	 					$project->description 		= get_field('description', $project->ID);
	 					$project->requirments 		= get_field('requirments', $project->ID);
	 					$project->additional_information = get_field('additional_information', $project->ID);

	 			}
	 			//keyword	


	 			$post->project 	= $project;
	 		}
	 }

}
?>
	
	<?php if(isset($success)): ?>
			<p>Success: <?php echo $success; ?></p>
	<?php endif; ?>

	<?php if(isset($error)): ?>
			<p>Error: <?php echo "<pre>"; print_r(  $error ); echo "</pre> "; ?></p>
	<?php endif; ?>
	
	<div class="task_tab">
		
		<div class="t_p_info">
			<h4>Project info</h4>
			<p>Title: 					<?php echo !empty($post->project)?($post->project->post_title):'';?></p>
			
			<p>Keyword: 				<?php 
					 $keyword = !empty($post->project)?($post->project->keyword):'';
					 echo implode(wp_list_pluck($post->project->keyword,'name'),'');
			?></p>
			
			<p>Timer: 					<?php echo !empty($post->project)?($post->project->timer_enable):''; ?></p>
			
			<p>Duration: 				<?php echo !empty($post->project)?($post->project->duration):'';?></p>
			<p>Pay: 						<?php echo !empty($post->project)?($post->project->pay):'';?></p>
			<p>Expiration Date: <?php echo !empty($post->project)?($post->project->expiration_date):'';?></p>
			
			<div>
				<h4>Project Description</h4>
				<?php echo !empty($post->project)?($post->project->description):'';?>
			</div>
			
			<div>
				<h4>Project requirments</h4>
				<?php 
					// echo !empty($post->project)?($post->project->requirments):'';
					// echo "<pre> requirments "; print_r( $post->project->requirments ); echo "</pre> ";  
					if(!empty($post->project->requirments)){
						foreach ($post->project->requirments as $r_key => $r_value) {
							echo '<p>Requirment '.($r_key+1).': '.$r_value['requirment'].'</p>'; 
						}
					}
				?>
			</div>

			<div>
			 	<h4>Additional Information</h4>
			 	<?php echo !empty($post->project)?($post->project->additional_information):'';?>
			</div>

		</div> <!-- t_p_info end -->


		<div class="task_detail">
			<h4>Task Detail</h4>
			<p>Task Status: <?php echo $post->status; ?></p>
			
			<div class="task_edit_layout">
			 		<form method="post" enctype="multipart/form-data">
             <h4>Task content</h4>
             <div class="content_edit">
	             <?php 
	             	$content = $post->task_content; //This content gets loaded first.';
	             	$editor_id = 'p_t_content_editor';
	             	wp_editor( $content, $editor_id );
	             ?>
           	</div>

           	<div class="additional_info_edit">
           		<h4>Task Additional Info</h4>
           		<?php  wp_editor( $post->task_additional_info, 'p_t_additional_info_editor' ); ?>
           	</div>

           	<div class="additional_info_edit">
           		<h4>Upload Files</h4>
            	<input type="file" name="task_files[]" multiple>
            </div>
            


            <div class="task_action">
							<h4>Task Action</h4>
							
							<input type="hidden" name="emp_submit_task_nonce" value="<?php echo wp_create_nonce('emp-submit-task-nonce'); ?>"/>
							<input type="hidden" name="action" value="submit_task" />
							<input type="hidden" name="task_id" value="<?php echo $post->ID; ?>" />

							<input type="submit" value="Submit Task">
							

						</div>

        </form>
			</div>

			<div class="task_display_layout">
					<div class="task_files">
						<h4>Task uploaded Files</h4>
						<?php if(isset($post->task_files) && !empty($post->task_files)): ?>
							<?php 
								foreach ($post->task_files as $tdf_key => $tdf) { ?>
									
									<div class="task_file">
											<div class="file-icon">
												<img src="<?php echo get_site_url(); ?>/wp-includes/images/media/default.png">
											</div>
											<span class="file_title"><?php echo $tdf; ?></span>
											<span class="file_button"><a href="<?php echo $post->download_dir.'/'.$tdf;?>">Download</a></span>
										
									</div>
								<?php
								}
							?>
						<?php endif; ?>
					</div>

			</div>

		</div>

		
		


	</div>



<style type="text/css">
	.t_p_info,
	.task_detail{ 
	  border: 1px solid black;
    width: 90%;
    margin: 20px auto;
  }

  
  .task_detail.edit_task .edit_layout{ display: block; }
  .task_detail.edit_task .show_layout{ display: none; }



.file-icon {
    padding: 10px;
    text-align: center;
}

.task_file {
    display: inline-block;
    text-align: center;
    margin: 10px;
    padding: 5px;
    border: 1px solid #888888;
}

.file-icon img {
    margin: 0 auto;
}
.file_button{ display: block;   }
.file_button a{   text-decoration: none; }
</style>

<script type="text/javascript">
	jQuery(document).ready(function(){

		// p_t_edit_task
		jQuery('.p_t_edit_task').on('click',function(){
			jQuery('.task_detail').addClass('edit_task');
		});


		// tinyMCE.init({
  //       mode : "specific_textareas",
  //       theme : "simple", 
  //       plugins : "autolink, lists, spellchecker, style, layer, table, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template",
  //       editor_selector :"tinymce-enabled"
  //   });



	}); 

</script>



<?php
get_footer();