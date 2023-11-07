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
 * Entity class for "imprangos" table
 */
#[Entity]
#[Table(name: "imprangos")]
class Imprango extends AbstractEntity
{
    public static array $propertyNames = [
        'codimp' => 'codimp',
        'secuencia' => 'secuencia',
        'monto_min' => 'montoMin',
        'monto_max' => 'montoMax',
        'porcentaje' => 'porcentaje',
        'monto_fijo' => 'montoFijo',
        'activo' => 'activo',
    ];

    #[Id]
    #[Column(type: "integer")]
    private int $codimp;

    #[Id]
    #[Column(type: "integer")]
    private int $secuencia;

    #[Column(name: "monto_min", type: "float")]
    private float $montoMin = 0;

    #[Column(name: "monto_max", type: "float")]
    private float $montoMax = 0;

    #[Column(type: "float", nullable: true)]
    private ?float $porcentaje;

    #[Column(name: "monto_fijo", type: "float", nullable: true)]
    private ?float $montoFijo;

    #[Column(type: "boolean")]
    private bool $activo = true;

    public function __construct(int $codimp, int $secuencia)
    {
        $this->codimp = $codimp;
        $this->secuencia = $secuencia;
    }

    public function getCodimp(): int
    {
        return $this->codimp;
    }

    public function setCodimp(int $value): static
    {
        $this->codimp = $value;
        return $this;
    }

    public function getSecuencia(): int
    {
        return $this->secuencia;
    }

    public function setSecuencia(int $value): static
    {
        $this->secuencia = $value;
        return $this;
    }

    public function getMontoMin(): float
    {
        return $this->montoMin;
    }

    public function setMontoMin(float $value): static
    {
        $this->montoMin = $value;
        return $this;
    }

    public function getMontoMax(): float
    {
        return $this->montoMax;
    }

    public function setMontoMax(float $value): static
    {
        $this->montoMax = $value;
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

    public function getMontoFijo(): ?float
    {
        return $this->montoFijo;
    }

    public function setMontoFijo(?float $value): static
    {
        $this->montoFijo = $value;
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
}
