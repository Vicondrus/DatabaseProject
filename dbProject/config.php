<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "root";
$password   = "Testoasa3125@otto";
$dbname     = "pizzeriad'autore"; // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
