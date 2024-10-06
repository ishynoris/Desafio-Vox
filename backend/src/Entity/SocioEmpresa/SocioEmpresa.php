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
 #[ORM\Table(name: "socios_empresa", )]
class SocioEmpresa implements DTOInterface { 

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: Types::INTEGER)]
	/** @var int $iId */
    private $iId = null;

	#[ORM\ManyToOne(targetEntity: Empresa::class )]
	#[ORM\JoinColumn(name: "empresa_id", referencedColumnName: "id", nullable: false)]
	/** @var Empresa $oEmpresa */
	private $oEmpresa;

	#[ORM\Column(name: "nome")]
	/** @var string $sNome */
	private $sNome;

	#[ORM\Column(name: "cpf", length: 11)]
	/** @var string $sCpf */
	private $sCpf;

    #[ORM\Column(name: "data_vinculo", type: Types::DATE_MUTABLE)]
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
	 * @param Empresa $oEmpresa
	 * @param string $sNome
	 * @param string $sCpf
	 * @param DateTimeInterface $tDataVinculo = null
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(Empresa $oEmpresa, string $sNome, string $sCpf, DateTimeInterface $tDataVinculo = null) {
		$this->oEmpresa = $oEmpresa;
		$this->setNome($sNome);
		$this->setCpf($sCpf);
		$this->tDataVinculo = $tDataVinculo ?? new DateTimeImmutable;
		$this->tDataCriacao = new DateTimeImmutable;
	}

	/**
	 * Constrói uma instância de sócio a partir de um array associativo
	 *
	 * @param array $aDados
	 * @return DTOInterface
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createFromArray(array $aDados): DTOInterface {
		$oEmpresa = $aDados['empresa'] ?? null;
		if (!$oEmpresa instanceof Empresa) {
			throw new LogicException("É necessário informar o código da empresa");
		}

		$sNome = $aDados['nome'] ?? "";
		$sCpf = $aDados['cpf'] ?? "";
		$sDataVinculo = $aDados['data_vinculo'] ?? "";

		$tDataVinculo = empty($sDataVinculo) ? null : new DateTimeImmutable($sDataVinculo);

		$oSocio = new SocioEmpresa($oEmpresa, $sNome, $sCpf, $tDataVinculo);
		$oSocio->iId = is_numeric($aDados['id'] ?? "") ? $aDados['id'] : null;

		$mApagado = $aDados['apagado'] ?? false;
		if (is_bool($mApagado)) {
			$oSocio->bApagado = $mApagado;
		} elseif (is_numeric($mApagado)) {
			$oSocio->bApagado = $mApagado != 0;
		}

		return $oSocio;
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
	 * @param Empresa $oEmpresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setEmpresa(Empresa $oEmpresa) {
		$this->oEmpresa = $oEmpresa;
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
		$aPartes = [
			substr($this->sCpf, 0, 3),
			substr($this->sCpf, 3, 3),
			substr($this->sCpf, 6, 3),
			substr($this->sCpf, 9, 2),
		];
		return sprintf("%s.%s.%s-%s", ...$aPartes);
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
		$mEmpresa = $aCampos['empresa'] ?? null;
		if ($mEmpresa instanceof Empresa) {
			$this->setEmpresa($mEmpresa);
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
		$sDataAtualizacao = $sDataAtualizacaoPtbr = null;
		if (!empty($this->tDataAtualizacao)) {
			$sDataAtualizacao = $this->tDataAtualizacao->format("Y-m-d H:i:s");
			$sDataAtualizacaoPtbr = $this->tDataAtualizacao->format("d/m/Y H:i:s");
		}

		return [
			'meta_data' => [ 
				'get' => "/socio/{$this->iId}",
				'put' => "/socio/{$this->iId}",
				'delete' => "/socio/{$this->iId}",
			],
			'id' => $this->iId,
			'empresa_id' => $this->oEmpresa->getId(),
			'empresa' => $this->oEmpresa->toArray(),
			'nome' => $this->sNome,
			'cpf' => $this->sCpf,
			'cpf_mascara' => $this->getCpfComMascara(),
			'data_vinculo' => $this->tDataVinculo->format("Y-m-d"),
			'data_vinculo_ptbr' => $this->tDataVinculo->format("d/m/Y"),
			'data_criacao' => $this->tDataCriacao->format("Y-m-d H:i:s"),
			'data_criacao_ptbr' => $this->tDataCriacao->format("d/m/Y H:i:s"),
			'data_atualizacao' => $sDataAtualizacao,
			'data_atualizacao_ptbr' => $sDataAtualizacaoPtbr,
		];
	}
}
