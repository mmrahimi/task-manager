<?php

include __DIR__ . "/bootstrap/init.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $homeURL = site_url();
    $action = $_GET['action'];
    $userData = $_POST;

    if ($action == 'register') {
        $result = register($userData);
        if (!$result) {
            dd("an error occured in your registration");
        }

        redirect(site_url("auth.php"));
    } elseif ($action == 'login') {
        $result = login($userData['email'], $userData['password']);
        if (!$result) {
            dd("an error occured in your login");
        } else {
            redirect(site_url());
        }
    }
}

include __DIR__ . "/tpl/tpl-auth.php";
