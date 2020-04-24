<?php

namespace TaskForce\converters;

$result = [];
$file = new \SplFileObject('data/opinions.csv');

$file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY );

list($dt_add, $rate, $review) = $file->fgetcsv();
while (!$file->eof()) {
    list($date_add, $rating, $text) = $file->fgetcsv();
    if (!empty($date_add)) {
        $result[] = [
            "$dt_add" => $date_add,
            "$rate" =>  $rating,
            "$review" =>  $text
        ];
    }

}

$header = "USE mydb;\n";
file_put_contents('src/converters/reviews.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $user_id = random_int(1,20);
    $insert = "INSERT INTO reviews SET review = '{$item[$review]}', rating = '{$item[$rate]}',
                user_id = $user_id, date_add = '{$item[$dt_add]}';\n";
    file_put_contents('src/converters/reviews.sql', $insert, FILE_APPEND);
}
