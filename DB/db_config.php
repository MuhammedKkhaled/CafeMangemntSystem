<?php


const HOST_NAME = "localhost";
const USER_NAME = "root";
const PASSWORD = '';
const  DATABASE_NAME = "benha_cafe";

$conn = mysqli_connect(HOST_NAME, USER_NAME, PASSWORD, DATABASE_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
