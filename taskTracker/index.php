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

if ($argc < 2) {
    cli($argc);
} else {
    switch ($argv[1]) {
        case 'add':
            add($argv);
            break;

        case 'update':
            if ($argc >= 4) {
                update($argv);
                break;
            } else {
                echo 'Something wrong';
                break;
            }

        case 'list':
            if ($argv[2] === 'done') {
                taskStatus($argv);
                break;
            }
            if ($argv[2] === 'todo') {
                taskStatus($argv);
                break;
            }
            if ($argv[2] === 'in-progress') {
                taskStatus($argv);
                break;
            }
            if ($argc === 2 && $argc < 3) {
                listTasks($argv);
                break;
            } else {
                echo 'Something wrong';
                break;
            }

        case 'oneTask':
            if ($argc >= 3) {
                oneTask($argv);
                break;
            } else {
                echo 'Klaida';
                break;
            }

        case 'delete':
            if ($argc >= 3) {
                delete($argv);
                break;
            } else {
                echo 'blogai';
                break;
            }
    }
}

function add($argv)
{
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
        'task' => implode(" ", array_splice($argv, 2)),
        'status' => 'todo'
    ];

    file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    echo "Task added successfully (id: $taskId)";
}

function update($argv)
{
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

    foreach ($tasks as $key => $task) {
        if ($argv[1] === 'update' && $task['id'] == $argv[2]) {
            $tasks[$key]['task'] = implode(" ", array_splice($argv, 3));
            echo "Task updates successfully";
        }
    }
    file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

function listTasks($argv)
{
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

    foreach ($tasks as $task) {
        echo 'ID: ' . $task['id'] . ' TASK: ' . $task['task'] .  ' STATUS: ' . $task['status'] . "\n";
    }
}

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

function delete($argv)
{
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);
    $taskDeleted = false;
    foreach ($tasks as $key => $task) {
        if ($argv[1] === 'delete' && $task['id'] === (int)$argv[2]) {
            unset($tasks[$key]);
            $taskDeleted = true;
        }
    }
    if (!$taskDeleted) {
        echo 'Klaida, tokios uzduoties nera';
        exit();
    }
    $tasks = array_values($tasks);
    file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

function taskStatus($argv)
{

    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

    foreach ($tasks as $key => $value) {
        if ($value['status'] === $argv[2]) {
            echo 'ID: ' . $value['id'] . ' TASK: ' . $value['task'] .  ' STATUS: ' . $value['status'] . "\n";
        }
    }
}
