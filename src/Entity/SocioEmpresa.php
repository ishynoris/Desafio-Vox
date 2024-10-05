<?php

namespace App\Entity;

use App\Repository\SocioEmpresaRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package namespace
 *
 * Class SocioEmpresa
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
 #[ORM\Entity(repositoryClass: SocioEmpresaRepository::class)]
 #[ORM\Table(name: "socios_empresa")]
class SocioEmpresa { 

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: Types::INTEGER)]
	/** @var int $iId */
    private $iId = null;

	#[ORM\OneToOne(targetEntity: Empresa::class, )]
	#[ORM\JoinColumn(name: "empresa_id", referencedColumnName: "id")]
	/** @var int $iEmpresaId */
	private $iEmpresaId;

	#[ORM\Column(name: "nome")]
	/** @var string $sNome */
	private $sNome;

	#[ORM\Column(name: "cpf")]
	/** @var string $sCpf */
	private $sCpf;

    #[ORM\Column(name: "data_vinculo", type: Types::DATETIME_MUTABLE)]
	/** @var DateTimeInterface $tDataVinculo */
    private $tDataVinculo;

    #[ORM\Column(name: "data_criacao", type: Types::DATETIME_MUTABLE)]
	/** @var DateTimeInterface $tDataCriacao */
    private $tDataCriacao;

    #[ORM\Column(name: "data_atualizacao", nullable: true, type: Types::DATETIME_MUTABLE)]
	/** @var DateTimeInterface $tDataAtualizacao */
    private $tDataAtualizacao = null;

	/**
	 * Construtor
	 *
	 * @param int $iEmpresaId
	 * @param string $sNome
	 * @param string $sCpf
	 * @param DateTimeInterface $tDataVinculo = null
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(int $iEmpresaId, string $sNome, string $sCpf, DateTimeInterface $tDataVinculo = null) {
		$this->iEmpresaId = $iEmpresaId;
		$this->sNome = $sNome;
		$this->sCpf = $sCpf;
		$this->tDataVinculo = $tDataVinculo ?? new DateTimeImmutable;
		$this->tDataCriacao = new DateTimeImmutable;
	}

	/**
	 * Retorna o ID do sócio
	 *
	 * @return null|int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getId(): ?int {
		return $this->iId;
	}

	/**
	 * Retorna o ID da empresa
	 *
	 * @return int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function getEmpresaId(): int {
		return $this->iEmpresaId;
	}
}
