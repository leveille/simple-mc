<?php

if(!$_SESSION['isAdmin'] && !$_SESSION['isEditor']) die('Access Denied');