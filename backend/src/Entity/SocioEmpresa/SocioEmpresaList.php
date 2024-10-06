<?php

namespace App\Entity\SocioEmpresa;

use App\Resources\Interfaces\DTOInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @package App\Entity\SocioEmpresa
 *
 * Class SocioEmpresaList
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class SocioEmpresaList extends ArrayCollection implements DTOInterface { 

	/**
	 * Adiciona um sócio na lista
	 *
	 * @param SocioEmpresa $oSocio
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function addSocio(SocioEmpresa $oSocio) {
		parent::add($oSocio);
	}

	/**
	 * Constrói uma lista de sócios a partir de um array bidimensional
	 *
	 * @param array $aSocio
	 * @return SocioEmpresaList
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createFromArray(array $aSocio): SocioEmpresaList {
		return array_reduce($aSocio, function(SocioEmpresaList $loSocio, SocioEmpresa $oSocio) {
			$loSocio->addSocio($oSocio);
			return $loSocio;
		}, new SocioEmpresaList);
	}

	/**
	 * Converte a lista num array serializável
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function toArray(): array {
		return $this->reduce(function(array $aSocio, SocioEmpresa $oSocio) {
			$aSocio[] = $oSocio->toArray();
			return $aSocio;
		}, []);
	}
}