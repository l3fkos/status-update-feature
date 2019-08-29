<?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "signwerks";

  $link = mysqli_connect($servername, $username, $password, $dbname);
  if(!$link){
    die("connection error " . mysqli_connect_error());
  }
