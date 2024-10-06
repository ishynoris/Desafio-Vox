<?php

namespace App\Entity\Empresa;

use App\Repository\EmpresaRepository;
use App\Resources\Interfaces\DTOInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Throwable;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ORM\Table(name: "empresas")]
class Empresa implements DTOInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: Types::INTEGER)]
	/** @var int $iId */
    private $iId = null;

    #[ORM\Column(name: "nome")]
	/** @var string $sNome */
    private $sNome;

    #[ORM\Column(name: "cnpj", length: 14)]
	/** @var string $sCnpj */
    private $sCnpj;

	#[ORM\Column(name: "apagado", type: Types::BOOLEAN, options: [ 'default' => false ])]
	/** @var bool $bApagado */
	private $bApagado;

    #[ORM\Column(name: "data_fundacao", type: Types::DATE_MUTABLE)]
	/** @var DateTimeInterface $tDataFundacao */
    private $tDataFundacao;

    #[ORM\Column(name: "data_criacao", type: Types::DATETIME_MUTABLE)]
	/** @var DateTimeInterface $tDataCriacao */
    private $tDataCriacao;

    #[ORM\Column(name: "data_atualizacao", nullable: true, type: Types::DATETIME_MUTABLE)]
	/** @var DateTimeInterface $tDataAtualizacao */
    private $tDataAtualizacao = null;

	/**
	 * Construtor
	 *
	 * @param string $sNome
	 * @param string $sCnpj
	 * @param DateTimeInterface $tDataFundacao = null
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(string $sNome, string $sCnpj, DateTimeInterface $tDataFundacao = null) {
		$this->setNome($sNome);
		$this->setCnpj($sCnpj);
		$this->tDataFundacao = $tDataFundacao ?? new DateTimeImmutable;
		$this->tDataCriacao = new DateTimeImmutable;
		$this->bApagado = false;
	}

	/**
	 * Cria uma instância de Empresa a partir de um array associativo
	 *
	 * @param array $aEmpresa
	 * @return Empresa
	 * @throws LogicException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createFromArray(array $aEmpresa): Empresa {
		$sNome = $aEmpresa['nome'] ?? "";
		$sCnpj = $aEmpresa['cnpj'] ?? "";

		try {
			$sDataFundacao = $aEmpresa['data_fundcao'] ?? "";
			$tDataFundacao = empty($sDataFundacao) ? null : new DateTimeImmutable($sDataFundacao);
		} catch (Throwable $e) {
			$tDataFundacao = null;
		}

		$oEmpresa = new Empresa($sNome, $sCnpj, $tDataFundacao);
		$oEmpresa->iId = is_numeric($aEmpresa['id'] ?? "") ? $aEmpresa['id'] : null;

		$mApagado = $aEmpresa['apagado'] ?? null;
		if (is_bool($mApagado)) {
			$oEmpresa->bApagado = $mApagado;
		} elseif (is_numeric($mApagado)) {
			$oEmpresa->bApagado !== 0;
		}
		return $oEmpresa;
	}

	/**
	 * Atualiza os campos da empresa
	 *
	 * @param array $aDados
	 * @return Empresa
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function atualizarCampos(array $aDados): Empresa {
		if (!empty($aDados['nome'])) {
			$this->setNome($aDados['nome']);
		}
		
		if (!empty($aDados['cnpj'])) {
			$this->setCnpj($aDados['cnpj']);
		}

		$sDataFundacao = $aDados['data_fundacao'] ?? "";
		if (!empty($sDataFundacao)) {
			$this->tDataFundacao = new DateTimeImmutable($sDataFundacao);
		}

		$this->setDataAtualizacao(new DateTimeImmutable);
		return $this;
	}

	/**
	 * Retorna o ID da empresa
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
	 * Retorna o nome da empresa
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getNome(): string {
        return $this->sNome;
    }

	/**
	 * Altera o nome da empresa
	 *
	 * @param string $sNome
	 * @throws LogicException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setNome(string $sNome) {
		if (empty($sNome)) {
			throw new LogicException("O nome da empresa não deve ser em branco");
		}
		$this->sNome = $sNome;
	}

	/**
	 * Retorna o CNPJ da empresa com a máscara aplicada
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getCnpjComMascara(): string {
		$aPartes = [
			substr($this->sCnpj, 0, 2),
			substr($this->sCnpj, 2, 3),
			substr($this->sCnpj, 5, 3),
			substr($this->sCnpj, 8, 4),
			substr($this->sCnpj, 11, 2),
		];
        return sprintf("%s.%s.%s/%s-%s", ...$aPartes);
    }

	/**
	 * Altera o CNPJ da empresa
	 *
	 * @param string $sNome
	 * @throws LogicException
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setCnpj(string $sCnpj) {
		$sCnpj = str_replace([ ".", "-", "/"], "", $sCnpj);
		if (empty($sCnpj)) {
			throw new LogicException("O CNPJ da empresa não deve ser em branco");
		}

		if (strlen($sCnpj) != 14) {
			throw new LogicException("O CNPJ da empresa não deve ser em branco");
		}
		$this->sCnpj = $sCnpj;
	}

	/**
	 * Apaga uma empresa (logicamente)
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function apagar() {
		$this->bApagado = true;
		$this->setDataAtualizacao(new DateTimeImmutable);
	}

	/**
	 * Verifica se uma determinada empresa está apagada
	 *
	 * @return bool
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function isApagado(): bool {
		return $this->bApagado;
	}

	/**
	 * Retorna a data de fundação da empresa formatada
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getDataFundacaoPtbr(): string {
        return $this->tDataFundacao->format("d/m/Y");
    }

	/**
	 * Altera data de atualização da empresa
	 *
	 * @param DateTimeInterface $tDataAtualizacao
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function setDataAtualizacao(DateTimeInterface $tDataAtualizacao) {
		$this->tDataAtualizacao = $tDataAtualizacao;
	}

	/**
	 * Retorna os dados da emrpesa convertidos num array
	 *
	 * @return array
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function toArray(): array {
		$sDataAtualizacao = $sDataAtualizacaoPtbr = null;
		if (!empty($this->tDataAtualizacao)) {
			$sDataAtualizacao = $this->tDataAtualizacao->format("Y-m-d H:s:s");
			$sDataAtualizacaoPtbr = $this->tDataAtualizacao->format("d/m/Y H:s:s");
		}

		return [
			'meta_data' => [
				'get' => "/empresa/{$this->getId()}",
				'put' => "/empresa/{$this->getId()}",
				'delete' => "/empresa/{$this->getId()}",
			],
			'empresa' => [
				'id' => $this->getId(),
				'nome' => $this->getNome(),
				'cnpj' => $this->sCnpj,
				'cnpj_mascara' => $this->getCnpjComMascara(),
				'data_fundacao' => $this->tDataFundacao->format("Y-m-d"),
				'data_fundacao_ptbr' => $this->getDataFundacaoPtbr(),
				'data_criacao' => $this->tDataCriacao->format("Y-m-d H:i:s"),
				'data_criacao_ptbr' => $this->tDataCriacao->format("d/m/Y H:i:s"),
				'data_atualizacao' => $sDataAtualizacao,
				'data_atualizacao_ptbr' => $sDataAtualizacaoPtbr,
			]
		];
	}
}
