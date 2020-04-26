<?php


namespace TaskForce\converters;

$result = [];
$file = new \SplFileObject('data/categories.csv');

$file->setFlags(\SplFileObject::READ_CSV |  \SplFileObject::SKIP_EMPTY );
list($name, $ico) = $file->fgetcsv();
while (!$file->eof()) {
    list($category, $icoName) = $file->fgetcsv();
    if (!empty($category)) {
        $result[] = [
            "$name" => $category,
            "$ico" =>  $icoName
        ];
    }

}

$header = "USE mydb;\n";
file_put_contents('src/converters/categories.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $insert = "INSERT INTO categories SET name = '{$item[$name]}', ico = '{$item[$ico]}';\n";
    file_put_contents('src/converters/categories.sql', $insert, FILE_APPEND);
}
