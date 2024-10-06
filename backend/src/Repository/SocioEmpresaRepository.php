<?php

namespace App\Repository;

use App\Entity\SocioEmpresa\SocioEmpresa as Socio;
use App\Entity\SocioEmpresa\SocioEmpresaList;
use App\Resources\Trait\AutoCommitTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
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

	use AutoCommitTrait;

	/**
	 * Construtor
	 *
	 * @param ManagerRegistry $oRegistry
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function __construct(ManagerRegistry $oRegistry) {
        parent::__construct($oRegistry, Socio::class);
    }

	/**
	 * Salva as informações de um sócio, retornando seu ID
	 *
	 * @param Socio $oSocio
	 * @param bool $bAutoCommit = true
	 * @return null|int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function salvar(Socio $oSocio, bool $bAutoCommit = true): ?int {
		$this->getEntityManager()->persist($oSocio);
		$this->autoCommit($bAutoCommit);
		return $bAutoCommit ? $oSocio->getId() : null;
	}

	/**
	 * Atualiza as informações de um sócio
	 *
	 * @param int $iId
	 * @param array $aDados
	 * @param bool $autoCommit = true
	 * @return Socio
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function atualizar(int $iId, array $aDados, bool $autoCommit = true): Socio {
		$oSocio = $this->getById($iId);
		$oSocio->atualizarCampos($aDados);

		$this->getEntityManager()->persist($oSocio);
		$this->autoCommit($autoCommit);
		return $oSocio;
	}

	/**
	 * Apaga um sócio pelo ID informado
	 *
	 * @param int $iId
	 * @param array $aDados
	 * @param bool $autoCommit = true
	 * @return Socio
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function apagar(int $iId, bool $autoCommit = true): Socio {
		$oSocio = $this->getById($iId);
		$oSocio->apagar();

		$this->getEntityManager()->persist($oSocio);
		$this->autoCommit($autoCommit);
		return $oSocio;
	}

	/**
	 * Retorna uma lista de sócios
	 *
	 * @return SocioEmpresaList
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getTodos(): SocioEmpresaList {
		$aSocios = $this->createQueryBuilder('s')
			->where("s.bApagado = false", )
			->orderBy('s.iId', 'ASC')
			->getQuery()
			->getResult();
		return SocioEmpresaList::createFromArray($aSocios);
	}

	/**
	 * Retorna um sócio a partir do ID informado
	 *
	 * @return Socio
	 * @throws EntityNotFoundException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getById(int $iId): Socio {
		$oSocio = parent::findOneBy([
			'iId' => $iId,
			'bApagado' => false
		]);
		if (is_null($oSocio)) {
			throw new EntityNotFoundException("Não foi possível encontrar o sócio pelo ID {$iId}");
		}
		return $oSocio;
	}
}