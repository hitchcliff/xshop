<?php

$conn = new mysqli("localhost", "root", '', "xshop");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}