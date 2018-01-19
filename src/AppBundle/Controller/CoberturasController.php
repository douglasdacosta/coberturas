<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coberturas;
use AppBundle\Entity\Animais;
use AppBundle\Entity\PessoasAnimais;
use AppBundle\Entity\Pessoas;
use AppBundle\Entity\Garanhoes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoberturasController extends Controller {

    /**
     * @Route("/coberturas", name="coberturas")
     */
    public function indexAction(Request $request) {
        $objCoberturas = $this->getDoctrine()
                ->getRepository(Coberturas::class);

        if (($request->query->get('pessoa') == null ) || ($request->query->get('cobertura') == null ) || ($request->query->get('animal') == null )) {
            return $this->redirectToRoute('pesquisa');
        }
        $coberturas = $objCoberturas
                ->createQueryBuilder('cobertura')
                ->addSelect('pessoaAnimal', 'pessoa', 'animal')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
                ->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa')
                ->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
                ->andWhere('pessoa.id = :pessoa_id')
                ->setParameter('pessoa_id', $request->query->get('pessoa'))
                ->andWhere('cobertura.id = :cobertura_id')
                ->setParameter('cobertura_id', $request->query->get('cobertura'))
                ->andWhere('animal.id = :animal_id')
                ->setParameter('animal_id', $request->query->get('animal'));
        $coberturas = $coberturas->getQuery()->getScalarResult();
        $data['cobertura'] = $coberturas[0];
        
        $arrayCoberturas = $objCoberturas
                ->createQueryBuilder('cobertura')
                ->addSelect('animal','garanhao')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
                ->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
                ->join(Garanhoes::class, 'garanhao', 'WITH', 'garanhao.id = cobertura.garanhao')
                ->andWhere('animal.id = :animal_id')
                ->setParameter('animal_id', $request->query->get('animal'));
        $arrayCoberturas = $arrayCoberturas->getQuery()->getScalarResult();

        
        $data['array_coberturas'] = $arrayCoberturas;
        return $this->render('default/coberturas.html.twig', $data);
    }

    /**
     * @Route("/coberturas/incluir", name="coberturas_incluir")
     */
    public function incluirAction(Request $request) {
        
        
        return $this->render('default/coberturas.html.twig');
    }
}
