<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|-------------------------------------------------
| SET FLASH MESSAGE
|-------------------------------------------------
*/
function flash($type, $title, $message){
    $_SESSION['flash'] = [
        'type' => $type,     // success | error | warning | info
        'title' => $title,
        'message' => $message
    ];
}