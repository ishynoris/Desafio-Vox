<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmpresaRepository extends ServiceEntityRepository
{
	/**
	 * Construtor
	 *
	 * @param ManagerRegistry $registry
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empresa::class);
    }

	/**
	 * Salva uma determinada empresa, retornndo seu id
	 *
	 * @param Empresa $oEmpresa
	 * @param bool $autoCommit = true
	 * @return null|int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function salvar(Empresa $oEmpresa, bool $autoCommit = true): ?int {
		$this->getEntityManager()->persist($oEmpresa);
		$this->autoCommit($autoCommit);
		return $autoCommit ? $oEmpresa->getId() : null;
	}

	/**
	 * Retorna um array com todas as empresas
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function findAll(): array
	{
		return $this->createQueryBuilder('e')
               ->orderBy('e.id', 'ASC')
               ->setMaxResults(10)
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
