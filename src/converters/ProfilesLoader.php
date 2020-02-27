<?php

namespace TaskForce\converters;

$result = [];
$file = new \SplFileObject('data/profiles.csv');

$file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY );

list($address, $bd, $about, $phone, $skype) = $file->fgetcsv();
while (!$file->eof()) {
    list($userAddress, $birthday, $aboutUser, $phoneUser, $skypeUser) = $file->fgetcsv();
    if (!empty($userAddress)) {
        $result[] = [
            "$address" => $userAddress,
            "$bd" =>  $birthday,
            "$about" =>  $aboutUser,
            "$phone" => $phoneUser,
            "$skype" => $skypeUser
        ];
    }

}

$user_id = 0;
$header = "USE mydb;\n";
file_put_contents('src/converters/profiles.sql', $header, FILE_APPEND);
foreach ($result as $item) {
    $city_id = random_int(1,10);
    $user_id += 1;
    $insert = "INSERT INTO profiles SET address = '{$item[$address]}',
            birthday = '{$item[$bd]}', city_id = $city_id, user_id = $user_id,
            about = '{$item[$about]}', phone_number = '{$item[$phone]}', skype = '{$item[$skype]}' ;\n";
    file_put_contents('src/converters/profiles.sql', $insert, FILE_APPEND);
}
