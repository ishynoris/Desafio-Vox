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

    #[ORM\Column(name: "cnpj")]
	/** @var string $sCnpj */
    private $sCnpj;

    #[ORM\Column(name: "data_fundacao", type: Types::DATETIME_MUTABLE)]
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
	public function __construct(string $sNome, string $sCnpj, DateTimeInterface $tDataFundacao = null)
	{
		$this->sNome = $sNome;
		$this->sCnpj = $sCnpj;
		$this->tDataFundacao = $tDataFundacao ?? new DateTimeImmutable;
		$this->tDataCriacao = new DateTimeImmutable;
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
	public static function createFromArray(array $aEmpresa): Empresa 
	{
		$sNome = $aEmpresa['nome'] ?? "";
		if (empty($sNome)) {
			throw new LogicException("Informe o nome da empresa");
		}

		$sCnpj = str_replace([ ".", "-", "/"], "", $aEmpresa['cnpj'] ?? "");
		if (empty($sCnpj)) {
			throw new LogicException("Informe o CNPJ da empresa");
		}

		try {
			$sDataFundacao = $aEmpresa['data_fundcao'] ?? "";
			$tDataFundacao = empty($sDataFundacao) ? null : new DateTimeImmutable($sDataFundacao);
		} catch (Throwable $e) {
			$tDataFundacao = null;
		}

		$oEmpresa = new Empresa($sNome, $sCnpj, $tDataFundacao);
		$oEmpresa->iId = is_int($aEmpresa['id'] ?? "") ? $aEmpresa['id'] : null;
		return $oEmpresa;
	}

	/**
	 * Retorna o ID da empresa
	 *
	 * @return null|int
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getId(): ?int
    {
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
    public function getNome(): string
    {
        return $this->sNome;
    }

	/**
	 * Retorna o CNPJ da empresa com a máscara aplicada
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getCnpjComMascara(): string
    {
        return $this->sCnpj;
    }

	/**
	 * Retorna a data de fundação da empresa formatada
	 *
	 * @return string
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
    public function getDataFundacaoPtbr(): string
    {
        return $this->tDataFundacao->format("d/m/Y");
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
		return [
			'id' => $this->getId(),
			'nome' => $this->getNome(),
			'cnpj' => $this->sCnpj,
			'cnpj_mascara' => $this->getCnpjComMascara(),
			'data_fundacao' => $this->tDataFundacao->format("Y-m-d"),
			'data_fundacao_ptbr' => $this->getDataFundacaoPtbr(),
		];
	}
}
