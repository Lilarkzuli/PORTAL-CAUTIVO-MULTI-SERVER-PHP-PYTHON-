<?php







  $host = '192.168.110.170';

    $port = 22;

    $username = 'helena';

    $password = '123';

  

    $connection = ssh2_connect($host, $port);

    ssh2_auth_password($connection, $username, $password);

  

    $stream = ssh2_exec($connection, '');

    stream_set_blocking($stream, true);

    $output = stream_get_contents($stream);

  

    print_r($output);






?>