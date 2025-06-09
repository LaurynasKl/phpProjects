<?php

function cli($argc)
{
    if ($argc < 2) {
        echo "Naudojimas:\n";
        echo "php task.php add \"užduoties tekstas\"\n";
        echo "php task.php list\n";
        echo "php task.php done [numeris]\n";
    }
};
cli($argc);


function add($argv)
{
    $file = __DIR__ . '/data/tasks.json';

    if (!file_exists($file)) {
        file_put_contents(__DIR__ . '/data/tasks.json', json_encode([], JSON_PRETTY_PRINT));
    }

    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

    $taskId = 1;
    foreach ($tasks as $task) {
        if ($task['id'] >= $taskId) {
            $taskId++;
        }
    }
    $tasks[] = [
        'id' => $taskId,
        'task' => $argv[1],
        'status' => 'in-progress'
    ];
    file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    // print_r($tasks);
}
// add($argv);

function allTasks()
{
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

    foreach ($tasks as $task) {
        echo 'ID: ' . $task['id'] . ' TASK: ' . $task['task'] .  ' STATUS: ' . $task['status'] . "\n";
    }
}
// allTasks();


function oneTask($argv){
    $tasks = json_decode(file_get_contents(__DIR__ . '/data/tasks.json'), true);

}
oneTask($argv);