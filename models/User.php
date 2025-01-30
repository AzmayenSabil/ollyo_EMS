<?php
require_once 'config.php';

class User
{
    public function registerUser($username, $email, $password)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        return $stmt->execute();
    }

    public function getUserByEmail($email)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
