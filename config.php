<?php
session_start();
$pdo = new PDO('mysql:host=127.0.0.1;dbname=todo_db;charset=utf8mb4', 'root', 'Admin@123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);