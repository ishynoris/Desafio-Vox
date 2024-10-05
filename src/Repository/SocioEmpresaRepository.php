<?php

namespace App\Repository;

use App\Entity\SocioEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @package namespace
 *
 * Class SocioEmpresaRepository
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class SocioEmpresaRepository  extends ServiceEntityRepository {

	/**
	 * Construtor
	 *
	 * @param ManagerRegistry $registry
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SocioEmpresa::class);
    }

	/**
	 * Salva uma determinada empresa, retornndo seu id
	 *
	 * @param SocioEmpresa $oSocio
	 * @param bool $autoCommit = true
	 * @return null|int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function salvar(SocioEmpresa $oSocio, bool $autoCommit = true): ?int {
		$this->getEntityManager()->persist($oSocio);
		$this->autoCommit($autoCommit);
		return $autoCommit ? $oSocio->getId() : null;
	}

	/**
	 * Retorna um array com todas as empresas
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function findAll(): array {
		return $this->createQueryBuilder('s')
				->orderBy('s.id', 'ASC')
				->getQuery()
				->getResult();
	}

	/**
	 * Realiza o auto commit das alterações
	 *
	 * @param bool $autoCommit
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	private function autoCommit(bool $autoCommit) {
		if ($autoCommit) {
			$this->getEntityManager()->flush();
		}
	}
}