<?php 
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

// ======= LOGIN FORM =====>

 
// return form #1
// usage: $result = get_empfohlen_form_login();

function get_empfohlen_form_login($redirect=false) {
  global $empfohlen_form_count;
  ++$empfohlen_form_count;
  if (!is_user_logged_in()) :
    $return = "<form action=\"\" method=\"post\" class=\"empfohlen_form empfohlen_form_login\">\r\n";
    $error = get_empfohlen_error($empfohlen_form_count);
    if ($error)
      $return .= "<p class=\"error\">{$error}</p>\r\n";
    $success = get_empfohlen_success($empfohlen_form_count);
    if ($success)
      $return .= "<p class=\"success\">{$success}</p>\r\n";

    $return .= "  <p>
      <label for=\"empfohlen_username\">".__('Username','empfohlen_login')."</label>
      <input type=\"text\" id=\"empfohlen_username\" name=\"empfohlen_username\"/>
    </p>\r\n";

    $return .= "  <p>
      <label for=\"empfohlen_password\">".__('Password','empfohlen_login')."</label>
      <input type=\"password\" id=\"empfohlen_password\" name=\"empfohlen_password\"/>
    </p>\r\n";
   
    if ($redirect)
      $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";
   
    $return .= "  <input type=\"hidden\" name=\"empfohlen_action\" value=\"login\">\r\n";
    $return .= "  <input type=\"hidden\" name=\"empfohlen_form\" value=\"{$empfohlen_form_count}\">\r\n";
    $return .= "  <button type=\"submit\">".__('Login','empfohlen_login')."</button>\r\n";
    $return .= "</form>\r\n";
  else : 
    $return = __('User is logged in.','empfohlen_login');
  endif;
  return $return;
}
// print form #1
/* usage: <?php the_empfohlen_form_login(); ?> */
function the_empfohlen_form_login($redirect=false) {
  echo get_empfohlen_form_login($redirect);
}
// shortcode for form #1
// usage: [empfohlen_form_login] in post/page content
add_shortcode('empfohlen_form_login','empfohlen_form_login_shortcode');
function empfohlen_form_login_shortcode ($atts,$content=false) {
  $atts = shortcode_atts(array(
    'redirect' => false
  ), $atts);
  return get_empfohlen_form_LOGIN($atts['redirect']);
}
 
// <============== FORM LOGIN
 
 
// ======= FORM REGISTER =====>
 
// return form #2
// usage: $result = get_empfohlen_form_register();
function get_empfohlen_form_register($redirect=false) {
  global $empfohlen_form_count;
  ++$empfohlen_form_count;
  if (!is_user_logged_in()){

  }else{

  }
   //  $return = "<form action=\"\" method=\"post\" class=\"empfohlen_form empfohlen_form_register\">\r\n";
    
   //  // $error = get_empfohlen_error($empfohlen_form_count);
   //  // if ($error)
   //  //   $return .= "<p class=\"error\">{$error}</p>\r\n";
   //  // $success = get_empfohlen_success($empfohlen_form_count);
   //  // if ($success)
   //  //   $return .= "<p class=\"success\">{$success}</p>\r\n";

   // // add as many inputs, selects, textareas as needed
   //  $return .= "<p>
   //    <label for=\"empfohlen_username\">".__('Username','empfohlen_login')."</label>
   //    <input type=\"text\" id=\"empfohlen_username\" name=\"empfohlen_username\"/>
   //  </p>\r\n";
   //  $return .= "  <p>
   //    <label for=\"empfohlen_email\">".__('Email','empfohlen_login')."</label>
   //    <input type=\"email\" id=\"empfohlen_email\" name=\"empfohlen_email\"/>
   //  </p>\r\n";
  // where to redirect on success
    if ($redirect)
      $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";
   
    $return .= "  <input type=\"hidden\" name=\"empfohlen_action\" value=\"register\">\r\n";
    $return .= "  <input type=\"hidden\" name=\"empfohlen_form\" value=\"{$empfohlen_form_count}\">\r\n";
   
    $return .= "  <button type=\"submit\">".__('Register','empfohlen_login')."</button>\r\n";
    $return .= "</form>\r\n";
  else : 
    $return = __('User is logged in.','empfohlen_login');
  endif;
  return $return;
}
// print form #1
/* usage: <?php the_empfohlen_form_register(); ?> */
function the_empfohlen_form_register($redirect=false) {
  echo get_empfohlen_form_register($redirect);
}
// shortcode for form #1
// usage: [empfohlen_form_register] in post/page content
add_shortcode('empfohlen_form_register','empfohlen_form_register_shortcode');
function empfohlen_form_register_shortcode ($atts,$content=false) {
  $atts = shortcode_atts(array(
    'redirect' => false
  ), $atts);
  return get_empfohlen_form_register($atts['redirect']);
}
 
