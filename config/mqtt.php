<?php

$name = "Ely Gian Ga";
echo "MQTT Admin Panel by $name\n";

return [
    'host' => 'http://localhost/library_inventory/admin/index.php', 
    'port' =>  '8883', 
    'username' => 'root',
    'password' => '', 
    'client_id' => 'admin-panel-' . uniqid(), 
];

