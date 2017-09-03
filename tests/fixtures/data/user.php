<?php
return [
    'admin' => [
        'id' => '100',
        'username' => 'admin',
        'email' => 'admin@admin.com',
        //'admin!!!'
        'password_hash' => '$2y$13$3oV/KLi6vhpSRvolstrO4.uevbV9wxXrQC92ay69CajxED37EgaDa',
        'auth_key' => 'admin-key',
        'access_token' => 'admin-token',
        'role_id' => '3',
        'status' => 10,
        'created_at' => time(),
        'updated_at' => time(),
    ],
    'user' => [
        'id' => '101',
        'username' => 'user',
        'email' => 'user@user.com',
        //'user!!!'
        'password_hash' => '$2y$13$cH3wVNm9pLZuSyIpo2C17.bwLzJPHszKfPlfHSBJWP65872y/ARZ2',
        'auth_key' => 'user-key',
        'access_token' => 'user-token',
        'role_id' => '2',
        'status' => 10,
        'created_at' => time(),
        'updated_at' => time(),
    ],
    'guest' => [
        'id' => '102',
        'username' => 'guest',
        'email' => 'guest@guest.com',
        //'111111'
        'password_hash' => '$2y$13$V7lKMP7rDZNPMaeMt/TwnuxBUK4ybKNLpFEaVkOlxC68teHHExBp2',
        'auth_key' => 'guest-key',
        'access_token' => 'guest-token',
        'role_id' => '1',
        'status' => 10,
        'created_at' => time(),
        'updated_at' => time(),
    ],
];