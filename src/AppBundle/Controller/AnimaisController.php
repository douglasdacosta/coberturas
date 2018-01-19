<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animais;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Services\FieldsValidations;

class AnimaisController extends Controller {

    /**
     * @Route("/animais/{action}", name="animais", defaults={"action":null, "id":null})
     * @Route("/animais/{action}/{id}", name="animais", defaults={"action":null, "id":null})
     */
    public function indexAction(Request $request, $action, $id) {

        switch ($action) {
            case 'alterar':
                $data = $this->alterar($request, $id);
                $uri = $this->generateUrl('animais', array('search' => $data['search']));
                return $this->redirect($uri, 302);
                break;

            case 'incluir':
                $data = $this->incluir($request);
                $uri = $this->generateUrl('animais', array('search' => $data['search']));
                return $this->redirect($uri, 302);

                break;

            case 'formIncluir':
                return $this->render('default/animais.html.twig', $this->formIncluir($request));

                break;

            case 'formAlterar':
                return $this->render('default/animais.html.twig', $this->formAlterar($request, $id));

                break;

            default:
                return $this->render('default/animais.html.twig', $this->listAction($request));
                break;
        }
    }

    public function listAction($request) {
        $animais = $this->getDoctrine()->getRepository(Animais::class);
        $animais = $animais->createQueryBuilder('animal');
        $data['search'] = '';
        if (trim($request->query->get('search')) != '') {
            $search = $request->query->get('search');
            $animais = $animais
                    ->where('animal.nome like :nome')
                    ->setParameter('nome', '%' . $search . '%');
            $data['search'] = $search;
        }
        $data['animais'] = $animais->getQuery()->getResult();
        $data['typeForm'] = 'lista';
        return $data;
    }

    public function alterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $animaisClass = $em->getRepository(Animais::class)->find($id);
        $form = $this->createFormBuilder($animaisClass)
                ->add('nome', TextType::class)
                ->add('idade', TextType::class, array('required' => false))
                ->add('localAnimal', TextType::class, array('required' => false))
                ->add('pelagem', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $dataAnimais = $form->getData();
        $animaisClass->setNome($dataAnimais->getNome());
        $animaisClass->setIdade($dataAnimais->getIdade());
        $animaisClass->setLocalAnimal($dataAnimais->getLocalAnimal());
        $animaisClass->setPelagem($dataAnimais->getPelagem());
        $animaisClass->setAtivo(1);
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataAnimais->getNome();
        return $data;
    }

    public function formAlterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $animaisClass = $em->getRepository(Animais::class)->find($id);
        $form = $this->createFormBuilder($animaisClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('idade', TextType::class, array('required' => false))
                ->add('localAnimal', TextType::class, array('required' => false))
                ->add('pelagem', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

    public function incluir($request) {
        $animaisClass = new Animais();
        $form = $this->createFormBuilder($animaisClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('idade', TextType::class, array('required' => false))
                ->add('localAnimal', TextType::class, array('required' => false))
                ->add('pelagem', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        
        $form->handleRequest($request);
        $dataAnimais = $form->getData();
        $animaisClass->setNome($dataAnimais->getNome());
        $animaisClass->setIdade($dataAnimais->getIdade());
        $animaisClass->setLocalAnimal($dataAnimais->getLocalAnimal());
        $animaisClass->setPelagem($dataAnimais->getPelagem());
        $animaisClass->setAtivo(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($animaisClass);
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataAnimais->getNome();
        return $data;
    }

    public function formIncluir($request) {
        $animaisClass = new Animais();
        $form = $this->createFormBuilder($animaisClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('idade', TextType::class, array('required' => false))
                ->add('localAnimal', TextType::class, array('required' => false))
                ->add('pelagem', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

}
