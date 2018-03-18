<?php

namespace ToG\RolePlayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ToGRolePlayBundle:Default:index.html.twig');
    }

    /**
     * Renvoie sous forme de json les infos du RP global
     * 
     * @param  Request $request L'objet request
     */
    public function getRPInfosByAjaxAction(Request $request) 
    {
        $rp_infos = [
            'currentDate' => 219
        ];

        return new JsonResponse($rp_infos);
    }    
}
