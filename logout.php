<?php

include 'app/main.php';
session_destroy();
redirect('index.php');