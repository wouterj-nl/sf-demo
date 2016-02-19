<?php

namespace App\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getPath()
    {
        return dirname(__DIR__);
    }
}
