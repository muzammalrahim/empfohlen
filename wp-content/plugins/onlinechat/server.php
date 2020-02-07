<?php
require __DIR__ . './pusher_vendor/vendor/autoload.php';

$options = array(
    'cluster' => 'ap2',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    '873fa5b09013497c369d',
    '85946c5c59d2d6c4ab98',
    '939606',
    $options
);

$data['message'] = 'hello world';
$pusher->trigger('my-channel', 'my-event', $data);
?>