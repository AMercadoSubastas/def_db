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
 * Entity class for "impuestos" table
 */
#[Entity]
#[Table(name: "impuestos")]
class Impuesto extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "float")]
    private float $porcen;

    #[Column(type: "string")]
    private string $descripcion;

    #[Column(type: "boolean")]
    private bool $rangos;

    #[Column(type: "float")]
    private float $montomin;

    #[Column(type: "integer")]
    private int $activo;

    public function __construct()
    {
        $this->rangos = false;
        $this->montomin = 0;
        $this->activo = 1;
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

    public function getPorcen(): float
    {
        return $this->porcen;
    }

    public function setPorcen(float $value): static
    {
        $this->porcen = $value;
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

    public function getRangos(): bool
    {
        return $this->rangos;
    }

    public function setRangos(bool $value): static
    {
        $this->rangos = $value;
        return $this;
    }

    public function getMontomin(): float
    {
        return $this->montomin;
    }

    public function setMontomin(float $value): static
    {
        $this->montomin = $value;
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
}
