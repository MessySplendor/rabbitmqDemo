<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('172.17.0.5', 5672, 'admin', 'admin123456','msg');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);
$data = implode(' ', array_slice($argv, 1));

$i=0;

while($i <= 100)
{
  

  $data = "task $i Hello World!";

  $msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
  );

  $channel->basic_publish($msg, '', 'task_queue');
  echo 'producer  Sent ', $data, "\n";
  $i++;
}

$channel->close();
$connection->close();

?>
