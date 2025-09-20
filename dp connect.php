<?php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);

   $host = 'localhost'; // Update if your host uses a different MySQL server
   $dbname = 'db8hcpfk0p8w38';
   $username = 'ubpkik01jujna';
   $password = 'f0ahnf2qsque';

   $conn = mysqli_connect($host, $username, $password, $dbname);

   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   ?>
