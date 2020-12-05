<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Template(template="dashboard/index.html.twig")
     */
    public function dashboard()
    {
        return $this->redirectToRoute('product_list');
    }
}
