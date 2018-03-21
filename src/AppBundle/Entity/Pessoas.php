<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pessoas
 *
 * @ORM\Table(name="pessoas", indexes={@ORM\Index(name="index_1", columns={"id"})})
 * @ORM\Entity
 */
class Pessoas
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf_cnpj", type="text", length=15, nullable=true)
     */
    private $cpfCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone_cel", type="text", length=11, nullable=true)
     */
    private $telefoneCel;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone_fixo", type="text", length=11, nullable=true)
     */
    private $telefoneFixo;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=200, nullable=true)
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=80, nullable=true)
     */
    private $complemento;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=80, nullable=true)
     */
    private $bairro;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=80, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="cidade", type="string", length=80, nullable=true)
     */
    private $cidade;

    /**
     * @var integer
     *
     * @ORM\Column(name="cep", type="integer", nullable=true)
     */
    private $cep;

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
     * @return Pessoas
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
     * Set email
     *
     * @param string $email
     *
     * @return Pessoas
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set cpfCnpj
     *
     * @param integer $cpfCnpj
     *
     * @return Pessoas
     */
    public function setCpfCnpj($cpfCnpj)
    {
        $this->cpfCnpj = $cpfCnpj;

        return $this;
    }

    /**
     * Get cpfCnpj
     *
     * @return integer
     */
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * Set telefoneCel
     *
     * @param integer $telefoneCel
     *
     * @return Pessoas
     */
    public function setTelefoneCel($telefoneCel)
    {
        $this->telefoneCel = $telefoneCel;

        return $this;
    }

    /**
     * Get telefoneCel
     *
     * @return integer
     */
    public function getTelefoneCel()
    {
        return $this->telefoneCel;
    }

    /**
     * Set telefoneFixo
     *
     * @param integer $telefoneFixo
     *
     * @return Pessoas
     */
    public function setTelefoneFixo($telefoneFixo)
    {
        $this->telefoneFixo = $telefoneFixo;

        return $this;
    }

    /**
     * Get telefoneFixo
     *
     * @return integer
     */
    public function getTelefoneFixo()
    {
        return $this->telefoneFixo;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     *
     * @return Pessoas
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     *
     * @return Pessoas
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     *
     * @return Pessoas
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     *
     * @return Pessoas
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cidade
     *
     * @param integer $cidade
     *
     * @return Pessoas
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get cidade
     *
     * @return integer
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set cep
     *
     * @param integer $cep
     *
     * @return Pessoas
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get cep
     *
     * @return integer
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set ativo
     *
     * @param integer $ativo
     *
     * @return Pessoas
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
