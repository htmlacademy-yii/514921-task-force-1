<?php


namespace TaskForce\converters;

$result = [];
$file = new \SplFileObject('data/replies.csv');

$file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY );

list($dt_add, $rate, $description) = $file->fgetcsv();
while (!$file->eof()) {
    list($date_add, $rating, $text) = $file->fgetcsv();
    if (!empty($date_add)) {
        $result[] = [
            "$dt_add" => $date_add,
            "$rate" =>  $rating,
            "$description" =>  $text
        ];
    }

}


$header = "USE mydb;\n";
file_put_contents('src/converters/replies.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $task_id = random_int(1,10);
    $user_id = random_int(1,20);
    $insert = "INSERT INTO replies SET description = '{$item[$description]}', rating = '{$item[$rate]}',
                task_id = $task_id, user_id = $user_id, date_add = '{$item[$dt_add]}';\n";
    file_put_contents('src/converters/replies.sql', $insert, FILE_APPEND);
}
