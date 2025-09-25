<?php

include __DIR__ . "/bootstrap/init.php";

if (isset($_GET['logout'])) {
    logout();
}

if (!isLoggedIn()) {
    header("location: auth.php");
}

if (isset($_GET['delete_folder']) && is_numeric($_GET['delete_folder'])) {
    deleteFolders($_GET['delete_folder']);
}

if (isset($_GET['delete_task']) && is_numeric($_GET['delete_task'])) {
    deleteTasks($_GET['delete_task']);
}

$folders = getFolders($_GET['search'] ?? null);

$tasks = getTasks();

include __DIR__ . "/tpl/tpl-index.php";
