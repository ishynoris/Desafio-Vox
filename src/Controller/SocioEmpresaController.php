<?php

namespace App\Controller;

use App\Entity\SocioEmpresa\SocioEmpresa as Socio;
use App\Repository\EmpresaRepository;
use App\Repository\SocioEmpresaRepository as SocioRepository;
use App\Resources\Http\ResponseDTO;
use App\Resources\Http\ResponseException;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

/**
 * @package App\Controller
 *
 * Class SocioEmpresaController
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
#[Route("/socio")]
class SocioEmpresaController extends AbstractController { 

	/** @var SocioRepository $oRepository */
	private $oRepository;

	/**
	 * Construtor
	 *
	 * @param SocioRepository $oRepository
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(SocioRepository $oRepository) {
		$this->oRepository = $oRepository;
	}

	/**
	 * Retorna a lista de todos os sócios
	 *
	 * @return Response
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/", name: "socio_index", methods: [ 'GET' ])]
    public function index(): Response {
		try {
			$loSocios = $this->oRepository->getTodos();
			$oResposta = new ResponseDTO($loSocios);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
    }

	/**
	 * Retorna o Sócio pelo ID informado
	 *
	 * @param int $iId
	 * @return Response
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "socio_buscar", methods: [ 'GET' ])]
    public function buscar(int $iId): Response {
		try {
			$oSocio = $this->oRepository->getById($iId);
			$oResposta = new ResponseDTO($oSocio);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
    }

	/**
	 * Realiza o cadastro de um determinado sócio
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/", name: "socio_salvar", methods: [ 'POST' ])]
	public function salvar(Request $oRequest, EmpresaRepository $oEmpresaRepository): Response {
		try {
			$this->validarHeader($oRequest);
			$aRequest = $oRequest->toArray();
			$aRequest['empresa'] = $oEmpresaRepository->getById($aRequest['empresa_id']);

			$oSocio = Socio::createFromArray($aRequest);
			$this->oRepository->salvar($oSocio);

			$oResposta = new ResponseDTO($oSocio, "Sócio cadastrado com sucesso", 201);
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
	}

	/**
	 * Realiza o cadastro de um determinado sócio
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "socio_editar", methods: [ 'PUT' ])]
	public function atualizar(int $iId, Request $oRequest, EmpresaRepository $oEmpresaRepository): Response {
		try {
			$this->validarHeader($oRequest);
			$aRequest = $oRequest->toArray();

			$iEmpresaId = $aRequest['empresa_id'] ?? "";
			if (is_numeric($iEmpresaId)) {
				$aRequest['empresa'] = $oEmpresaRepository->getById($iEmpresaId);
			}

			$oSocio = $this->oRepository->atualizar($iId, $aRequest);
			$oResposta = new ResponseDTO($oSocio, "Sócio atualizado com sucesso");
		} catch (Throwable $e) {
			$oResposta = new ResponseException($e);
		}
		return $oResposta;
	}

	/**
	 * Realiza o cadastro de um sócio
	 *
	 * @param Request $oRequest
	 * @return Resonse
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	#[Route("/{iId}", name: "socio_apagar", methods: [ 'DELETE' ])]
	public function apagar(int $iId): Response {
		try {
			$oSocio = $this->oRepository->apagar($iId);

			$oResposta = new ResponseDTO($oSocio, "Sócio foi apagado com sucesso");
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