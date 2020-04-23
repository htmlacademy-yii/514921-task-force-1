<?php


namespace TaskForce\converters;


$result = [];
$file = new \SplFileObject('data/cities.csv');

$file->setFlags(\SplFileObject::READ_CSV |  \SplFileObject::SKIP_EMPTY );
list($city, $lat , $long) = $file->fgetcsv();
while (!$file->eof()) {
    list($name, $latitude , $longitude) = $file->fgetcsv();
    if (!empty($name)) {
        $result[] = [
            "$city" => $name,
            "$lat" =>  $latitude,
            "$long" => $longitude
        ];
    }
}

$header = "USE mydb;\n";
file_put_contents('src/converters/cities.sql', $header, FILE_APPEND);
    foreach ($result as $item) {
    $insert = "INSERT INTO cities SET name = '{$item[$city]}', coordinates = ST_PointFromText('POINT({$item[$lat]} {$item[$long]})');\n";

    file_put_contents('src/converters/cities.sql', $insert, FILE_APPEND);
}
