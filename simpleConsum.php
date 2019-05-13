    <?php


    require_once '../vendor/autoload.php';  
    use PhpAmqpLib\Connection\AMQPStreamConnection;  
    $connection = new AMQPStreamConnection('172.17.0.5', 5672, 'dabaobei', '123456','dabaobei');  
    $channel = $connection->channel();  
      
    $channel->queue_declare('hello', false, false, false, false);  
      
    echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";  
    $callback = function($msg) {  
      echo " [x] Received ", $msg->body, "\n";  
    };  
      
    //在接收消息的时候调用$callback函数  
    $channel->basic_consume('hello', '', false, true, false, false, $callback);  
      
    while(count($channel->callbacks)) {  
        $channel->wait();  
    }

    ?>
