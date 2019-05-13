<?php
require_once '../vendor/autoload.php';   

//require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('172.17.0.5', 5672, 'dabaobei', '123456','dabaobei');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);
$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "task Hello World!";
}
$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);
$channel->basic_publish($msg, '', 'task_queue');
echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();

?>
