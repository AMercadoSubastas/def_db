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
 * Entity class for "formapago" table
 */
#[Entity]
#[Table(name: "formapago")]
class Formapago extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'descripcion' => 'descripcion',
        'porcrecargo' => 'porcrecargo',
        'usuario' => 'usuario',
        'activo' => 'activo',
    ];

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $descripcion;

    #[Column(type: "float")]
    private float $porcrecargo = 0;

    #[Column(type: "integer")]
    private int $usuario;

    #[Column(type: "boolean")]
    private bool $activo = true;

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

    public function getPorcrecargo(): float
    {
        return $this->porcrecargo;
    }

    public function setPorcrecargo(float $value): static
    {
        $this->porcrecargo = $value;
        return $this;
    }

    public function getUsuario(): int
    {
        return $this->usuario;
    }

    public function setUsuario(int $value): static
    {
        $this->usuario = $value;
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
