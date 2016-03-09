<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * The actual front-end of the site is managed by ReactJS.
 * Symfony only needs to render the correct template.
 *
 * All other logic (e.g. fetching/creating objects) is done
 * in API methods.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class DashboardController extends Controller
{
    /** @Route("/", name="homepage") */
    public function index()
    {
        return $this->render('dashboard/index.twig');
    }
}
