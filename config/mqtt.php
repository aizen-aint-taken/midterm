<?php

$name = "Ely Gian Ga";
echo "MQTT Admin Panel by $name\n";

return [
    'host' => 'AMBOT LANG', 
    'port' => 1883, 
    'username' => 'root',
    'password' => '', 
    'client_id' => 'admin-panel-' . uniqid(), 
];

