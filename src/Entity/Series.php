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
 * Entity class for "series" table
 */
#[Entity]
#[Table(name: "series")]
class Series extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $tipcomp;

    #[Column(type: "string")]
    private string $descripcion;

    #[Column(type: "integer")]
    private int $nrodesde;

    #[Column(type: "integer")]
    private int $nrohasta;

    #[Column(type: "integer")]
    private int $nroact;

    #[Column(type: "string", nullable: true)]
    private ?string $mascara;

    #[Column(type: "boolean")]
    private bool $activo;

    #[Column(type: "boolean")]
    private bool $automatica;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fechatope;

    public function __construct()
    {
        $this->activo = true;
        $this->automatica = false;
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

    public function getTipcomp(): int
    {
        return $this->tipcomp;
    }

    public function setTipcomp(int $value): static
    {
        $this->tipcomp = $value;
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

    public function getNrodesde(): int
    {
        return $this->nrodesde;
    }

    public function setNrodesde(int $value): static
    {
        $this->nrodesde = $value;
        return $this;
    }

    public function getNrohasta(): int
    {
        return $this->nrohasta;
    }

    public function setNrohasta(int $value): static
    {
        $this->nrohasta = $value;
        return $this;
    }

    public function getNroact(): int
    {
        return $this->nroact;
    }

    public function setNroact(int $value): static
    {
        $this->nroact = $value;
        return $this;
    }

    public function getMascara(): ?string
    {
        return HtmlDecode($this->mascara);
    }

    public function setMascara(?string $value): static
    {
        $this->mascara = RemoveXss($value);
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

    public function getAutomatica(): bool
    {
        return $this->automatica;
    }

    public function setAutomatica(bool $value): static
    {
        $this->automatica = $value;
        return $this;
    }

    public function getFechatope(): ?DateTime
    {
        return $this->fechatope;
    }

    public function setFechatope(?DateTime $value): static
    {
        $this->fechatope = $value;
        return $this;
    }
}
