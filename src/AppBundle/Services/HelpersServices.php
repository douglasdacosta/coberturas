<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Services;

use AppBundle\Entity\Pessoas;
use AppBundle\Entity\Garanhoes;
use AppBundle\Entity\Animais;
use AppBundle\Entity\PessoasAnimais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of HelpersServices
 *
 * @author douglas
 */
class HelpersServices extends Controller {

    private $repositoryPessoas;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->repositoryPessoas = $entityManager->getRepository(Pessoas::class);
        $this->repositoryGaranhoes = $entityManager->getRepository(Garanhoes::class);
        $this->repositoryAnimais = $entityManager->getRepository(Animais::class);
    }

    public function getPessoas() {
        $obj = $this->repositoryPessoas->findAll();
        return $obj;
    }

    public function getGaranhoes() {
        $obj = $this->repositoryGaranhoes->findAll();
        return $obj;
    }

    public function getAnimais() {

        $animais = $this->repositoryAnimais
                ->createQueryBuilder('animal')
                ->addSelect('pessoaAnimal', 'pessoa', 'animal')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = animal.id')
                ->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa');
        $obj = $animais->getQuery()->getScalarResult();

        return $obj;
    }

    public function getAnimaisByPessoa($pessoaId) {
        $animais = $this->repositoryAnimais
                ->createQueryBuilder('animal')
                ->addSelect('pessoaAnimal', 'pessoa', 'animal')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = animal.id')
                ->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa')
                ->andWhere('pessoa.id = :pessoa_id')
                ->setParameter('pessoa_id', $pessoaId);
        $obj = $animais->getQuery()->getScalarResult();
        return $obj;
    }

}
