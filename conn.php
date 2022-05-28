<?php
//connection
$con=mysqli_connect("localhost","root","","fuzifilm");
session_start();
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>