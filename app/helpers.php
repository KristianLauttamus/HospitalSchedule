<?php
function flash($title = null, $message = null)
{
    $flash = new FlashMessage;
    if ($title == null && $message == null) {
        return $flash->create();
    }
    return $flash->create($title, $message);
}
