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
 * Entity class for "monedas" table
 */
#[Entity]
#[Table(name: "monedas")]
class Moneda extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'descor' => 'descor',
        'descrip' => 'descrip',
        'activo' => 'activo',
    ];

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $descor;

    #[Column(type: "string")]
    private string $descrip;

    #[Column(type: "boolean")]
    private bool $activo;

    public function getCodnum(): int
    {
        return $this->codnum;
    }

    public function setCodnum(int $value): static
    {
        $this->codnum = $value;
        return $this;
    }

    public function getDescor(): string
    {
        return HtmlDecode($this->descor);
    }

    public function setDescor(string $value): static
    {
        $this->descor = RemoveXss($value);
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
