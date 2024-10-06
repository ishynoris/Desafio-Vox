<?php

namespace App\Resources\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * @package App\Resources\Http
 *
 * Class ResponseException
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class ResponseException extends JsonResponse { 

	/**
	 * Construtor
	 *
	 * @param Throwable $oException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(Throwable $oException) {
		$aConteudo = [
			'message' => 'Error',
			'error' => $oException->getMessage(),
		];
		parent::__construct($aConteudo, 500);
	}
}
