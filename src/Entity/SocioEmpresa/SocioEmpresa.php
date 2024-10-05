<?php

namespace App\Entity\SocioEmpresa;

use App\Entity\Empresa\Empresa;
use App\Repository\SocioEmpresaRepository;
use App\Resources\Interfaces\DTOInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * @package App\Entity\SocioEmpresa
 *
 * Class SocioEmpresa
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
 #[ORM\Entity(repositoryClass: SocioEmpresaRepository::class)]
 #[ORM\Table(name: "socios_empresa")]
class SocioEmpresa implements DTOInterface { 

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

	#[ORM\Column("apagado", type: Types::BOOLEAN, options: [ 'default' => false ])]
	/** @var bool $bApagado */
	private $bApagado;

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
		$this->setEmpresaId($iEmpresaId);
		$this->setNome($sNome);
		$this->setCpf($sCpf);
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
	 * Altera o ID da empresa que o sócio faz parte
	 *
	 * @param int $iEmpresaId
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setEmpresaId(int $iEmpresaId) {
		if ($iEmpresaId <= 0) {
			throw new LogicException("O código da empresa é inválido");
		}
		$this->iEmpresaId = $iEmpresaId;
	}

	/**
	 * Altera o nome do sócio
	 *
	 * @param string $sNome
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setNome(string $sNome) {
		if (empty($sNome)) {
			throw new LogicException("Informe o nome do sócio");
		}

		$this->sNome = $sNome;
	}

	/**
	 * Altera o CPF do sócio
	 *
	 * @param string $sCpf
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setCpf(string $sCpf) {
		$sCpf = str_replace([ ".", "-" ], "", $sCpf);

		if (empty($sCpf)) {
			throw new LogicException("Informe o CPF do sócio");
		}

		if (strlen($sCpf) != 11) {
			throw new LogicException("CPF inválido");
		}
		$this->sCpf = $sCpf;
	}

	/**
	 * Retorna o CPF com máscara
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	private function getCpfComMascara(): string {
		return $this->sCpf;
	}

	/**
	 * Apaga um sócio (logicamente)
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function apagar() {
		$this->bApagado = true;
		$this->tDataAtualizacao = new DateTimeImmutable;
	}

	/**
	 * Atualiza os campos do sócio
	 *
	 * @param array $aCampos
	 * @return SocioEmpresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function atualizarCampos(array $aCampos): SocioEmpresa {
		if (is_numeric($aCampos['empresa_id'])) {
			$this->setEmpresaId($aCampos['empresa_id']);
		}

		if (!empty($aCampos['nome'])) {
			$this->setNome($aCampos['nome']);
		}

		if (!empty($aCampos['cpf'])) {
			$this->setCpf($aCampos['cpf']);
		}

		if (!empty($aCampos['data_vinculo'])) {
			$this->tDataVinculo = new DateTimeImmutable($aCampos['data_vinculo']);
		}

		$this->tDataAtualizacao = new DateTimeImmutable;
		return $this;
	}

	/**
	 * Retorna as informações do sócio num array associativo
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function toArray(): array {
		return [
			'id' => $this->iId,
			'empresa_id' => $this->iEmpresaId,
			'nome' => $this->sNome,
			'cpf' => $this->sCpf,
			'cpf_mascara' => $this->getCpfComMascara(),
			'data_vinculo' => $this->tDataVinculo->format("Y-m-d"),
			'data_vinculo_ptbr' => $this->tDataVinculo->format("d/m/Y"),
		];
	}
}
