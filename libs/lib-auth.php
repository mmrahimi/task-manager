<?php

function getCurrentUserId()
{
    return $_SESSION['login']->id ?? 0;
}

function logout()
{
    unset($_SESSION['login']);
}

function login($email, $password)
{
    $user = getUserByEmail($email);

    if (is_null($user)) {
        return false;
    }

    if (password_verify($password, $user->password)) {
        $_SESSION['login'] = $user;
        return true;
    }

    return false;
}

function getLoggedInUser()
{
    return $_SESSION['login'] ?? null;
}

function register($userData)
{
    global $pdo;
    $passwordHash = password_hash($userData['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name,email,password) values (:name,:email,:password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":name" => $userData['username'], ":email" => $userData['email'], ":password" => $passwordHash]);
    return (bool)$stmt->rowCount();
}

function isLoggedIn()
{
    return isset($_SESSION['login']);
}

function getUserByEmail($email)
{
    global $pdo;
    $sql = "SELECT * from users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records[0] ?? null;
}
