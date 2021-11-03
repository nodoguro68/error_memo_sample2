<?php

require_once '../utility/utility.php';

$_SESSION = array();
session_destroy();

header('Location: login.php');
