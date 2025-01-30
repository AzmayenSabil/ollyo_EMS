<?php
require_once 'models/User.php';

class AuthController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

            $userModel = new User();
            $result = $userModel->registerUser($username, $email, $password);

            // Check if the user registration was successful
            if ($result) {
                // Redirect to login page after successful registration with ollyo_EMS prefix
                header("Location: /ollyo_EMS/login");
                exit();
            } else {
                echo "Registration failed.";
            }
        } else {
            include "views/auth/register.php";
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $userModel = new User();
            $user = $userModel->getUserByEmail($email);

            // Check if user exists and if password matches
            if ($user && password_verify($password, $user["password"])) {
                // Start the session only if it's not already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Set session variables for user
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                // Redirect to events page after successful login with ollyo_EMS prefix
                header("Location: /ollyo_EMS/events");
                exit();
            } else {
                echo "Invalid login credentials.";
            }
        } else {
            include "views/auth/login.php";
        }
    }
}
