<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coberturas;
use AppBundle\Entity\Animais;
use AppBundle\Entity\PessoasAnimais;
use AppBundle\Entity\Pessoas;
use AppBundle\Entity\Garanhoes;
use AppBundle\Entity\Pagamentos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\HelpersServices;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\FieldsValidations;

class CoberturasController extends Controller {

    /**
     * @Route("/coberturas/{action}", name="coberturas", defaults={"action":null, "id":null})
     * @Route("/coberturas/{action}/{id}", name="coberturas", defaults={"action":null, "id":null})
     */
    public function indexAction(Request $request, $action, $id, HelpersServices $helpersServices) {

        switch ($action) {
            case 'alterar':

                $data = $this->alterar($request, $id);
                $uri = $this->generateUrl('coberturas', array('search' => $data['search']));
                return $this->redirect($uri, 302);
                break;

            case 'incluir':

                $data = $this->incluir($request);
                $uri = $this->generateUrl('coberturas', array('search' => $data['search']));
                return $this->redirect($uri, 302);
                break;

            case 'formIncluir':

                $data = $this->formIncluir($request, $helpersServices);
                return $this->render('default/coberturas.html.twig', $data);
                break;

            case 'formAlterar':

                $data = $this->formAlterar($request, $helpersServices);
                return $this->render('default/coberturas.html.twig', $data);

                break;

            default:
                $data = $this->listAction($request, $helpersServices);
                if (!$data) {
                    return $this->redirectToRoute('pesquisa');
                }
                return $this->render('default/coberturas.html.twig', $data);
                break;
        }
    }

