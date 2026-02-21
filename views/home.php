<?php

use TaskManager\Helpers\TaskViewHelper;

require_once __DIR__ . "/header-html.php";
require_once __DIR__ . "/aside-html.php";
?>
    <main>
        <?php if(!empty($taskList)): ?>
        <ul class="task-list">
            <?php foreach($taskList as $task): ?>
                <li class="task-item">
                    <div class="task-header">
                        <h2 class="task-title" title="<?= $task->title ?>"><?= $task->title ?></h2>
                        <a href="/conclude-task?id=<?= $task->id ?>" class="conclude-task">
                            <img src="img/pendent-task.png" width="20px" height="25px" alt="" class="task-status-icon" title="Concluir tarefa">
                        </a>
                    </div>
                    <p class="task-date">Data de entrega: <?= TaskViewHelper::formattedDate($task->date) ?> - <?= TaskViewHelper::renderStatus($task->displayStatus()) ?></p>
                    <p class="task-description" title="<?= $task->description ?>"><?= $task->description ?></p>
                    <div class="button-container">
                        <a href="/remove-task?id=<?= $task->id ?>" class="task-button" id="remove-button">Remover</a>
                        <a href="/edit-task?id=<?= $task->id ?>" class="task-button" id="conclude-button">Editar</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p class="task-list-empty">Nenhuma tarefa encontrada!</p>
        <?php endif; ?>
    </main>
<?php require_once __DIR__ . "/footer-html.php";