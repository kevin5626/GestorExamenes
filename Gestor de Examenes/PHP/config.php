<?php
return [
    'servidor'    => getenv('DB_HOST')     ?: 'localhost',
    'usuario'     => getenv('DB_USER')     ?: 'root',
    'contrasena'  => getenv('DB_PASSWORD') ?: '1234',
    'basededatos' => getenv('DB_NAME')    ?: 'gestor_examenes',
    'charset'     => 'utf8mb4',
];
?>