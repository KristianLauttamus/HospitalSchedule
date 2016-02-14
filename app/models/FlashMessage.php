<?php

class FlashMessage
{
    public function create($title = null, $message = null, $type = "success", $overlay = false, $timer = 1700)
    {
        if (func_num_args() == 0) {
            return $this;
        }

        $alert            = array();
        $alert['title']   = $title;
        $alert['message'] = $message;
        $alert['type']    = $type;
        $alert['overlay'] = $overlay;
        $alert['timer']   = $timer;

        $_SESSION['alert'] = $alert;
    }
    public function error($title = null, $message = null)
    {
        return $this->create($title, $message, "error");
    }
}
