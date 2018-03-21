<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Garanhoes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Services\FieldsValidations;

class GaranhoesController extends Controller {

    /**
     * @Route("/garanhoes/{action}", name="garanhoes", defaults={"action":null, "id":null})
     * @Route("/garanhoes/{action}/{id}", name="garanhoes", defaults={"action":null, "id":null})
     */
    public function indexAction(Request $request, $action, $id) {

        switch ($action) {
            case 'alterar':
                $data = $this->alterar($request, $id);
                $uri = $this->generateUrl('garanhoes', array('search' => $data['search']));
                return $this->redirect($uri, 302);
                break;

            case 'incluir':

                $data = $this->incluir($request);
                $uri = $this->generateUrl('garanhoes', array('search' => $data['search']));
                return $this->redirect($uri, 302);

                break;

            case 'formIncluir':

                return $this->render('default/garanhoes.html.twig', $this->formIncluir($request));

                break;

            case 'formAlterar':

                return $this->render('default/garanhoes.html.twig', $this->formAlterar($request, $id));

                break;

            default:
                return $this->render('default/garanhoes.html.twig', $this->listAction($request));
                break;
        }
    }

    public function listAction($request) {

        $garanhoes = $this->getDoctrine()->getRepository(Garanhoes::class);
        $garanhoes = $garanhoes->createQueryBuilder('garanhao');
        $data['search'] = '';
        if (trim($request->request->get('search')) != '') {
            $search = $request->request->get('search');
            $garanhoes = $garanhoes
                    ->where('garanhao.nome like :nome')
                    ->setParameter('nome', '%' . $search . '%');
            $data['search'] = $search;
        }
        $data['garanhoes'] = $garanhoes->getQuery()->getResult();
        $data['typeForm'] = 'lista';
        return $data;
    }

    public function alterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $garanhoesClass = $em->getRepository(Garanhoes::class)->find($id);
        $form = $this->createFormBuilder($garanhoesClass)
                ->add('nome', TextType::class)
                ->add('registro', TextType::class, array('required' => false))
                ->add('valorArrecadado', TextType::class, array('required' => false))
                ->add('arvoreGenealogica', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $dataGaranhoes = $form->getData();
        $garanhoesClass->setNome($dataGaranhoes->getNome());
        $garanhoesClass->setRegistro($dataGaranhoes->getRegistro());
        $garanhoesClass->setValorArrecadado(FieldsValidations::numericToSave($dataGaranhoes->getValorArrecadado()));
        $garanhoesClass->setArvoreGenealogica($dataGaranhoes->getArvoreGenealogica());
        $garanhoesClass->setAtivo(1);
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataGaranhoes->getNome();
        return $data;
    }

    public function formAlterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $garanhoesClass = $em->getRepository(Garanhoes::class)->find($id);
        $form = $this->createFormBuilder($garanhoesClass)
                ->add('nome', TextType::class)
                ->add('registro', TextType::class, array('required' => false))
                ->add('valorArrecadado', TextType::class, array('required' => false))
                ->add('arvoreGenealogica', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $dataGaranhoes = $form->getData();
        $form->get('valorArrecadado')->setData(FieldsValidations::numericToView($dataGaranhoes->getValorArrecadado()));
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

    public function incluir($request) {
        $garanhoesClass = new Garanhoes();
        $form = $this->createFormBuilder($garanhoesClass)
                ->add('nome', TextType::class)
                ->add('registro', TextType::class, array('required' => false))
                ->add('valorArrecadado', TextType::class, array('required' => false))
                ->add('arvoreGenealogica', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        
        $form->handleRequest($request);
        $dataGaranhoes = $form->getData();
        $garanhoesClass->setNome($dataGaranhoes->getNome());
        $garanhoesClass->setRegistro($dataGaranhoes->getRegistro());
        $garanhoesClass->setValorArrecadado(FieldsValidations::numericToSave($dataGaranhoes->getValorArrecadado()));
        $garanhoesClass->setArvoreGenealogica($dataGaranhoes->getArvoreGenealogica());  
        $garanhoesClass->setAtivo(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($garanhoesClass);
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataGaranhoes->getNome();
        return $data;
    }

    public function formIncluir($request) {
        $garanhoesClass = new Garanhoes();
        $form = $this->createFormBuilder($garanhoesClass)
                ->add('nome', TextType::class)
                ->add('registro', TextType::class, array('required' => false))
                ->add('valorArrecadado', TextType::class, array('required' => false))
                ->add('arvoreGenealogica', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $dataGaranhoes = $form->getData();        
        $form->get('valorArrecadado')->setData(FieldsValidations::numericToView($dataGaranhoes->getValorArrecadado())); 
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

}
