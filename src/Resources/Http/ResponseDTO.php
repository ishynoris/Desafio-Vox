<?php 

namespace App\Resources\Http;

use App\Resources\Interfaces\DTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package namespace
 *
 * Class ResponseDTO
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class ResponseDTO extends JsonResponse { 

	/**
	 * Construtor
	 *
	 * @param ResponseDTO
	 * @param int $iCodigo = 200
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(DTOInterface $oDTO, int $iCodigo = 200) {
		$aConteudo = [
			'message' => "Ok",
			'data' => $oDTO->toArray(),
		];
		parent::__construct($aConteudo, $iCodigo);
	}
}