// <============== LOGIN FORM
 
// ============ FORM SUBMISSION HANDLER
add_action('init','empfohlen_handle');
function empfohlen_handle() {
  $success = false;
  if (isset($_REQUEST['empfohlen_action'])) {
    switch ($_REQUEST['empfohlen_action']) {
      case 'login':
        if (!$_POST['empfohlen_username']) {
          set_empfohlen_error(__('<strong>ERROR</strong>: Empty username','empfohlen_login'),$_REQUEST['empfohlen_form']);
        } else if (!$_POST['empfohlen_password']) {
          set_empfohlen_error(__('<strong>ERROR</strong>: Empty password','empfohlen_login'),$_REQUEST['empfohlen_form']);
        } else {
          $creds = array();
          $creds['user_login'] = $_POST['empfohlen_username'];
          $creds['user_password'] = $_POST['empfohlen_password'];
          //$creds['remember'] = false;
          $user = wp_signon( $creds );
          if ( is_wp_error($user) ) {
            set_empfohlen_error($user->get_error_message(),$_REQUEST['empfohlen_form']);
          } else {
            set_empfohlen_success(__('Log in successful','empfohlen_login'),$_REQUEST['empfohlen_form']);
            $success = true;
          }
        }
        break;
      case 'register':
        if (!$_POST['empfohlen_username']) {
          set_empfohlen_error(__('<strong>ERROR</strong>: Empty username','empfohlen_login'),$_REQUEST['empfohlen_form']);
        } else if (!$_POST['empfohlen_email']) {
          set_empfohlen_error(__('<strong>ERROR</strong>: Empty email','empfohlen_login'),$_REQUEST['empfohlen_form']);
        } else {
          $creds = array();
          $creds['user_login'] = $_POST['empfohlen_username'];
          $creds['user_email'] = $_POST['empfohlen_email'];
          $creds['user_pass'] = wp_generate_password();
          $creds['role'] = get_option('default_role');
          //$creds['remember'] = false;
          $user = wp_inser_user( $creds );
          if ( is_wp_error($user) ) {
            set_empfohlen_error($user->get_error_message(),$_REQUEST['empfohlen_form']);
          } else {
            set_empfohlen_success(__('Registration successful. Your password will be sent via email shortly.','empfohlen_login'),$_REQUEST['empfohlen_form']);
            wp_new_user_notification($user,$creds['user_pass']);
            $success = true;
          }
        }
        break;
      // add more cases if you have more forms
    }
 
    // if redirect is set and action was successful
    if (isset($_REQUEST['redirect']) && $_REQUEST['redirect'] && $success) {
      wp_redirect($_REQUEST['redirect']);
      die();
    }      
  }
}


// ================= UTILITIES

if (!function_exists('set_empfohlen_error')) {
  function set_empfohlen_error($error,$id=0) {
    $_SESSION['empfohlen_error_'.$id] = $error;
  }
}
// shows error message
if (!function_exists('the_empfohlen_error')) {
  function the_empfohlen_error($id=0) {
    echo get_empfohlen_error($id);
  }
}
 
if (!function_exists('get_empfohlen_error')) {
  function get_empfohlen_error($id=0) {
    if ($_SESSION['empfohlen_error_'.$id]) {
      $return = $_SESSION['empfohlen_error_'.$id];
      unset($_SESSION['empfohlen_error_'.$id]);
      return $return;
    } else {
      return false;
    }
  }
}
if (!function_exists('set_empfohlen_success')) {
  function set_empfohlen_success($error,$id=0) {
    $_SESSION['empfohlen_success_'.$id] = $error;
  }
}
if (!function_exists('the_empfohlen_success')) {
  function the_empfohlen_success($id=0) {
    echo get_empfohlen_success($id);
  }
}
 
if (!function_exists('get_empfohlen_success')) {
  function get_empfohlen_success($id=0) {
    if ($_SESSION['empfohlen_success_'.$id]) {
      $return = $_SESSION['empfohlen_success_'.$id];
      unset($_SESSION['empfohlen_success_'.$id]);
      return $return;
    } else {
      return false;
    }
  }
}

?>