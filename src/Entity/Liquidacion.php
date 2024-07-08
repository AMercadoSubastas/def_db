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
 * Entity class for "liquidacion" table
 */
#[Entity]
#[Table(name: "liquidacion")]
class Liquidacion extends AbstractEntity
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
    private int $cliente;

    #[Column(type: "string")]
    private string $rubro;

    #[Column(type: "string", nullable: true)]
    private ?string $calle;

    #[Column(type: "string", nullable: true)]
    private ?string $dnro;

    #[Column(type: "string", nullable: true)]
    private ?string $pisodto;

    #[Column(type: "string", nullable: true)]
    private ?string $codpost;

    #[Column(type: "integer", nullable: true)]
    private ?int $codpais;

    #[Column(type: "integer", nullable: true)]
    private ?int $codprov;

    #[Column(type: "integer", nullable: true)]
    private ?int $codloc;

    #[Column(type: "integer")]
    private int $codrem;

    #[Column(type: "date")]
    private DateTime $fecharem;

    #[Column(type: "string", nullable: true)]
    private ?string $cuit;

    #[Column(type: "integer", nullable: true)]
    private ?int $tipoiva;

    #[Column(type: "decimal")]
    private string $totremate;

    #[Column(type: "decimal")]
    private string $totneto1;

    #[Column(type: "decimal")]
    private string $totiva21;

    #[Column(type: "decimal")]
    private string $subtot1;

    #[Column(type: "decimal")]
    private string $totneto2;

    #[Column(type: "decimal")]
    private string $totiva105;

    #[Column(type: "decimal")]
    private string $subtot2;

    #[Column(type: "decimal")]
    private string $totacuenta;

    #[Column(type: "decimal")]
    private string $totgastos;

    #[Column(type: "decimal")]
    private string $totvarios;

    #[Column(type: "decimal")]
    private string $saldoafav;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "date")]
    private DateTime $fechaliq;

    #[Column(type: "string", nullable: true)]
    private ?string $estado;

    #[Column(type: "string", nullable: true)]
    private ?string $nrodoc;

    #[Column(type: "float", nullable: true)]
    private ?float $cotiz;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecultmod;

    public function __construct()
    {
        $this->totremate = "0.00";
        $this->totneto1 = "0.00";
        $this->totiva21 = "0.00";
        $this->subtot1 = "0.00";
        $this->totneto2 = "0.00";
        $this->totiva105 = "0.00";
        $this->subtot2 = "0.00";
        $this->totacuenta = "0.00";
        $this->totgastos = "0.00";
        $this->totvarios = "0.00";
        $this->saldoafav = "0.00";
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

    public function getCliente(): int
    {
        return $this->cliente;
    }

    public function setCliente(int $value): static
    {
        $this->cliente = $value;
        return $this;
    }

    public function getRubro(): string
    {
        return HtmlDecode($this->rubro);
    }

    public function setRubro(string $value): static
    {
        $this->rubro = RemoveXss($value);
        return $this;
    }

    public function getCalle(): ?string
    {
        return HtmlDecode($this->calle);
    }

    public function setCalle(?string $value): static
    {
        $this->calle = RemoveXss($value);
        return $this;
    }

    public function getDnro(): ?string
    {
        return HtmlDecode($this->dnro);
    }

    public function setDnro(?string $value): static
    {
        $this->dnro = RemoveXss($value);
        return $this;
    }

    public function getPisodto(): ?string
    {
        return HtmlDecode($this->pisodto);
    }

    public function setPisodto(?string $value): static
    {
        $this->pisodto = RemoveXss($value);
        return $this;
    }

    public function getCodpost(): ?string
    {
        return HtmlDecode($this->codpost);
    }

    public function setCodpost(?string $value): static
    {
        $this->codpost = RemoveXss($value);
        return $this;
    }

    public function getCodpais(): ?int
    {
        return $this->codpais;
    }

    public function setCodpais(?int $value): static
    {
        $this->codpais = $value;
        return $this;
    }

    public function getCodprov(): ?int
    {
        return $this->codprov;
    }

    public function setCodprov(?int $value): static
    {
        $this->codprov = $value;
        return $this;
    }

    public function getCodloc(): ?int
    {
        return $this->codloc;
    }

    public function setCodloc(?int $value): static
    {
        $this->codloc = $value;
        return $this;
    }

    public function getCodrem(): int
    {
        return $this->codrem;
    }

    public function setCodrem(int $value): static
    {
        $this->codrem = $value;
        return $this;
    }

    public function getFecharem(): DateTime
    {
        return $this->fecharem;
    }

    public function setFecharem(DateTime $value): static
    {
        $this->fecharem = $value;
        return $this;
    }

    public function getCuit(): ?string
    {
        return HtmlDecode($this->cuit);
    }

    public function setCuit(?string $value): static
    {
        $this->cuit = RemoveXss($value);
        return $this;
    }

    public function getTipoiva(): ?int
    {
        return $this->tipoiva;
    }

    public function setTipoiva(?int $value): static
    {
        $this->tipoiva = $value;
        return $this;
    }

    public function getTotremate(): string
    {
        return $this->totremate;
    }

    public function setTotremate(string $value): static
    {
        $this->totremate = $value;
        return $this;
    }

    public function getTotneto1(): string
    {
        return $this->totneto1;
    }

    public function setTotneto1(string $value): static
    {
        $this->totneto1 = $value;
        return $this;
    }

    public function getTotiva21(): string
    {
        return $this->totiva21;
    }

    public function setTotiva21(string $value): static
    {
        $this->totiva21 = $value;
        return $this;
    }

    public function getSubtot1(): string
    {
        return $this->subtot1;
    }

    public function setSubtot1(string $value): static
    {
        $this->subtot1 = $value;
        return $this;
    }

    public function getTotneto2(): string
    {
        return $this->totneto2;
    }

    public function setTotneto2(string $value): static
    {
        $this->totneto2 = $value;
        return $this;
    }

    public function getTotiva105(): string
    {
        return $this->totiva105;
    }

    public function setTotiva105(string $value): static
    {
        $this->totiva105 = $value;
        return $this;
    }

    public function getSubtot2(): string
    {
        return $this->subtot2;
    }

    public function setSubtot2(string $value): static
    {
        $this->subtot2 = $value;
        return $this;
    }

    public function getTotacuenta(): string
    {
        return $this->totacuenta;
    }

    public function setTotacuenta(string $value): static
    {
        $this->totacuenta = $value;
        return $this;
    }

    public function getTotgastos(): string
    {
        return $this->totgastos;
    }

    public function setTotgastos(string $value): static
    {
        $this->totgastos = $value;
        return $this;
    }

    public function getTotvarios(): string
    {
        return $this->totvarios;
    }

    public function setTotvarios(string $value): static
    {
        $this->totvarios = $value;
        return $this;
    }

    public function getSaldoafav(): string
    {
        return $this->saldoafav;
    }

    public function setSaldoafav(string $value): static
    {
        $this->saldoafav = $value;
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

    public function getFechaliq(): DateTime
    {
        return $this->fechaliq;
    }

    public function setFechaliq(DateTime $value): static
    {
        $this->fechaliq = $value;
        return $this;
    }

    public function getEstado(): ?string
    {
        return HtmlDecode($this->estado);
    }

    public function setEstado(?string $value): static
    {
        $this->estado = RemoveXss($value);
        return $this;
    }

    public function getNrodoc(): ?string
    {
        return HtmlDecode($this->nrodoc);
    }

    public function setNrodoc(?string $value): static
    {
        $this->nrodoc = RemoveXss($value);
        return $this;
    }

    public function getCotiz(): ?float
    {
        return $this->cotiz;
    }

    public function setCotiz(?float $value): static
    {
        $this->cotiz = $value;
        return $this;
    }

    public function getUsuarioultmod(): ?int
    {
        return $this->usuarioultmod;
    }

    public function setUsuarioultmod(?int $value): static
    {
        $this->usuarioultmod = $value;
        return $this;
    }

    public function getFecultmod(): ?DateTime
    {
        return $this->fecultmod;
    }

    public function setFecultmod(?DateTime $value): static
    {
        $this->fecultmod = $value;
        return $this;
    }
}
