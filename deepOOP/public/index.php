<?php
require '../vendor/autoload.php';
use App\QueryBuilder;

$db = new \App\QueryBuilder();

$result = $db->getAll('posts');
 var_dump($result);

// $data = [
//     "title" => "New" . date('U')
// ];

//$db->insert([
//    "title" => "new Gid"
//], 'posts');

//$db->update([
//    'title' => 'Gid new'
//], 2, 'posts');


$db->delete('posts', 2);
