<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function indexAction(Request $request)
    {
        $uri = $this->generateUrl('pesquisa');
        return $this->redirect($uri, 302);
    }
    
    /**
     * @Route("/admin/")
     */
    public function admin()
    {
//        dump($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'));
//        die;
        
        return new Response('<html><body>Admin page!</body></html>');
    }
    /**
     * @Route("/admin/login")
     */
    public function login()
    {
//        dump($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'));
//        die;
        
        return new Response('<html><body>Admin page!</body></html>');
    }
}
