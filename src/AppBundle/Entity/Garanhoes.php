<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garanhoes
 *
 * @ORM\Table(name="garanhoes")
 * @ORM\Entity
 */
class Garanhoes
{
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
     * @ORM\Column(name="registro", type="integer", nullable=true)
     */
    private $registro;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_arrecadado", type="string", length=200, nullable=true)
     */
    private $valorArrecadado;

    /**
     * @var string
     *
     * @ORM\Column(name="arvore_genealogica", type="string", length=400, nullable=true)
     */
    private $arvoreGenealogica;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Garanhoes
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set registro
     *
     * @param integer $registro
     *
     * @return Garanhoes
     */
    public function setRegistro($registro)
    {
        $this->registro = $registro;

        return $this;
    }

    /**
     * Get registro
     *
     * @return integer
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * Set valorArrecadado
     *
     * @param string $valorArrecadado
     *
     * @return Garanhoes
     */
    public function setValorArrecadado($valorArrecadado)
    {
        $this->valorArrecadado = $valorArrecadado;

        return $this;
    }

    /**
     * Get valorArrecadado
     *
     * @return string
     */
    public function getValorArrecadado()
    {
        return $this->valorArrecadado;
    }

    /**
     * Set arvoreGenealogica
     *
     * @param string $arvoreGenealogica
     *
     * @return Garanhoes
     */
    public function setArvoreGenealogica($arvoreGenealogica)
    {
        $this->arvoreGenealogica = $arvoreGenealogica;

        return $this;
    }

    /**
     * Get arvoreGenealogica
     *
     * @return string
     */
    public function getArvoreGenealogica()
    {
        return $this->arvoreGenealogica;
    }

    /**
     * Set ativo
     *
     * @param integer $ativo
     *
     * @return Garanhoes
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return integer
     */
    public function getAtivo()
    {
        return $this->ativo;
    }
}
