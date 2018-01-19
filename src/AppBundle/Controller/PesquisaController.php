<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animais;
use AppBundle\Entity\Coberturas;
use AppBundle\Entity\Pessoas;
use AppBundle\Entity\PessoasAnimais;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PesquisaController extends Controller {
	/**
	 * @Route("/pesquisa", name="pesquisa")
	 */
	public function indexAction(Request $request) {
		$coberturas = $this->getDoctrine()
			->getRepository(Coberturas::class);

        
		$coberturas = $coberturas
			->createQueryBuilder('cobertura')
			->addSelect('pessoaAnimal', 'pessoa', 'animal')
			->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
			->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa')
			->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
            ->orderBy('cobertura.dataCobertura', 'DESC');
        $data['search'] = ''; 
        if (trim($request->request->get('search')) != '') {
            $search = $request->request->get('search');
            $coberturas = $coberturas
                ->where('pessoa.nome like :nome')
                ->orWhere('animal.nome like :animalNome')
                ->setParameter('nome', '%'.$request->request->get('search').'%')
                ->setParameter('animalNome', '%'.$search.'%');
            $data['search'] = $search; 
        }
        
		$data['coberturas'] = $coberturas->getQuery()->getScalarResult();
		//dump($results);
		//die;
		return $this->render('default/pesquisa.html.twig', $data);
	}
}
