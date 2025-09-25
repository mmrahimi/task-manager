<?php

include __DIR__ . "/../bootstrap/init.php";

if (!isAjaxRequest()) {
    diePage("invalid request!");
}

if (empty($_POST['action'])) {
    diePage("invalid action!");
}

switch ($_POST["action"]) {
    case 'addFolder':
        $folderName = $_POST["folder_name"];

        if (empty($folderName) || strlen($folderName) < 3) {
            echo "The folder name shouldn't be less than 3 characters";
            die();
        } else {
            echo addFolders($folderName);
        }

        break;
    case 'addTask':
        $folderId = $_POST['folder_id'];
        $taskName = $_POST['task_name'];

        if (empty($folderId)) {
            echo "No folder is selected";
            die();
        }

        if (empty($taskName) || strlen($taskName) < 3) {
            echo "The task name shouldn't be less than 3 characters";
            die();
        }

        echo addTasks($taskName, $folderId);
        break;
    case 'doneSwitch':
        $taskId = $_POST['task_id'];

        if (!isset($taskId) || !is_numeric($taskId)) {
            echo "invalid task id";
            die();
        }

        echo doneSwitch($taskId);
        break;
    default:
        diePage("invalid action!");
}
