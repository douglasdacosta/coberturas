<?php

namespace AppBundle\Repository;

Use Doctrine\ORM\EntityRepository;

class coberturasRepository extends EntityRepository {
    
public function getAllCoberturas() {
$coberturas = $this->getDoctrine()
			->getRepository(Coberturas::class);

		$coberturas = $coberturas
			->createQueryBuilder('cobertura')
			->addSelect('pessoaAnimal', 'pessoa', 'animal')
			->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
			->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa')
			->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal');

		$data['coberturas'] = $coberturas->getQuery()->getScalarResult();

}
    
    //put your code here
}
