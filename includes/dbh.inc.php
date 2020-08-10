<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "daily_feed";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Spojení selhalo: " . mysqli_connect_error());
}

/*CREATE TABLE currancy (
	id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    currancy varchar(4) not null,
    rate int(10) not null,
    ammount int(4) not null,
    country varchar(100) not null
);*/