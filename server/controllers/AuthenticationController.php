<?php

namespace reddit_clone\controllers;

use reddit_clone\services\AuthenticationService;

/**
 * Class UserController
 *
 * @package reddit_clone\controllers
 */
class AuthenticationController
{
    /**
     * @var \reddit_clone\services\UserService
     */
    private $authenticationService;

    function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    /**
     * Gets a user.
     *
     * @param array $parameters
     *
     * @return string|null
     */
    public function getUser(array $parameters)
    {
        $username = $parameters['username'];
        $user = $this->userService->getUserByUsername($username);

        if (is_null($user))
        {
            header('Content-Type: application/json');
            return null;
        }

        http_response_code(200);
        header('Content-Type: application/json');
        return json_encode($user->toArray());
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->authenticationService->getUser($username, $password);
        if(!is_null($user)) {
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            // print_r($_SESSION);
            http_response_code(200);
            return json_encode($_SESSION);
        } else {
            http_response_code(403);
            return "Invalid credentials";
        }

    // print_r($user);

    }

    public function signup() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email =    $_POST['email'];

        if(empty($username) || empty($password) || empty($email)) {
            http_response_code(400);
            return "Bad Request";
        }

        $success = $this->authenticationService->signupUser($username, $password, $email);
        if($success) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = 0;
            // print_r($_SESSION);
            http_response_code(200);
            return json_encode($_SESSION);
        } else {
            http_response_code(409);
            return "User already exists";
        }

    // print_r($user);

    }

    public function authenticate() {
        session_start();
        if(isset($_SESSION['username'])) {
            http_response_code(200);
            return json_encode($_SESSION);
        } else {
            http_response_code(404);
            return;
        }

    }

    public function logout() {
        session_start();
        session_destroy();
    }

}
