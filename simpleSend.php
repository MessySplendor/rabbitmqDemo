<?php



//引用所需文件  
require_once '../vendor/autoload.php';  
use PhpAmqpLib\Connection\AMQPStreamConnection;  
use PhpAmqpLib\Message\AMQPMessage;  
//建立一个连接通道，声明一个可以发送消息的队列hello  
$connection = new AMQPStreamConnection('172.17.0.3', 5672, 'admin', 'admin','dabaobei');
$channel = $connection->channel();  
$channel->queue_declare('hello', false, false, false, false);  
  
//定义一个消息，消息内容为Hello World!  
$msg = new AMQPMessage('Hello World!  '.time());  
$channel->basic_publish($msg, '', 'hello');  
  
//发送完成后打印消息告诉发布消息的人：发送成功  
echo " [x] Sent 'Hello World!'\n";  
//关闭连接  
$channel->close();  
$connection->close();

//fdshfdsjfdsjhfhdsgf






?>
