<?php

namespace App\Repository;

use App\Entity\Empresa\Empresa;
use App\Entity\Empresa\EmpresaList;
use App\Resources\Trait\AutoCommitTrait;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

class EmpresaRepository extends ServiceEntityRepository {

	use AutoCommitTrait;

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
	 * Atualiza os dados de uma determinada empresa
	 *
	 * @param int $iId
	 * @param array $aDados
	 * @param bool $autoCommit = true
	 * @return Empresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function atualizar(int $iId, array $aDados, bool $autoCommit = true): Empresa {
		$oEmpresa = $this->getById($iId);
		$oEmpresa->atualizarCampos($aDados);

		$this->getEntityManager()->persist($oEmpresa);
		$this->autoCommit($autoCommit);
		return $oEmpresa;
	}

	/**
	 * Atualiza os dados de uma determinada empresa
	 *
	 * @param int $iId
	 * @param array $aDados
	 * @param bool $autoCommit = true
	 * @return Empresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function apagar(int $iId, bool $autoCommit = true): Empresa {
		$oEmpresa = $this->getById($iId);
		$oEmpresa->apagar();

		$this->getEntityManager()->persist($oEmpresa);
		$this->autoCommit($autoCommit);
		return $oEmpresa;
	}

	/**
	 * Retorna um array com todas as empresas
	 *
	 * @return EmpresaList
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getTodas(): EmpresaList {
		$aEmpresa = $this->createQueryBuilder('e')
			->where('e.bApagado = false')
			->orderBy('e.iId', 'ASC')
			->getQuery()
			->getResult();
		return EmpresaList::createFromArray($aEmpresa);
	}

	/**
	 * Retorna a Empresa pelo ID informado
	 *
	 * @return Empresa
	 * @throws EntityNotFoundException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getById(int $iId): Empresa {
		$oEmpresa = parent::findOneBy([
			'iId' => $iId,
			'bApagado' => false
		]);
		if (is_null($oEmpresa)) {
			throw new EntityNotFoundException("Não foi possível encontrar a empresa pelo ID {$iId}");
		}
		return $oEmpresa;
	}
}
