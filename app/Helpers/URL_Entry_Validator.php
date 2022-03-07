<?php

namespace App\Helpers;

use App\Controllers\BaseController;

class URL_Entry_Validator extends BaseController
{
    public function __construct()
    {
        $regex  = "((https?|ftp)\:\/\/)?";
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
        $regex .= "(\:[0-9]{2,5})?";
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
        $this->regex = $regex;
    }

    public function validate_url(string $s): bool
    {
        return preg_match('/^' . $this->regex . '$/i', $s);
    }
}