<?php

namespace Lanos\SendgridTenancy;

class SgTen
{

    public static function routes()
    {
        require __DIR__ . '/../routes/senders.php';
    }

}