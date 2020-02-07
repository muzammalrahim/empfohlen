<?php
function users_datatables_scripts() {
    wp_enqueue_script( 'users_datatables1', '/wp-content/plugins/onlinechat/admin/js/onlinechat-admin.js', array(), '1.0', true );
    wp_localize_script(
        'users_datatables1',
         'ajax_url', array(
                    'users' => admin_url('admin-ajax.php?action=users_datatables'),
                    'messages' => admin_url('admin-ajax.php?action=users_messages'),
                )
    );
}
echo do_shortcode('[users_list]');
?>



