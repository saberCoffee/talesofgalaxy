<?php

namespace ToG\RolePlayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ToGRolePlayBundle:Default:index.html.twig');
    }
}
