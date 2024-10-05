<?php 

namespace App\Resources\Interfaces;

/**
 * @package namespace
 *
 * Class DTOInterface
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
interface DTOInterface { 

	/**
	 * Retorna os elementos como um array
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function toArray(): array;
}
