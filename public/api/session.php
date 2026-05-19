<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'logged_in' => isset($_SESSION['user_id']),
    'user_id'   => $_SESSION['user_id']   ?? null,
    'username'  => $_SESSION['username']  ?? null,
]);
