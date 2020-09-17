<?php

require './includes/dbh.inc.php';
session_start();

// Nameday

$nameday = file_get_contents('https://svatky.adresa.info/json');
$nameday = json_decode($nameday, true);

$fileContent = file_get_contents('nameday.json');
$fileContent = json_decode($fileContent, true);
print_r($fileContent);
//print_r($fileContent);
//echo '<br>';
//echo 'holiday: ' . $fileContent["properties"]['holiday'];
//echo '<br>';
$fileContent["properties"]['nameday'] = $nameday[0]['name'];
$fileContent["properties"]['holiday'] = false;
//echo 'nameday: ' . $fileContent["properties"]['nameday'];
//echo '<br>';
print_r($fileContent);

$_SESSION['counter'];
$_SESSION['counter']++;
echo $_SESSION['counter'];


/*if (!isset($_SESSION['reload-cache'])) {
    $_SESSION['reload-cache'] = 0;
    echo 'innnno: ' . $_SESSION['reload-cache'];
}*/
/*if (!isset($_COOKIE['reload-cache'])) {
    setcookie("reload-cache", 0, time() + 10, "/");
    echo 'in Cookie: ' . $_COOKIE['reload-cache'];
}
echo 'out cookie: ' . $_COOKIE['reload-cache'];
if ($_COOKIE['reload-cache'] == 0) {
    //
    $_COOKIE['reload-cache'] = 1;
}*/

$enc = json_encode($fileContent);
echo '<br>';
print_r($enc);
//$jsonFile = fopen("nameday.json", "w");
//fwrite($jsonFile, $enc);
//fclose($jsonFile);

file_put_contents("nameday.json", $enc);

// Holiday

$holiday = json_decode(file_get_contents('https://date.nager.at/api/v2/publicholidays/2020/CZ'), true);
$holidayDate_now = date('Y-m-d');
/*
$i = false;

foreach ($holiday as $val) {
    if ($holidayDate_now == $val['date']) {
        $holidayTrue = array(
            'holiday' => true
        );
        $fileContent = file_get_contents('../nameday.json');
        $fileContent = json_decode($fileContent, true);
        array_push($fileContent, $holidayTrue);
        //file_put_contents("../nameday.json", json_encode($fileContent, true));
        $i = false;
    } else {
        $i = true;
    }
}

if ($i = true) {
    $holidayTrue = array(
        'holiday' => false
    );
    $fileContent = file_get_contents('../nameday.json');
    $fileContent = json_decode($fileContent, true);
    array_push($fileContent, $holidayTrue);
    //file_put_contents("../nameday.json", json_encode($fileContent, true));
}*/


// Covid

// Podcasty

// Jidelna

//? Scrape?

echo '<br>';
echo $urlJidlo = "https://spsostrov.cz/sites/default/files/". date('Y-m/') . "JL_" . (date('d')+1) . '-' . (date('d')+6) . "_" . date('m-Y') . '.pdf';
echo '<br>';
echo date('d');

$url = "https://spsostrov.cz/sites/default/files/2020-09/JL_14-18_09-2020.pdf";
if(date('w') == 0) {
    $urlJidlo = "https://spsostrov.cz/sites/default/files/". date('Y-m/') . "JL_" . (date('d')+1) . '-' . (date('d')+6) . "_" . date('m-Y') . '.pdf';
}

// Currancy
    // USD
    // EUR

// News
    // iRozhlas
    // The Verge