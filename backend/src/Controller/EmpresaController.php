<?php

namespace App\Controller;

use App\Entity\Empresa\Empresa;
use App\Repository\EmpresaRepository;
use App\Resources\Http\ResponseDTO;
use App\Resources\Http\ResponseException;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RequestContext;
use Throwable;

#[Route("/empresa")]
class EmpresaController extends AbstractController
{
	/** @var EmpresaRepository $oRepository */
	private $oRepository;

	/**
	 * Construtor
	 *
	 * @param EmpresaRepository $oRepository
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(EmpresaRepository $oRepository) {
		$this->oRepository = $oRepository;
	}

	/**
	 * Retorna a lista de empresas
	 *
	 * @return Response
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/", name: "empresa_index", methods: [ 'GET' ])]
    public function index(): Response {
		try {
			$loEmpresas = $this->oRepository->getTodas();
			$oResposta = new ResponseDTO($loEmpresas);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
    }

	/**
	 * Retorna a empresa pelo ID informado
	 *
	 * @param int $iId
	 * @return Response
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "empresa_buscar", methods: [ 'GET' ])]
    public function buscar(int $iId): Response {
		try {
			$oEmpresa = $this->oRepository->getById($iId);
			$oResposta = new ResponseDTO($oEmpresa);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
    }

	/**
	 * Realiza o cadastro de uma empresa
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/", name: "empresa_salvar", methods: [ 'POST' ])]
	public function salvar(Request $oRequest): Response {
		try {
			$this->validarHeader($oRequest);

			$oEmpresa = Empresa::createFromArray($oRequest->toArray());
			$this->oRepository->salvar($oEmpresa);

			$oResposta = new ResponseDTO($oEmpresa, "Empresa cadastrada com sucesso", 201);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
	}

	/**
	 * Realiza o cadastro de uma empresa
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "empresa_editar", methods: [ 'PUT' ])]
	public function atualizar(int $iId, Request $oRequest): Response {
		try {
			$this->validarHeader($oRequest);

			$aEmpresa = $oRequest->toArray();
			$oEmpresa = $this->oRepository->atualizar($iId, $aEmpresa);

			$oResposta = new ResponseDTO($oEmpresa, "Empresa atualizada com sucesso");
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
	}

	/**
	 * Realiza o cadastro de uma empresa
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "empresa_apagar", methods: [ 'DELETE' ])]
	public function apagar(int $iId): Response {
		try {
			$oEmpresa = $this->oRepository->apagar($iId);

			$oResposta = new ResponseDTO($oEmpresa, "Empresa apagada com sucesso");
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
	}

	/**
	 * Valida se o cabecalho ContentType é do tipo JSON
	 *
	 * @param Request $oRequest
	 * @throws InvalidArgumentException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	private function validarHeader(Request $oRequest) {
		$sHeader = $oRequest->headers->get("Content-Type");
		if ($sHeader !== "application/json") {
			throw new InvalidArgumentException("Cabecalho \"Content-Type\" deve ser \"application/json\"");
		}
	}
}
