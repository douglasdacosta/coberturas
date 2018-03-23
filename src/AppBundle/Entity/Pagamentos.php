<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garanhoes
 *
 * @ORM\Table(name="pagamentos")
 * @ORM\Entity
 */
class Pagamentos
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
	 * @var \integer
	 *
	 * @ORM\ManyToOne(targetEntity="Coberturas")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="cobertura_id", referencedColumnName="id", nullable=false)
	 * })
	 */
	private $coberturaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcela", type="integer", nullable=false)
     */
    private $parcela;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=10, nullable=false)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="vencimento", type="date", nullable=false)
     */
    private $vencimento;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pagamento", type="date", nullable=true)
     */
    private $pagamento;

    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return \AppBundle\Entity\Cobertura
     */
    function getCoberturaId() {
        return $this->coberturaId;
    }

    function getParcela() {
        return $this->parcela;
    }

    function getValor() {
        return $this->valor;
    }

    function getVencimento() {
        return $this->vencimento;
    }

    function getPagamento() {
        return $this->pagamento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCoberturaId(\AppBundle\Entity\Coberturas $coberturaId) {
        $this->coberturaId = $coberturaId;
    }

    function setParcela($parcela) {
        $this->parcela = $parcela;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setVencimento($vencimento) {
        $this->vencimento = $vencimento;
    }

    function setPagamento($pagamento) {
        $this->pagamento = $pagamento;
    }


}
