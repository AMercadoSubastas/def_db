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
 * Entity class for "dir_remates" table
 */
#[Entity]
#[Table(name: "dir_remates")]
class DirRemate extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codigo;

    #[Column(type: "integer")]
    private int $codrem;

    #[Column(type: "integer")]
    private int $secuencia;

    #[Column(type: "string")]
    private string $direccion;

    #[Column(type: "integer")]
    private int $codpais;

    #[Column(type: "integer")]
    private int $codprov;

    #[Column(type: "integer")]
    private int $codloc;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioalta;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechaalta;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuariomod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechaultmod;

    public function getCodigo(): int
    {
        return $this->codigo;
    }

    public function setCodigo(int $value): static
    {
        $this->codigo = $value;
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

    public function getSecuencia(): int
    {
        return $this->secuencia;
    }

    public function setSecuencia(int $value): static
    {
        $this->secuencia = $value;
        return $this;
    }

    public function getDireccion(): string
    {
        return HtmlDecode($this->direccion);
    }

    public function setDireccion(string $value): static
    {
        $this->direccion = RemoveXss($value);
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

    public function getCodprov(): int
    {
        return $this->codprov;
    }

    public function setCodprov(int $value): static
    {
        $this->codprov = $value;
        return $this;
    }

    public function getCodloc(): int
    {
        return $this->codloc;
    }

    public function setCodloc(int $value): static
    {
        $this->codloc = $value;
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
