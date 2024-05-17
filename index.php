<?php
require_once __DIR__ . '/app/functions/bootstrap.php';

use blog\database\Database;

$db = new Database();

dd($db->all("SELECT * FROM users"));
// dd($db->find('users', 1));

$data = [
  'username' => 'admin1',
  'email' => 'admin1gmail.com',
  'password' => '12345',
];

$db->update('users', $data,1);

$insert = [
  'username' => 'student2',
  'email' => 'student2gmail.com',
  'password' => '12345',
];
// dd($db->insert('users', $insert));

$delete = [
  'id' => 7, 
];
// dd($db->delete('users', $delete));

