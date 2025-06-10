<?php

function cli($argc)
{
    if ($argc < 2) {
        echo "Naudojimas:\n";
        echo "php task.php add \"užduoties tekstas\"\n";
        echo "php task.php list\n";
        echo "php task.php oneTask [numeris]\n";
        echo "php task.php delete [numeris]\n";
        echo "php task.php done [numeris]\n";
    }
};

switch ($argv[1]) {
    case 'add':
        add($argv);
        break;

    case 'list':
        listTasks($argv);
        break;

    case 'oneTask':
        oneTask($argv);
        break;

    case 'delete':
        delete($argv);
        break;

    default:
        cli($argc);
        break;
}

function add($argv)
{
    if ($argv[1] === 'add') {
        $file = __DIR__ . '/data/tasks.json';

        if (!file_exists($file)) {
            file_put_contents(__DIR__ . '/data/tasks.json', json_encode([], JSON_PRETTY_PRINT));
        }

        $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

        $newId = 0;
        foreach ($tasks as $task) {
            if ($task['id'] > $newId) {
                $newId = $task['id'];
            }
        }
        $taskId = $newId + 1;

        $tasks[] = [
            'id' => $taskId,
            'task' => $argv[2],
            'status' => 'in-progress'
        ];

        file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
        echo "Task added successfully (id: $taskId)";
    }
}

function listTasks($argv)
{
    if ($argv[1] === 'list') {
        $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

        foreach ($tasks as $task) {
            echo 'ID: ' . $task['id'] . ' TASK: ' . $task['task'] .  ' STATUS: ' . $task['status'] . "\n";
        }
    }
}

// patvarkyti kad jeigu nepasirenki argumento ismestu pranesima kad nepasirinktas id
function oneTask($argv)
{
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);
    $taskFound = false;
    foreach ($tasks as $task) {
        if ($argv[1] === 'oneTask' && $task['id'] == $argv[2]) {
            echo 'ID: ' . $task['id'] . ' TASK: ' . $task['task'] .  ' STATUS: ' . $task['status'] . "\n";
            $taskFound = true;
        }
    }
    if (!$taskFound) {
        echo 'Klaida, tokios uzduoties nera';
        exit();
    }
}
// oneTask($argv);

// patvarkyti kad jeigu nepasirenki argumento ismestu pranesima kad nepasirinktas id
function delete($argv)
{
    if ($argv[1] === 'delete') {
        $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);
        foreach ($tasks as $key => $task) {
            if ($task['id'] === (int)$argv[2]) {
                unset($tasks[$key]);
            }
        }
        $tasks = array_values($tasks);
        file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    }
}
// delete($argv);
