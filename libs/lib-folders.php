<?php

function getFolders($search = null)
{
    global $pdo;
    $currentUserId = getCurrentUserId();
    $sql = "SELECT * FROM folders WHERE user_id = :user_id";
    $params = [":user_id" => $currentUserId];

    if (!is_null($search)) {
        $sql .= " AND name LIKE :name";
        $params[":name"] = "%$search%";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addFolders($name)
{
    global $pdo;
    $getCurrentUserId = getCurrentUserId();
    $sql = "INSERT INTO folders (user_id,name) values(:user_id,:name)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":user_id" => $getCurrentUserId, ":name" => "$name"]);
    return $pdo->lastInsertId();
}

function deleteFolders($id)
{
    global $pdo;
    $sql = "DELETE FROM folders WHERE id = $id";
    $stmt = $pdo->query($sql);
    $stmt->execute();
    return $stmt->rowCount();
}
