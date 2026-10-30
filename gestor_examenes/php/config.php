<?php
return [
    'servidor'    => getenv('DB_HOST')     ?: 'localhost',
    'usuario'     => getenv('DB_USER')     ?: 'root',
    'contrasena'  => getenv('DB_PASSWORD') ?: '1234', //cambie la contraseña a la de mi usuario de mysql xd
    'basededatos' => getenv('DB_NAME')    ?: 'gestor_examenes',
    'charset'     => 'utf8mb4',
];
?>