    public function listAction($request, $helpersServices) {
        
        
        $data['pessoas'] = $helpersServices->getPessoas();
        $data['garanhoes'] = $helpersServices->getGaranhoes();
        $objCoberturas = $this->getDoctrine()
                ->getRepository(Coberturas::class);

        if (($request->query->get('pessoa') == null ) || ($request->query->get('cobertura') == null ) || ($request->query->get('animal') == null )) {
            return false;
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
                ->addSelect('animal', 'garanhao')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
                ->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
                ->join(Garanhoes::class, 'garanhao', 'WITH', 'garanhao.id = cobertura.garanhao')
                ->andWhere('animal.id = :animal_id')
                ->setParameter('animal_id', $request->query->get('animal'))
                ->orderBy('cobertura.DataCobertura', 'DESC');
        $arrayCoberturas = $arrayCoberturas->getQuery()->getScalarResult();

        $data['typeForm'] = $request->query->get('formType');
        $data['array_coberturas'] = $arrayCoberturas;
        return $data;
    }

    public function alterar($request, $id) {
        $em = $this->getDoctrine()->getManager();
        $coberturas = $em->getRepository(Coberturas::class)->find($id);
        $pagamentos = $em->getRepository(Pagamentos::class)->findByCoberturaId($id);
        $garanhao = $em->getRepository(Garanhoes::class)->find($request->request->get('garanhao'));
        $animal = $em->getRepository(Animais::class)->find($request->request->get('animal'));
        $dataParto = FieldsValidations::dateToSave($request->request->get('data_cobertura'));
        $data_parto = $this->calculaDataParto($dataParto->format('Y-m-d'));
        $coberturas->setGaranhao($garanhao);
        $coberturas->setAnimal($animal);
        $coberturas->setDataCobertura($request->request->get('data_cobertura') ? FieldsValidations::dateToSave($request->request->get('data_cobertura')) : null);
        $coberturas->setDataParto($data_parto['data_parto'] ? FieldsValidations::dateToSave($data_parto['data_parto']) : null);
        $coberturas->setPrevisaoParto(FieldsValidations::dateToSave($data_parto['previsao_parto_min']));
        $coberturas->setSexo($request->request->get('sexo') ? $request->request->get('sexo') : null);
        $coberturas->setObito($request->request->get('data_obito') ? FieldsValidations::dateToSave($request->request->get('data_obito')) : null);
        
        
        
        $form = $request->request->get('form');
        if ($pagamentos) {
            foreach ($pagamentos as $key => $pagamento) {
                $em->remove($pagamento);
                $em->flush();
            }
        }

        foreach ($form['parcela'] as $key => $parcela) {
            $pagamentos = new Pagamentos();
            $pagamentos->setCoberturaId($coberturas);
            $pagamentos->setParcela($parcela);
            $pagamentos->setValor(str_replace(',', '.', str_replace('.', '', $form['valor'][$key])));
            $pagamentos->setVencimento($form['vencimento'][$key] ? FieldsValidations::dateToSave($form['vencimento'][$key]) : null);
            $pagamentos->setPagamento($form['pagamento'][$key] ? FieldsValidations::dateToSave($form['pagamento'][$key]) : null);
            $em->persist($pagamentos);
        }

        $data['typeForm'] = $request->query->get('formType');
        $data['search'] = '';

        $em->persist($coberturas);
        $em->flush();
        return $data;
    }

    public function formAlterar($request, $helpersServices) {
        $objCoberturas = $this->getDoctrine()
                ->getRepository(Coberturas::class);

        $coberturas = $objCoberturas
                ->createQueryBuilder('cobertura')
                ->addSelect('pessoaAnimal', 'pessoa', 'animal', 'garanhao')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
                ->join(Pessoas::class, 'pessoa', 'WITH', 'pessoa.id = pessoaAnimal.pessoa')
                ->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
                ->join(Garanhoes::class, 'garanhao', 'WITH', 'garanhao.id = cobertura.garanhao')
                ->andWhere('pessoa.id = :pessoa_id')
                ->setParameter('pessoa_id', $request->query->get('pessoa'))
                ->andWhere('cobertura.id = :cobertura_id')
                ->setParameter('cobertura_id', $request->query->get('cobertura'))
                ->andWhere('animal.id = :animal_id')
                ->setParameter('animal_id', $request->query->get('animal'));

        $coberturas = $coberturas->getQuery()->getScalarResult();
        $em = $this->getDoctrine()->getManager();
        $pagamentos = $em->getRepository(Pagamentos::class)->findByCoberturaId($request->query->get('cobertura'));
        $form = $this->createFormBuilder($coberturas)->getForm();

        $form->handleRequest($request);

        $data = $this->calculaDataParto($coberturas[0]['cobertura_dataCobertura']->format('Y-m-d'));
        $data['cobertura'] = $coberturas[0];
        $soma = 0;
        foreach ($pagamentos as $value) {
            $soma = $soma + $value->getValor();
        }               
        $data['valor'] = number_format($soma, 2, ',', '');
        $data['pagamentos'] = $pagamentos;
        $data = $this->GetPreparedData($data, $helpersServices);
        $data['cobertura_id'] = $request->query->get('cobertura');
        $arrayCoberturas = $objCoberturas
                ->createQueryBuilder('cobertura')
                ->addSelect('animal', 'garanhao')
                ->join(PessoasAnimais::class, 'pessoaAnimal', 'WITH', 'pessoaAnimal.animal = cobertura.animal')
                ->join(Animais::class, 'animal', 'WITH', 'animal.id = pessoaAnimal.animal')
                ->join(Garanhoes::class, 'garanhao', 'WITH', 'garanhao.id = cobertura.garanhao')
                ->andWhere('animal.id = :animal_id')
                ->setParameter('animal_id', $request->query->get('animal'))
                ->orderBy('cobertura.dataCobertura', 'DESC');
        $arrayCoberturas = $arrayCoberturas->getQuery()->getScalarResult();

        $data['array_coberturas'] = $arrayCoberturas;
        $data['typeForm'] = $request->query->get('formType');
        return $data;
    }

    public function incluir(Request $request) {
        $coberturas = new Coberturas();
        $em = $this->getDoctrine()->getManager();
        $garanhao = $em->getRepository(Garanhoes::class)->find($request->request->get('garanhao'));
        $animal = $em->getRepository(Animais::class)->find($request->request->get('animal'));
        $data_cobertura = FieldsValidations::dateToSave($request->request->get('data_cobertura'));
        $dataParto = $this->calculaDataParto($data_cobertura->format('Y-m-d'));

        $coberturas->setGaranhao($garanhao);
        $coberturas->setAnimal($animal);
        $coberturas->setDataCobertura($request->request->get('data_cobertura') ? FieldsValidations::dateToSave($request->request->get('data_cobertura')) : null);
        $coberturas->setDataParto(FieldsValidations::dateToSave($dataParto['data_parto']));
        $coberturas->setPrevisaoParto(FieldsValidations::dateToSave($dataParto['previsao_parto_min']));
        $coberturas->setSexo($request->request->get('sexo'));
        $coberturas->setObito($request->request->get('data_obito') ? FieldsValidations::dateToSave($request->request->get('data_obito')) : null);
        $coberturas->setAtivo(1);
        $ema = $this->getDoctrine()->getManager();
        
        $form = $request->request->get('form');
        
        $ema->persist($coberturas);
        
        foreach ($form['parcela'] as $key => $parcela) {   
            $pagamentos = new Pagamentos();
            $pagamentos->setCoberturaId($coberturas);
            $pagamentos->setParcela($parcela);
            $pagamentos->setValor(str_replace(',', '.', str_replace('.', '', $form['valor'][$key])));
            $pagamentos->setVencimento($form['vencimento'][$key] ? FieldsValidations::dateToSave($form['vencimento'][$key]) : null);
            $pagamentos->setPagamento($form['pagamento'][$key] ? FieldsValidations::dateToSave($form['pagamento'][$key]) : null);
            $em->persist($pagamentos);
        }
        
        
        $ema->flush();
        $data['typeForm'] = 'lista';
        $data['search'] = '';
        return $data;
    }

    public function formIncluir($request, $helpersServices) {

        $data = $this->GetPreparedData([], $helpersServices);

        $data['cobertura_id'] = null;
        $data['typeForm'] = null;
        return $data;
    }

    public function GetPreparedData($data = [], $helpersServices) {
        $data['pessoas'] = $helpersServices->getPessoas();
        $data['garanhoes'] = $helpersServices->getGaranhoes();
        $data['animais'] = $helpersServices->getAnimais();
        return $data;
    }

    /**
     * @Route("/ajaxGetAnimais/{pessoa}")
     * @param type integer
     * @param HelpersServices $helpersServices
     * @return array
     */
    public function ajaxGetAnimais($pessoa, HelpersServices $helpersServices) {
        return new JsonResponse($helpersServices->getAnimaisByPessoa($pessoa));
    }

    public function calculaDataParto($dataCobertura) {

        $dateTime = new \DateTime($dataCobertura);
        $minDataParto = $dateTime->add(new \DateInterval('P10M'))->format('d/m/Y');
        $minDataParto = $dateTime->add(new \DateInterval('P26D'))->format('d/m/Y');
        $data['previsao_parto_min'] = $minDataParto;

        $dateTime = new \DateTime($dataCobertura);
        $maxDataParto = $dateTime->add(new \DateInterval('P11M'))->format('d/m/Y');
        $maxDataParto = $dateTime->add(new \DateInterval('P11D'))->format('d/m/Y');
        $data['previsao_parto_max'] = $maxDataParto;

        $dateTime = new \DateTime($dataCobertura);
        $dataParto = $dateTime->add(new \DateInterval('P11M'))->format('d/m/Y');
        $data['data_parto'] = $dataParto;

        return $data;
    }

    /**
     * @Route("/ajaxAlterarParcela/{parcela}/{coberturaId}/{data}/", name="ajaxAlterarParcela")
     */
    public function ajaxAlterarParcela($parcela, $coberturaId, $data) {
        $retorno = [
            'error' => false,
            'message' => 'Pagamento alterado!'
        ];
        try {
            $em = $this->getDoctrine()->getManager();
            $pagamento = $em->getRepository(Pagamentos::class)->findBy(['coberturaId' => $coberturaId, 'parcela' => $parcela]);
            $pagamento = $pagamento[0];
            $data = implode('-', array_reverse(explode('-', $data)));
            $pagamento->setPagamento($start = new \DateTime($data));
            $em->persist($pagamento);
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            $retorno = [
                'error' => true,
                'message' => 'erro ao alterar o pagamento - ' . $e
            ];
        }

        return new JsonResponse($retorno);
    }

    /**
     * @Route("/ajaxDeletarParcela/{parcela}/{coberturaId}/", name="ajaxDeletarParcela")
     */
    public function ajaxDeletarParcela($parcela, $coberturaId) {
        $retorno = [
            'error' => false,
            'message' => 'Parcela excluída!'
        ];
        try {
            $em = $this->getDoctrine()->getManager();
            $pagamento = $em->getRepository(Pagamentos::class)->findBy(['coberturaId' => $coberturaId, 'parcela' => $parcela]);
            $pagamento = $pagamento[0];
            $em->remove($pagamento);
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            $retorno = [
                'error' => true,
                'message' => 'Erro ao deletar a parcela - ' . $e
            ];
        }

        return new JsonResponse($retorno);
    }

    /**
     * @Route("/ajaxCalculaParcelas/{parcelas}/{valor}/", name="ajaxCalculaParcelas")
     */
    public function ajaxCalculaParcelas($parcelas, $valor, $pagas = []) {
        $dataRetorno = [];
        $dataRetorno['text_html'] = [];
        $html = '';
        $valor = number_format(str_replace(',', '.', str_replace('.', '', $valor)), 2, '.', '');
        $valor_parcela = round($valor / $parcelas, 2);
        $val_somado_parcelas = $valor_parcela * $parcelas;
        $diff = $valor - $val_somado_parcelas;
        if ($val_somado_parcelas > $valor) {
            $diff = round($val_somado_parcelas - $valor, 2);
        } else {
            $diff = round($valor - $val_somado_parcelas, 2);
        }

        $data = date('Y-m-d');
        $vencimentos = $this->calculaVencimentos($parcelas, $data);
        $valor = $valor_parcela;
        for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $valor = $valor_parcela;
            if ($parcela == 1) {
                $valor = $valor_parcela - ($diff);
            }
            $valor = number_format($valor, 2, ',', '.');
            $vencimento = $vencimentos[$parcela - 1];

            $classPago = (isset($pagas[$parcela]) && $pagas[$parcela] != "") ? 'fas fa-check pago' : '';
            $html .= "<tr>
                        <td>
                            $parcela
                            <input type='hidden' value='$parcela' name='form[parcela][]'</td>
                        <td>
                            $valor
                            <input type='hidden' value='$valor' name='form[valor][]'</td>
                        </td>
                        <td>
                            $vencimento
                            <input type='hidden' value='$vencimento' name='form[vencimento][]'</td>
                        </td>
                        <td>
                            <i class='" . $classPago . " pointer'></i></td>
                            <input type='hidden' value='' name='form[pagamento][]'</td>
                        <td>
                            <i class='fas fa-pencil-alt edit pointer'></i></td>
                        </tr>";
        }

        $dataRetorno['text_html'] = $html;

        return new JsonResponse($dataRetorno);
    }

    public function calculaVencimentos($numparcelas, $dataPrimeiraParcela = null) {
        $start = new \DateTime($dataPrimeiraParcela);
        $interval = new \DateInterval('P1M');

        $datas = new \DatePeriod($start, $interval, $numparcelas - 1);

        foreach ($datas as $data) {
            $dates[] = $data->format('d/m/Y');
        }

        return $dates;
    }

}
