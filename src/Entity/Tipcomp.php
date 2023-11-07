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
 * Entity class for "tipcomp" table
 */
#[Entity]
#[Table(name: "tipcomp")]
class Tipcomp extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'descripcion' => 'descripcion',
        'activo' => 'activo',
        'esfactura' => 'esfactura',
        'esprovedor' => 'esprovedor',
        'codafip' => 'codafip',
        'usuarioalta' => 'usuarioalta',
        'fechaalta' => 'fechaalta',
        'usuariomod' => 'usuariomod',
        'fechaultmod' => 'fechaultmod',
    ];

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $descripcion;

    #[Column(type: "boolean")]
    private bool $activo = true;

    #[Column(type: "boolean", nullable: true)]
    private ?bool $esfactura;

    #[Column(type: "string", nullable: true)]
    private ?string $esprovedor;

    #[Column(type: "integer", nullable: true)]
    private ?int $codafip;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioalta;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechaalta;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuariomod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechaultmod;

    public function getCodnum(): int
    {
        return $this->codnum;
    }

    public function setCodnum(int $value): static
    {
        $this->codnum = $value;
        return $this;
    }

    public function getDescripcion(): string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(string $value): static
    {
        $this->descripcion = RemoveXss($value);
        return $this;
    }

    public function getActivo(): bool
    {
        return $this->activo;
    }

    public function setActivo(bool $value): static
    {
        $this->activo = $value;
        return $this;
    }

    public function getEsfactura(): ?bool
    {
        return $this->esfactura;
    }

    public function setEsfactura(?bool $value): static
    {
        $this->esfactura = $value;
        return $this;
    }

    public function getEsprovedor(): ?string
    {
        return HtmlDecode($this->esprovedor);
    }

    public function setEsprovedor(?string $value): static
    {
        $this->esprovedor = RemoveXss($value);
        return $this;
    }

    public function getCodafip(): ?int
    {
        return $this->codafip;
    }

    public function setCodafip(?int $value): static
    {
        $this->codafip = $value;
        return $this;
    }

    public function getUsuarioalta(): ?int
    {
        return $this->usuarioalta;
    }

    public function setUsuarioalta(?int $value): static
    {
        $this->usuarioalta = $value;
        return $this;
    }

    public function getFechaalta(): ?DateTime
    {
        return $this->fechaalta;
    }

    public function setFechaalta(?DateTime $value): static
    {
        $this->fechaalta = $value;
        return $this;
    }

    public function getUsuariomod(): ?int
    {
        return $this->usuariomod;
    }

    public function setUsuariomod(?int $value): static
    {
        $this->usuariomod = $value;
        return $this;
    }

    public function getFechaultmod(): ?DateTime
    {
        return $this->fechaultmod;
    }

    public function setFechaultmod(?DateTime $value): static
    {
        $this->fechaultmod = $value;
        return $this;
    }
}
