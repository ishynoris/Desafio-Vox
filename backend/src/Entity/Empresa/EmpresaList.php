<?php 

namespace App\Entity\Empresa;

use App\Resources\Interfaces\DTOInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @package App\Entity\Empresa
 *
 * Class EmpresaList
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class EmpresaList extends ArrayCollection implements DTOInterface { 

	/**
	 * Adiciona uma emrpesa na lista
	 *
	 * @param Empresa $oEmpresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function addEmpresa(Empresa $oEmpresa)
	{
		parent::add($oEmpresa);
	}

	/**
	 * Constrói uma lista de empresas a partir de um array
	 *
	 * @param array $aEmpresa
	 * @return EmpresaList
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createFromArray(array $aEmpresa): EmpresaList {
		return array_reduce($aEmpresa, function(EmpresaList $loEmpresa, Empresa $oEmpresa) {
			$loEmpresa->addEmpresa($oEmpresa);
			return $loEmpresa;
		}, new EmpresaList);
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
		return $this->reduce(function(array $aEmpresa, Empresa $oEmpresa) {
			$aEmpresa[] = $oEmpresa->toArray();
			return $aEmpresa;
		}, []);
	}
}
