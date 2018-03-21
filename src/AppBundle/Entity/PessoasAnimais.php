<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PessoasAnimais
 *
 * @ORM\Table(name="pessoas_animais", indexes={@ORM\Index(name="index_7", columns={"id"}), @ORM\Index(name="index_3", columns={"pessoa_id"}), @ORM\Index(name="fk_pessoas_animais_1", columns={"animal_id"})})
 * @ORM\Entity
 */
class PessoasAnimais {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \Animais
	 *
	 * @ORM\ManyToOne(targetEntity="Animais")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="animal_id", referencedColumnName="id")
	 * })
	 * @ORM\ManyToMany(targetEntity="Animais", inversedBy="Coberturas")
	 * @ORM\JoinTable(name="PessoasAnimais")
	 */
	private $animal;

	/**
	 * @var \Pessoas
	 *
	 * @ORM\ManyToOne(targetEntity="Pessoas")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
	 * })
	 */
	private $pessoa;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set animal
	 *
	 * @param \AppBundle\Entity\Animais $animal
	 *
	 * @return PessoasAnimais
	 */
	public function setAnimal(\AppBundle\Entity\Animais $animal = null) {
		$this->animal = $animal;

		return $this;
	}

	/**
	 * Get animal
	 *
	 * @return \AppBundle\Entity\Animais
	 */
	public function getAnimal() {
		return $this->animal;
	}

	/**
	 * Set pessoa
	 *
	 * @param \AppBundle\Entity\Pessoas $pessoa
	 *
	 * @return PessoasAnimais
	 */
	public function setPessoa(\AppBundle\Entity\Pessoas $pessoa = null) {
		$this->pessoa = $pessoa;

		return $this;
	}

	/**
	 * Get pessoa
	 *
	 * @return \AppBundle\Entity\Pessoas
	 */
	public function getPessoa() {
		return $this->pessoa;
	}
}
