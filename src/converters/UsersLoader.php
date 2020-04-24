<?php


namespace TaskForce\converters;

$result = [];

$file = new \SplFileObject('data/users.csv');

$file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY );

list($email, $name, $password, $dateAdd) = $file->fgetcsv();
while (!$file->eof()) {
    list($userEmail,$userName, $UserPassword, $dt_add) = $file->fgetcsv();
    if (!empty($userEmail)) {
        $result[] = [
            "$email" => $userEmail,
            "$name" =>  $userName,
            "$password" =>  $UserPassword,
            "$dateAdd" => $dt_add
        ];
    }

}

$header = "USE mydb;\n";
file_put_contents('src/converters/users.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $city_id = random_int(1,10);
    $insert = "INSERT INTO users SET email = '{$item[$email]}',
            name = '{$item[$name]}', city_id = $city_id,
            password = '{$item[$password]}', date_add = '{$item[$dateAdd]}' ;\n";
    file_put_contents('src/converters/users.sql', $insert, FILE_APPEND);
}
