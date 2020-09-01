<?php
    echo "llego";
    session_start();
    session_destroy();
    header('Location: index.php');

?>