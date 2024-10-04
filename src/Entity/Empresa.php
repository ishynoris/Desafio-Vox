<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ORM\Table(name: "empresas")]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
	/** @var int $id */
    private $id = null;

    #[ORM\Column]
	/** @var string $nome */
    private $nome;

    #[ORM\Column]
	/** @var string $cnpj */
    private $cnpj;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "data_fundacao")]
	/** @var DateTimeInterface $dataFundacao */
    private $dataFundacao;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "data_criacao")]
	/** @var DateTimeInterface $dataCriacao */
    private $dataCriacao;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "data_atualizacao", nullable: true)]
	/** @var DateTimeInterface $dataAtualizacao */
    private $dataAtualizacao = null;

	/**
	 * Construtor
	 *
	 * @param string $nome
	 * @param string $cnpj
	 * @param DateTimeInterface $dataFundacao = null
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public function __construct(string $nome, string $cnpj, DateTimeInterface $dataFundacao = null)
	{
		$this->nome = $nome;
		$this->cnpj = $cnpj;
		$this->dataFundacao = $dataFundacao ?? new DateTimeImmutable;
		$this->dataCriacao = new DateTimeImmutable;
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
        return $this->id;
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
        return $this->nome;
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
        return $this->cnpj;
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
        return $this->dataFundacao->format("d/m/Y");
    }
}
