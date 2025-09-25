<?php

function getTasks()
{
    global $pdo;
    $folderId = $_GET['folder_id'] ?? null;
    $currentUserId = getCurrentUserId();

    $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
    $params = [":user_id" => $currentUserId];

    if (isset($folderId) && is_numeric($folderId)) {
        $sql .= " AND folder_id = :folder_id";
        $params[":folder_id"] = $folderId;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addTasks($name, $folderId)
{
    global $pdo;
    $userId = getCurrentUserId();
    $sql = "INSERT INTO tasks (user_id, name, folder_id) VALUES (:user_id, :name, :folder_id)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([":user_id" => $userId, ":name" => $name, ":folder_id" => $folderId]);
    return $success ? $pdo->lastInsertId() : 0;
}

function deleteTasks($id)
{
    global $pdo;
    $sql = "DELETE FROM tasks WHERE id = :task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":task_id" => $id]);
    return $stmt->rowCount();
}

function doneSwitch($id)
{
    global $pdo;
    $sql = "UPDATE tasks SET status = 1 - status WHERE id = :task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":task_id" => $id]);
    return $stmt->rowCount();
}
