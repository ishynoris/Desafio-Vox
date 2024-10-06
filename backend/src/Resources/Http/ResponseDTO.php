<?php 

namespace App\Resources\Http;

use App\Resources\Interfaces\DTOInterface;
use Countable;
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
	public function __construct(DTOInterface $oDTO, string $sMensagem = "Ok", int $iCodigo = 200) {
		$aConteudo = [];
		if ($oDTO instanceof Countable) {
			$aConteudo['total'] = $oDTO->count();
		}

		$aConteudo['message'] = $sMensagem;
		$aConteudo['data'] = $oDTO->toArray();

		parent::__construct($aConteudo, $iCodigo);
	}
}