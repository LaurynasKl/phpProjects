<?php


$name = readline('vardas: ');
echo $name;


function add(){

    $file = __DIR__ . "/data/expenses.json";

    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }
    $file = json_decode(file_get_contents($file), true);
    

}
echo add();
