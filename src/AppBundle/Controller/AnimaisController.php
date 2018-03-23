<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animais;
use AppBundle\Entity\PessoasAnimais;
use AppBundle\Entity\Pessoas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Services\FieldsValidations;
use AppBundle\Services\HelpersServices;

class AnimaisController extends Controller {

    /**
     * @Route("/animais/{action}", name="animais", defaults={"action":null, "id":null})
     * @Route("/animais/{action}/{id}", name="animais", defaults={"action":null, "id":null})
     */
    public function indexAction(Request $request, $action, $id, HelpersServices $helpersServices) {

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
                return $this->render('default/animais.html.twig', $this->formIncluir($request, $helpersServices));

                break;

            case 'formAlterar':
                return $this->render('default/animais.html.twig', $this->formAlterar($request, $id, $helpersServices));

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
        if (trim($request->request->get('search')) != '') {
            $search = $request->request->get('search');
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
        $data_request = $request->request->get('form');
        
        $em = $this->getDoctrine()->getManager();
        
        $animaisClass = $em->getRepository(Animais::class)->find($id);
        $pessoaClass = $em->getRepository(Pessoas::class)->find($data_request['pessoa']);
        $pessoaAnimaisClass = $em->getRepository(PessoasAnimais::class)->findOneBy(['animal'=>$id]);
        
        
        $animaisClass->setNome($data_request['nome']);
        $animaisClass->setIdade($data_request['idade']);
        $animaisClass->setLocalAnimal($data_request['localAnimal']);
        $animaisClass->setPelagem($data_request['pelagem']);
        $animaisClass->setAtivo(1);
        
        $pessoaAnimaisClass->setPessoa($pessoaClass);
        $pessoaAnimaisClass->setAnimal($animaisClass);
        
        $em->persist($animaisClass);
        $em->persist($pessoaAnimaisClass);
        
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $data_request['nome'];
        return $data;
    }

    public function formAlterar($request, $id, $helpersServices) {
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
       
        $pessoasAnimaisClass = $em->getRepository(PessoasAnimais::class)->findOneBy(['animal'=>$id]);
        
        $data = [];
        $data['pessoas'] = $helpersServices->getPessoas();
        $data['pessoasAnimais'] = $pessoasAnimaisClass;
        $data['form'] = $form->createView();
        return $data;
    }

    public function incluir($request) {
        $animaisClass = new Animais();
        $data_request = $request->request->get('form');
        $em = $this->getDoctrine()->getManager();

        $animaisClass->setNome($data_request['nome']);
        $animaisClass->setIdade($data_request['idade']);
        $animaisClass->setLocalAnimal($data_request['localAnimal']);
        $animaisClass->setPelagem($data_request['pelagem']);
        $animaisClass->setAtivo(1);

        $pessoaClass = $em->getRepository(Pessoas::class)->find($data_request['pessoa']);
        $pessoaAnimaisClass =  new PessoasAnimais();
        
        $pessoaAnimaisClass->setPessoa($pessoaClass);
        $pessoaAnimaisClass->setAnimal($animaisClass);
        
        $em->persist($animaisClass);
        $em->persist($pessoaAnimaisClass);
        $em->flush();
        $data['typeForm'] = 'lista';
        
        $data['search'] = $data_request['nome'];
        return $data;
    }

    public function formIncluir($request, $helpersServices) {
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
        $data['pessoas'] = $helpersServices->getPessoas();
        $data['form'] = $form->createView();
        return $data;
    }

}
