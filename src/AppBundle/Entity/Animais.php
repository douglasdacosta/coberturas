<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animais
 *
 * @ORM\Table(name="animais", indexes={@ORM\Index(name="index_2", columns={"id"})})
 * @ORM\Entity
 */
class Animais {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nome", type="string", length=80, nullable=false)
	 */
	private $nome;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idade", type="integer", nullable=true)
	 */
	private $idade;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="local_animal", type="string", length=200, nullable=true)
	 */
	private $localAnimal;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="pelagem", type="string", length=100, nullable=true)
	 */
	private $pelagem;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="ativo", type="integer", nullable=false)
	 */
	private $ativo = '1';

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set nome
	 *
	 * @param string $nome
	 *
	 * @return Animais
	 */
	public function setNome($nome) {
		$this->nome = $nome;

		return $this;
	}

	/**
	 * Get nome
	 *
	 * @return string
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * Set idade
	 *
	 * @param integer $idade
	 *
	 * @return Animais
	 */
	public function setIdade($idade) {
		$this->idade = $idade;

		return $this;
	}

	/**
	 * Get idade
	 *
	 * @return integer
	 */
	public function getIdade() {
		return $this->idade;
	}

	/**
	 * Set localAnimal
	 *
	 * @param string $localAnimal
	 *
	 * @return Animais
	 */
	public function setLocalAnimal($localAnimal) {
		$this->localAnimal = $localAnimal;

		return $this;
	}

	/**
	 * Get localAnimal
	 *
	 * @return string
	 */
	public function getLocalAnimal() {
		return $this->localAnimal;
	}

	/**
	 * Set pelagem
	 *
	 * @param string $pelagem
	 *
	 * @return Animais
	 */
	public function setPelagem($pelagem) {
		$this->pelagem = $pelagem;

		return $this;
	}

	/**
	 * Get pelagem
	 *
	 * @return string
	 */
	public function getPelagem() {
		return $this->pelagem;
	}

	/**
	 * Set ativo
	 *
	 * @param integer $ativo
	 *
	 * @return Animais
	 */
	public function setAtivo($ativo) {
		$this->ativo = $ativo;

		return $this;
	}

	/**
	 * Get ativo
	 *
	 * @return integer
	 */
	public function getAtivo() {
		return $this->ativo;
	}
}
