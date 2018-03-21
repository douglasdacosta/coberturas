<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coberturas
 *
 * @ORM\Table(name="coberturas", indexes={@ORM\Index(name="index_6", columns={"garanhao_id"}), @ORM\Index(name="fk_coberturas_2_idx", columns={"animal_id"})})
 * @ORM\Entity
 */
class Coberturas {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="previsao_parto", type="date", nullable=true)
	 */
	private $previsaoParto;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="data_parto", type="date", nullable=true)
	 */
	private $dataParto;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="sexo", type="string", length=1, nullable=true)
	 */
	private $sexo;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="obito", type="date", nullable=true)
	 */
	private $obito;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="ativo", type="integer", nullable=false)
	 */
	private $ativo = '1';

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="data_cobertura", type="date", nullable=false)
	 */
	private $dataCobertura;

	/**
	 * @var \integer
	 *
	 * @ORM\ManyToOne(targetEntity="Garanhoes")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="garanhao_id", referencedColumnName="id")
	 * })
	 */
	private $garanhao;

	/**
	 * @var \integer
	 *
	 * @ORM\ManyToOne(targetEntity="Animais")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="animal_id", referencedColumnName="id")
	 * })
	 * @ORM\ManyToMany(targetEntity="Coberturas", inversedBy="Animais")
	 * @ORM\JoinTable(name="PessoasAnimais")
	 */
	private $animal;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set previsaoParto
	 *
	 * @param \DateTime $previsaoParto
	 *
	 * @return Coberturas
	 */
	public function setPrevisaoParto($previsaoParto) {
		$this->previsaoParto = $previsaoParto;

		return $this;
	}

	/**
	 * Get previsaoParto
	 *
	 * @return \DateTime
	 */
	public function getPrevisaoParto() {
		return $this->previsaoParto;
	}

	/**
	 * Set dataParto
	 *
	 * @param \DateTime $dataParto
	 *
	 * @return Coberturas
	 */
	public function setDataParto($dataParto) {
		$this->dataParto = $dataParto;

		return $this;
	}

	/**
	 * Get dataParto
	 *
	 * @return \DateTime
	 */
	public function getDataParto() {
		return $this->dataParto;
	}

	/**
	 * Set sexo
	 *
	 * @param string $sexo
	 *
	 * @return Coberturas
	 */
	public function setSexo($sexo) {
		$this->sexo = $sexo;

		return $this;
	}

	/**
	 * Get sexo
	 *
	 * @return string
	 */
	public function getSexo() {
		return $this->sexo;
	}

	/**
	 * Set obito
	 *
	 * @param \DateTime $obito
	 *
	 * @return Coberturas
	 */
	public function setObito($obito) {
		$this->obito = $obito;

		return $this;
	}

	/**
	 * Get obito
	 *
	 * @return \DateTime
	 */
	public function getObito() {
		return $this->obito;
	}

	/**
	 * Set ativo
	 *
	 * @param integer $ativo
	 *
	 * @return Coberturas
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

	/**
	 * Set dataCobertura
	 *
	 * @param \DateTime $dataCobertura
	 *
	 * @return Coberturas
	 */
	public function setDataCobertura($dataCobertura) {
		$this->dataCobertura = $dataCobertura;

		return $this;
	}

	/**
	 * Get dataCobertura
	 *
	 * @return \DateTime
	 */
	public function getDataCobertura() {
		return $this->dataCobertura;
	}

	/**
	 * Set garanhao
	 *
	 * @param \AppBundle\Entity\Garanhoes $garanhao
	 *
	 * @return Coberturas
	 */
	public function setGaranhao(\AppBundle\Entity\Garanhoes $garanhao = null) {
		$this->garanhao = $garanhao;

		return $this;
	}

	/**
	 * Get garanhao
	 *
	 * @return \AppBundle\Entity\Garanhoes
	 */
	public function getGaranhao() {
		return $this->garanhao;
	}

	/**
	 * Set animal
	 *
	 * @param \AppBundle\Entity\Animais $animal
	 *
	 * @return Coberturas
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
}
