<?php

namespace PHPMaker2024\Subastas2024\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\Subastas2024\AbstractEntity;
use PHPMaker2024\Subastas2024\AdvancedSecurity;
use PHPMaker2024\Subastas2024\UserProfile;
use function PHPMaker2024\Subastas2024\Config;
use function PHPMaker2024\Subastas2024\EntityManager;
use function PHPMaker2024\Subastas2024\RemoveXss;
use function PHPMaker2024\Subastas2024\HtmlDecode;
use function PHPMaker2024\Subastas2024\EncryptPassword;

/**
 * Entity class for "detfac" table
 */
#[Entity]
#[Table(name: "detfac")]
class Detfac extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $tcomp;

    #[Column(type: "integer")]
    private int $serie;

    #[Column(type: "integer")]
    private int $ncomp;

    #[Column(type: "integer")]
    private int $nreng;

    #[Column(type: "integer", nullable: true)]
    private ?int $codrem;

    #[Column(type: "integer", nullable: true)]
    private ?int $codlote;

    #[Column(type: "string", nullable: true)]
    private ?string $descrip;

    #[Column(type: "decimal", nullable: true)]
    private ?string $neto;

    #[Column(type: "decimal", nullable: true)]
    private ?string $bruto;

    #[Column(type: "decimal", nullable: true)]
    private ?string $iva;

    #[Column(type: "decimal", nullable: true)]
    private ?string $imp;

    #[Column(type: "decimal", nullable: true)]
    private ?string $comcob;

    #[Column(type: "decimal", nullable: true)]
    private ?string $compag;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "float", nullable: true)]
    private ?float $porciva;

    #[Column(type: "integer", nullable: true)]
    private ?int $tieneresol;

    #[Column(type: "integer", nullable: true)]
    private ?int $concafac;

    #[Column(type: "integer", nullable: true)]
    private ?int $tcomsal;

    #[Column(type: "integer", nullable: true)]
    private ?int $seriesal;

    #[Column(type: "integer", nullable: true)]
    private ?int $ncompsal;

    public function __construct()
    {
        $this->neto = "0.00";
        $this->bruto = "0.00";
        $this->iva = "0.00";
        $this->imp = "0.00";
        $this->comcob = "0.00";
        $this->compag = "0.00";
        $this->tieneresol = 0;
    }

    public function getCodnum(): int
    {
        return $this->codnum;
    }

    public function setCodnum(int $value): static
    {
        $this->codnum = $value;
        return $this;
    }

    public function getTcomp(): int
    {
        return $this->tcomp;
    }

    public function setTcomp(int $value): static
    {
        $this->tcomp = $value;
        return $this;
    }

    public function getSerie(): int
    {
        return $this->serie;
    }

    public function setSerie(int $value): static
    {
        $this->serie = $value;
        return $this;
    }

    public function getNcomp(): int
    {
        return $this->ncomp;
    }

    public function setNcomp(int $value): static
    {
        $this->ncomp = $value;
        return $this;
    }

    public function getNreng(): int
    {
        return $this->nreng;
    }

    public function setNreng(int $value): static
    {
        $this->nreng = $value;
        return $this;
    }

    public function getCodrem(): ?int
    {
        return $this->codrem;
    }

    public function setCodrem(?int $value): static
    {
        $this->codrem = $value;
        return $this;
    }

    public function getCodlote(): ?int
    {
        return $this->codlote;
    }

    public function setCodlote(?int $value): static
    {
        $this->codlote = $value;
        return $this;
    }

    public function getDescrip(): ?string
    {
        return HtmlDecode($this->descrip);
    }

    public function setDescrip(?string $value): static
    {
        $this->descrip = RemoveXss($value);
        return $this;
    }

    public function getNeto(): ?string
    {
        return $this->neto;
    }

    public function setNeto(?string $value): static
    {
        $this->neto = $value;
        return $this;
    }

    public function getBruto(): ?string
    {
        return $this->bruto;
    }

    public function setBruto(?string $value): static
    {
        $this->bruto = $value;
        return $this;
    }

    public function getIva(): ?string
    {
        return $this->iva;
    }

    public function setIva(?string $value): static
    {
        $this->iva = $value;
        return $this;
    }

    public function getImp(): ?string
    {
        return $this->imp;
    }

    public function setImp(?string $value): static
    {
        $this->imp = $value;
        return $this;
    }

    public function getComcob(): ?string
    {
        return $this->comcob;
    }

    public function setComcob(?string $value): static
    {
        $this->comcob = $value;
        return $this;
    }

    public function getCompag(): ?string
    {
        return $this->compag;
    }

    public function setCompag(?string $value): static
    {
        $this->compag = $value;
        return $this;
    }

    public function getFechahora(): DateTime
    {
        return $this->fechahora;
    }

    public function setFechahora(DateTime $value): static
    {
        $this->fechahora = $value;
        return $this;
    }

    public function getUsuario(): ?int
    {
        return $this->usuario;
    }

    public function setUsuario(?int $value): static
    {
        $this->usuario = $value;
        return $this;
    }

    public function getPorciva(): ?float
    {
        return $this->porciva;
    }

    public function setPorciva(?float $value): static
    {
        $this->porciva = $value;
        return $this;
    }

    public function getTieneresol(): ?int
    {
        return $this->tieneresol;
    }

    public function setTieneresol(?int $value): static
    {
        $this->tieneresol = $value;
        return $this;
    }

    public function getConcafac(): ?int
    {
        return $this->concafac;
    }

    public function setConcafac(?int $value): static
    {
        $this->concafac = $value;
        return $this;
    }

    public function getTcomsal(): ?int
    {
        return $this->tcomsal;
    }

    public function setTcomsal(?int $value): static
    {
        $this->tcomsal = $value;
        return $this;
    }

    public function getSeriesal(): ?int
    {
        return $this->seriesal;
    }

    public function setSeriesal(?int $value): static
    {
        $this->seriesal = $value;
        return $this;
    }

    public function getNcompsal(): ?int
    {
        return $this->ncompsal;
    }

    public function setNcompsal(?int $value): static
    {
        $this->ncompsal = $value;
        return $this;
    }
}
