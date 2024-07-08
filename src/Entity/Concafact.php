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
 * Entity class for "concafact" table
 */
#[Entity]
#[Table(name: "concafact")]
class Concafact extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $nroconc;

    #[Column(type: "string")]
    private string $descrip;

    #[Column(type: "float", nullable: true)]
    private ?float $porcentaje;

    #[Column(type: "float", nullable: true)]
    private ?float $importe;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer")]
    private int $activo;

    #[Column(type: "integer", nullable: true)]
    private ?int $tipoiva;

    #[Column(type: "integer", nullable: true)]
    private ?int $impuesto;

    #[Column(type: "integer")]
    private int $tieneresol;

    #[Column(name: "ctacbleBAS", type: "string", nullable: true)]
    private ?string $ctacbleBas;

    public function __construct()
    {
        $this->activo = 1;
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

    public function getNroconc(): int
    {
        return $this->nroconc;
    }

    public function setNroconc(int $value): static
    {
        $this->nroconc = $value;
        return $this;
    }

    public function getDescrip(): string
    {
        return HtmlDecode($this->descrip);
    }

    public function setDescrip(string $value): static
    {
        $this->descrip = RemoveXss($value);
        return $this;
    }

    public function getPorcentaje(): ?float
    {
        return $this->porcentaje;
    }

    public function setPorcentaje(?float $value): static
    {
        $this->porcentaje = $value;
        return $this;
    }

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(?float $value): static
    {
        $this->importe = $value;
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

    public function getFechahora(): DateTime
    {
        return $this->fechahora;
    }

    public function setFechahora(DateTime $value): static
    {
        $this->fechahora = $value;
        return $this;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $value): static
    {
        $this->activo = $value;
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

    public function getImpuesto(): ?int
    {
        return $this->impuesto;
    }

    public function setImpuesto(?int $value): static
    {
        $this->impuesto = $value;
        return $this;
    }

    public function getTieneresol(): int
    {
        return $this->tieneresol;
    }

    public function setTieneresol(int $value): static
    {
        $this->tieneresol = $value;
        return $this;
    }

    public function getCtacbleBas(): ?string
    {
        return HtmlDecode($this->ctacbleBas);
    }

    public function setCtacbleBas(?string $value): static
    {
        $this->ctacbleBas = RemoveXss($value);
        return $this;
    }
}
