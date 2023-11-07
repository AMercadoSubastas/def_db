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
 * Entity class for "bancos" table
 */
#[Entity]
#[Table(name: "bancos")]
class Banco extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'codbanco' => 'codbanco',
        'nombre' => 'nombre',
        'codpais' => 'codpais',
        'activo' => 'activo',
    ];

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $codbanco;

    #[Column(type: "string")]
    private string $nombre;

    #[Column(type: "integer")]
    private int $codpais;

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

    public function getCodbanco(): string
    {
        return HtmlDecode($this->codbanco);
    }

    public function setCodbanco(string $value): static
    {
        $this->codbanco = RemoveXss($value);
        return $this;
    }

    public function getNombre(): string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getCodpais(): int
    {
        return $this->codpais;
    }

    public function setCodpais(int $value): static
    {
        $this->codpais = $value;
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
