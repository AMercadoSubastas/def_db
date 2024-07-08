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
 * Entity class for "tipoiva" table
 */
#[Entity]
#[Table(name: "tipoiva")]
class Tipoiva extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $descor;

    #[Column(type: "string")]
    private string $descrip;

    #[Column(type: "boolean")]
    private bool $discrimina;

    #[Column(type: "integer")]
    private int $activo;

    public function __construct()
    {
        $this->discrimina = true;
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

    public function getDiscrimina(): bool
    {
        return $this->discrimina;
    }

    public function setDiscrimina(bool $value): static
    {
        $this->discrimina = $value;
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
