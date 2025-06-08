<?php


// if ($argc < 2) {
//     echo 'Nieko neivesta';
// }

function cli($cli)
{
    if ($cli[0]) {
        echo "Naudojimas:\n";
        echo "php task.php add \"užduoties tekstas\"\n";
        echo "php task.php list\n";
        echo "php task.php done [numeris]\n";
    }
};
$cli = $argv;
cli($cli);


// function add()
// {
//     $tasks = ['id' => 1, 'task' => 'sukurti web', 'status' => 'in-progress'];
//     file_put_contents(__DIR__ . '/data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
// }
// add();
// sutvarkyti kad patikrintu ar failas jau sukurtas ar dar ne
