<?php

$dbServername = "md33.wedos.net";
$dbUsername = "w204059_df";
$dbPassword = "6cS2C3hW";
$dbName = "d204059_df";

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