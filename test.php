<?php

$url = 'api.openweathermap.org/data/2.5/forecast?q=Karlovy%20Vary&appid=f8fa03f5613b0c792687f1c95cc397b4&mode=json&units=metric';
$weather = file_get_contents($url);
//$weather = json_decode(file_get_contents('api.openweathermap.org/data/2.5/forecast?q=Karlovy%20Vary&appid=f8fa03f5613b0c792687f1c95cc397b4&mode=json&units=metric'), true);
print_r($weather);
