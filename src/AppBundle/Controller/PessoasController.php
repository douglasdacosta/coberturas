<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pessoas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Services\FieldsValidations;

class PessoasController extends Controller {

    /**
     * @Route("/pessoas/{action}", name="pessoas", defaults={"action":null, "id":null})
     * @Route("/pessoas/{action}/{id}", name="pessoas", defaults={"action":null, "id":null})
     */
    public function indexAction(Request $request, $action, $id) {

        switch ($action) {
            case 'alterar':
                $data = $this->alterar($request, $id);
                $uri = $this->generateUrl('pessoas', array('search' => $data['search']));
                return $this->redirect($uri, 302);
                break;

            case 'incluir':

                $data = $this->incluir($request);
                $uri = $this->generateUrl('pessoas', array('search' => $data['search']));
                return $this->redirect($uri, 302);

                break;

            case 'formIncluir':

                return $this->render('default/pessoas.html.twig', $this->formIncluir($request));

                break;

            case 'formAlterar':

                return $this->render('default/pessoas.html.twig', $this->formAlterar($request, $id));

                break;

            default:
                return $this->render('default/pessoas.html.twig', $this->listAction($request));
                break;
        }
    }

    public function listAction($request) {
        $pessoas = $this->getDoctrine()->getManager();
        $pessoas = $this->getDoctrine()->getRepository(Pessoas::class);
        $pessoas = $pessoas->createQueryBuilder('pessoa');
        $data['search'] = '';
        if (trim($request->query->get('search')) != '') {
            $search = $request->query->get('search');
            $pessoas = $pessoas
                    ->where('pessoa.nome like :nome')
                    ->setParameter('nome', '%' . $search . '%');
            $data['search'] = $search;
        }
        $data['pessoas'] = $pessoas->getQuery()->getResult();
        $data['typeForm'] = 'lista';
        return $data;
    }

    public function alterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $pessoasClass = $em->getRepository(Pessoas::class)->find($id);
        $form = $this->createFormBuilder($pessoasClass)
                ->add('nome', TextType::class)
                ->add('email', TextType::class, array('required' => false))
                ->add('cpfCnpj', TextType::class, array('required' => false))
                ->add('telefoneCel', TextType::class, array('required' => false))
                ->add('telefoneFixo', TextType::class, array('required' => false))
                ->add('endereco', TextType::class, array('required' => false))
                ->add('complemento', TextType::class, array('required' => false))
                ->add('bairro', TextType::class, array('required' => false))
                ->add('estado', TextType::class, array('required' => false))
                ->add('cidade', TextType::class, array('required' => false))
                ->add('cep', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $dataPessoas = $form->getData();
        $pessoasClass->setNome($dataPessoas->getNome());
        $pessoasClass->setEmail($dataPessoas->getEmail());
        $pessoasClass->setCpfCnpj(FieldsValidations::onlyNumbers($dataPessoas->getCpfCnpj()));
        $pessoasClass->setTelefoneCel(FieldsValidations::onlyNumbers($dataPessoas->getTelefoneCel()));
        $pessoasClass->setTelefoneFixo(FieldsValidations::onlyNumbers($dataPessoas->getTelefoneFixo()));
        $pessoasClass->setEndereco($dataPessoas->getEndereco());
        $pessoasClass->setComplemento($dataPessoas->getComplemento());
        $pessoasClass->setBairro($dataPessoas->getBairro());
        $pessoasClass->setEstado($dataPessoas->getEstado());
        $pessoasClass->setCidade($dataPessoas->getCidade());
        $pessoasClass->setCep(FieldsValidations::onlyNumbers($dataPessoas->getCep()));
        $pessoasClass->setAtivo($dataPessoas->getAtivo());
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataPessoas->getNome();
        return $data;
    }

    public function formAlterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $pessoasClass = $em->getRepository(Pessoas::class)->find($id);
        $form = $this->createFormBuilder($pessoasClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('email', TextType::class, array('required' => false))
                ->add('cpfCnpj', TextType::class, array('required' => false))
                ->add('telefoneCel', TextType::class, array('required' => false))
                ->add('telefoneFixo', TextType::class, array('required' => false))
                ->add('endereco', TextType::class, array('required' => false))
                ->add('complemento', TextType::class, array('required' => false))
                ->add('bairro', TextType::class, array('required' => false))
                ->add('estado', TextType::class, array('required' => false))
                ->add('cidade', TextType::class, array('required' => false))
                ->add('cep', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

    public function incluir($request) {
        $pessoasClass = new Pessoas();
        $form = $this->createFormBuilder($pessoasClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('email', TextType::class, array('required' => false))
                ->add('cpfCnpj', TextType::class, array('required' => false))
                ->add('telefoneCel', TextType::class, array('required' => false))
                ->add('telefoneFixo', TextType::class, array('required' => false))
                ->add('endereco', TextType::class, array('required' => false))
                ->add('complemento', TextType::class, array('required' => false))
                ->add('bairro', TextType::class, array('required' => false))
                ->add('estado', TextType::class, array('required' => false))
                ->add('cidade', TextType::class, array('required' => false))
                ->add('cep', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        
        $form->handleRequest($request);
        $dataPessoas = $form->getData();
        $pessoasClass->setNome($dataPessoas->getNome());
        $pessoasClass->setEmail($dataPessoas->getEmail());
        $pessoasClass->setCpfCnpj(FieldsValidations::onlyNumbers($dataPessoas->getCpfCnpj()));
        $pessoasClass->setTelefoneCel(FieldsValidations::onlyNumbers($dataPessoas->getTelefoneCel()));
        $pessoasClass->setTelefoneFixo(FieldsValidations::onlyNumbers($dataPessoas->getTelefoneFixo()));
        $pessoasClass->setEndereco($dataPessoas->getEndereco());
        $pessoasClass->setComplemento($dataPessoas->getComplemento());
        $pessoasClass->setBairro($dataPessoas->getBairro());
        $pessoasClass->setEstado($dataPessoas->getEstado());
        $pessoasClass->setCidade($dataPessoas->getCidade());
        $pessoasClass->setCep(FieldsValidations::onlyNumbers($dataPessoas->getCep()));
        $pessoasClass->setAtivo(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($pessoasClass);
        $em->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = $dataPessoas->getNome();
        return $data;
    }

    public function formIncluir($request) {
        $pessoasClass = new Pessoas();
        $form = $this->createFormBuilder($pessoasClass)
                ->add('id', HiddenType::class)
                ->add('nome', TextType::class)
                ->add('email', TextType::class, array('required' => false))
                ->add('cpfCnpj', TextType::class, array('required' => false))
                ->add('telefoneCel', TextType::class, array('required' => false))
                ->add('telefoneFixo', TextType::class, array('required' => false))
                ->add('endereco', TextType::class, array('required' => false))
                ->add('complemento', TextType::class, array('required' => false))
                ->add('bairro', TextType::class, array('required' => false))
                ->add('estado', TextType::class, array('required' => false))
                ->add('cidade', TextType::class, array('required' => false))
                ->add('cep', TextType::class, array('required' => false))
                ->add('ativo', HiddenType::class, array('required' => false))
                ->getForm();
        $form->handleRequest($request);
        $data = [];
        $data['form'] = $form->createView();
        return $data;
    }

}
