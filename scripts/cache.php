<?php

require '../includes/dbh.inc.php';

// Nameday

$nameday = file_get_contents('https://svatky.adresa.info/json');
$nameday = json_decode($nameday, true);
$namedayName = array(
    'name' => $nameday[0]['name']
);
$fileContent = file_get_contents('../nameday.json');
$fileContent = json_decode($fileContent, true);
print_r($fileContent);
$fileContent[0]["name"] = $nameday[0]['name'];
array_push($fileContent, $namedayName);
file_put_contents("../nameday.json", json_encode($fileContent, true));
/*$namedayFile = fopen('../nameday.json', 'w') or die("Unable to open file");
fwrite($namedayFile, '{"name" : "'.$nameday[0]['name'].'"}');
fclose($namedayFile);*/

// Holiday

$holiday = json_decode(file_get_contents('https://date.nager.at/api/v2/publicholidays/2020/CZ'), true);
$holidayDate_now = date('Y-m-d');

$i = false;

foreach ($holiday as $val) {
    if ($holidayDate_now == $val['date']) {
        $holidayTrue = array(
            'holiday' => true
        );
        $fileContent = file_get_contents('../nameday.json');
        $fileContent = json_decode($fileContent, true);
        array_push($fileContent, $holidayTrue);
        file_put_contents("../nameday.json", json_encode($fileContent, true));
        $i = false;
    } else {
        $i = true;
    }
}

if($i = true) {
    $holidayTrue = array(
        'holiday' => false
    );
    $fileContent = file_get_contents('../nameday.json');
    $fileContent = json_decode($fileContent, true);
    array_push($fileContent, $holidayTrue);
    file_put_contents("../nameday.json", json_encode($fileContent, true));
}


// Covid

// Podcasty

// Jidelna

// Currancy
    // USD
    //EUR

// News
    // iRozhlas
    // The Verge