<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getPath()
    {
        // A path to the bundle is often used to reference resources
        // (e.g. routing config). As resources/ and src/ are split in
        // this bundle, it makes more sense to default to the directory
        // containing both resources/ and src/ (which is the parent dir).
        return dirname(__DIR__);
    }
}
