<?php


namespace TaskForce\converters;

$result = [];
$file = new \SplFileObject('data/tasks.csv');

$file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY );

$head = $file->fgetcsv();
while (!$file->eof()) {
    list($date_add,$category_id,$description, $expire,
        $name, $address, $budget, $latitude, $longitude) = $file->fgetcsv();
    if (!empty($category_id)) {
        $result[] = [
            "$head[0]" =>  $date_add,
            "$head[1]" => $category_id,
            "$head[2]" =>  $description,
            "$head[3]" =>  $expire,
            "$head[4]" =>  $name,
            "$head[5]" =>  $address,
            "$head[6]" =>  $budget,
            "$head[7]" =>  $latitude,
            "$head[8]" => $longitude
        ];
    }

}

$header = "USE mydb;\n";
file_put_contents('src/converters/tasks.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $city_id = random_int(1,10);
    $insert = "INSERT INTO tasks SET name = '{$item[$head[4]]}',
            description = '{$item[$head[2]]}', category_id = {$item[$head[1]]},
            city_id = $city_id, budget = {$item[$head[6]]}, date_expire = '{$item[$head[3]]}', date_add = '{$item[$head[0]]}',
            address = '{$item[$head[5]]}', coordinates = ST_PointFromText('POINT({$item[$head[7]]} {$item[$head[8]]})');\n";
    file_put_contents('src/converters/tasks.sql', $insert, FILE_APPEND);
}
