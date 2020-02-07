<?php


function users_datatables_scripts() {
    wp_enqueue_script( 'users_datatables1', '/wp-content/plugins/onlinechat/admin/js/onlinechat-admin.js', array(), '1.0', true );
    wp_localize_script(
        'users_datatables1',
        'ajax_url', array(
            'onlineusers' => admin_url('admin-ajax.php?action=online_users'),
            'messages' => admin_url('admin-ajax.php?action=users_messages'),
            'get_messages' => admin_url('admin-ajax.php?action=get_users_messages'),
            'update_notifications' => admin_url('admin-ajax.php?action=users_notifications')
        )
    );
}
$user = wp_get_current_user();
$userID = ( isset( $user->ID ) ? (int) $user->ID : 0 );
?>


<div class="chat-con" data-id="<?= $userID ?>">
 <div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." name="" class="form-control search">
                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="card-body contacts_body">
                    <ui class="contacts">
                        <?php
                            echo do_shortcode('[online_users_list_short_code]');
                        ?>

                    </ui>
                </div>
                <div class="card-footer"></div>
            </div></div>
        <div class="col-md-8 col-xl-6 chat">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                            <span class="online_icon offline"></span>
                        </div>
                        <div class="user_info">
                            <span class="user_name">Chat with</span>
                            <p class="total_messages"></p>
                        </div>
                        <div class="send_message_to" data-id="0" data-c="0">
<!--                        <div class="video_cam">-->
<!--                            <span><i class="fas fa-video"></i></span>-->
<!--                            <span><i class="fas fa-phone"></i></span>-->
<!--                        </div>-->
                    </div>
                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>
                            <li><i class="fas fa-users"></i> Add to close friends</li>
                            <li><i class="fas fa-plus"></i> Add to group</li>
                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                    <div class="loader"></div>
                <div class="card-body msg_card_body ">

                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                        </div>
                        <textarea name="" class="form-control type_msg" placeholder="Type your message..." id="type_msg"></textarea>
                        <div class="input-group-append" id="send_btn">
                            <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


