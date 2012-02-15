<?php

    include_once(dirname(__FILE__) . '/config/config.ini.php');
   
    $login = new Login();
    $login->logout();
    header('Location: ' . BASE_URL);