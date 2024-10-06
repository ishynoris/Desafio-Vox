<?php 

namespace App\Resources\Trait;

/**
 * @package App\Resources\Trait
 *
 * Class AutoCommitTrait
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
trait AutoCommitTrait { 

	/**
	 * Realiza o auto commit para um determinado repositório
	 *
	 * @param bool $bAutoCommit
	 * @return 
	 * @throws 
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	protected function autoCommit(bool $bAutoCommit) {
		if ($bAutoCommit) {
			$this->getEntityManager()->flush();
		}
	}
}