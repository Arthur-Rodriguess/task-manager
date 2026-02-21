<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <header>
        <a href="/" class="header-link">
            <img src="img/task-manager-logo.png" alt="header logo" width="50" class="header-logo">
            <h1 class="header-title">TASK<br>MANAGER</h1>
        </a>
        <?php if(!empty($_SESSION['user'])): ?>
            <div class="header-actions">
                <a href="/new-task" class="new-task-link">
                    <img src="img/new-task.png" alt="new task icon" width="35">
                </a>
                <div class="user-menu">
                    <button id="userToggle" class="user-toggle">
                        <img src="img/avatar.png" alt="avatar" width="42">
                        <span class="user-name"><?= $_SESSION['user']->name?></span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </header>