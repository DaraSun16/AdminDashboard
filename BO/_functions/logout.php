<?php

session_start();
unset($_SESSION['auth']);

header('Location: /BO/_views/login.php');
exit();

?>