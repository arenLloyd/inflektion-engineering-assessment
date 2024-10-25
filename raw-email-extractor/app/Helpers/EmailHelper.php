<?php

namespace App\Helpers;

class EmailHelper
{
    public static function extractPlainText($rawContent)
    {
        $plainText = strip_tags($rawContent);

        $plainText = preg_replace('/[^\P{C}]+/u', '', $plainText);

        $plainText = preg_replace('/\r\n|\r|\n/', "\n", $plainText);

        return trim($plainText);
    }
}
