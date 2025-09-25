<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task manager UI</title>
    <link rel="stylesheet" href="<?= site_url("assets/css/style.css") ?>">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="page">
    <div class="pageHeader">
        <div class="title">Dashboard</div>
        <div class="userPanel">
            <a href="<?= site_url("?logout=true") ?>"><i class="fa fa-sign-out"></i></a>
            <span class="username"><?= getLoggedInUser()->name ?></span></div>
    </div>
    <div class="main">
        <div class="nav">
            <div class="searchbox">
                <form action="<?=site_url()?>" method="get">
                <div><i class="fa fa-search"></i>
                    <input autocomplete="off" name="search" type="text" placeholder="ُSearch">
                </div>
                </form>
            </div>
            <div class="menu">
                <div class="title">Folders</div>
                <ul class="folder-list">
                    <li class="<?= (isset($_GET['folder_id']) && is_numeric($_GET['folder_id'])) ? '' : 'active' ?>">
                        <a href="<?= site_url() ?>"><i class="fa fa-folder"></i>All</a>
                    </li>
                    <?php foreach ($folders as $folder): ?>
                        <li class="<?= (isset($_GET['folder_id']) && $_GET['folder_id'] == $folder->id) ? 'active' : '' ?>">
                            <a href=?folder_id=<?= $folder->id ?>><i class="fa fa-folder"></i><?= $folder->name ?></a>
                            <a class="remove" href=?delete_folder=<?= $folder->id ?>
                               onclick="return confirm('Are you sure to delete this item?\n<?= $folder->name ?>')">x</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <input type="text" id="addFolderInput" placeholder="Add a new folder..."
                   style="width: 65%; margin-left: 8px;">
            <button class="btn" id="addFolderBtn" style="cursor: pointer;">+</button>
        </div>
        <div class="view">
            <div class="viewHeader">
                <div class="title" style="width: 50%;">
                    <input type="text" id="addTaskInput" placeholder="Add a new task..."
                           style="width: 65%; margin-left: 8px;">
                </div>
                <div class="functions">
                    <div class="button active">Add New Task</div>
                </div>
            </div>
            <div class="content">
                <div class="list">
                    <div class="title">Today</div>
                    <ul class="task-list">
                        <?php if (!is_null($tasks)): ?>
                            <?php foreach ($tasks as $task): ?>
                                <li class="<?= $task->status ? 'checked' : ''; ?>">
                                    <i data-taskId="<?= $task->id ?>"
                                       class="status <?= $task->status ? 'fa fa-check-square-o' : 'fa fa-square-o'; ?>"></i>
                                    <span><?= $task->name ?></span>
                                    <div class="info">
                                        <span class="created-at">CREATED AT <?= $task->created_at ?></span>
                                        <a class="remove" href=?delete_task=<?= $task->id ?>
                                           onclick="return confirm('Are you sure to delete this item?\n<?= $task->name ?>')">x</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li> No task is added...
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- partial -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
    $(document).ready(function () {
        $("#addFolderBtn").click(function (e) {
            var input = $("#addFolderInput");
            $.ajax({
                url: "<?=BASE_URL?>process/ajaxHandler.php",
                method: "post",
                data: {action: "addFolder", folder_name: input.val()},
                success: function (response) {
                    if (!isNaN(response)) {
                        $('<li><a href="?folder_id=' + response + '"><i class="fa fa-folder"></i>' + input.val() + '</a></li>').appendTo(".folder-list");
                        input.val('');
                    } else {
                        alert(response);
                    }
                }
            });
        });
    });

    $('#addTaskInput').on('keypress', function (e) {
            if (e.which === 13) {
                $.ajax({
                    url: "<?=BASE_URL?>process/ajaxHandler.php",
                    method: "post",
                    data: {action: "addTask", folder_id: <?= $_GET['folder_id'] ?? 0?>, task_name: $('#addTaskInput').val()},
                    success: function (response) {
                        if (!isNaN(response)) {
                            location.reload();
                        } else {
                            alert(response);
                        }
                    }
                });
                $('#addTaskInput').focus();
            }
        }
    );

    $(".status").click(function (e) {
        var tid = $(this).attr('data-taskId');
        $.ajax({
            url: "<?=BASE_URL?>process/ajaxHandler.php",
            method: "post",
            data: {action: "doneSwitch", task_id: tid},
            success: function (response) {
                if (!isNaN(response)) {
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    })
</script>
</body>
</html>