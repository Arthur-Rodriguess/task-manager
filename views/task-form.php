<?php
/** @var \TaskManager\Model\Entity\Task|null $task */
require_once __DIR__ . "/header-html.php"; ?>
<?php require_once __DIR__ . "/aside-html.php"; ?>
    <main>
        <h1 class="form-title">Escreva a sua tarefa!</h1>
        <form class="form" method="post">
            <input type="text" name="title" id="title" placeholder="Qual a sua tarefa?" maxlength="30" value="<?= $task->title ?? ''?>" required>
            <input type="text" name="description" id="description" placeholder="Como você descreveria ela?" minlength="3" maxlength="100" value="<?= $task->description ?? ''?>" required>
            <input type="datetime-local" name="date" id="date" value="<?= $task->date ?? ''?>" required>
            <input type="hidden" name="status" value="<?= $task?->getStatus()?->value ?? ''?>">
            <input type="hidden" name="id" value="<?= $task->id ?? ''?>">
            <input type="submit" value="ENVIAR" id="submit-button">
        </form>
    </main>
<?php require_once __DIR__ . "/footer-html.php";