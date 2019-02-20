<?php

// test db server
$server = '127.0.0.1';
$username = 'root';
$password = '';
$db = 'test';

$mysqli = mysqli_connect($server, $username, $password, $db);
if ($mysqli->connect_error) {
  die("Error!");
}

function insertDB($input) {
    for ($i=0; $i < count($input) ;$i++) {
        // create table test (y int, x int, text text);
        $sql = 'insert into test values ';
        for ($j=0; $j < count($input[$i]) ;$j++) {
            $mysqli->query("$sql ($i,$j," . $input[$i][$j] . ");");
        }
    }
}

insertDB([["Hello", "World"]]);

$mysqli->close();

?>
