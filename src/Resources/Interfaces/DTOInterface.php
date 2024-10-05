<?php 

namespace App\Resources\Interfaces;

/**
 * @package App\Resources\Interfaces
 *
 * Class DTOInterface
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
interface DTOInterface { 

	/**
	 * Cria uma instância de DTOInterface a partir de um array associativo
	 *
	 * @param array $aDados
	 * @return DTOInterface
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createFromArray(array $aDados): DTOInterface;

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
