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
 * Entity class for "cabrecibo" table
 */
#[Entity]
#[Table(name: "cabrecibo")]
class Cabrecibo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $tcomp;

    #[Column(type: "integer")]
    private int $serie;

    #[Column(type: "integer")]
    private int $ncomp;

    #[Column(type: "integer")]
    private int $cantcbtes;

    #[Column(type: "date")]
    private DateTime $fecha;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer")]
    private int $cliente;

    #[Column(type: "decimal")]
    private string $imptot;

    #[Column(type: "boolean")]
    private bool $emitido;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecultmod;

    public function __construct()
    {
        $this->emitido = false;
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

    public function getTcomp(): int
    {
        return $this->tcomp;
    }

    public function setTcomp(int $value): static
    {
        $this->tcomp = $value;
        return $this;
    }

    public function getSerie(): int
    {
        return $this->serie;
    }

    public function setSerie(int $value): static
    {
        $this->serie = $value;
        return $this;
    }

    public function getNcomp(): int
    {
        return $this->ncomp;
    }

    public function setNcomp(int $value): static
    {
        $this->ncomp = $value;
        return $this;
    }

    public function getCantcbtes(): int
    {
        return $this->cantcbtes;
    }

    public function setCantcbtes(int $value): static
    {
        $this->cantcbtes = $value;
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $value): static
    {
        $this->fecha = $value;
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

    public function getCliente(): int
    {
        return $this->cliente;
    }

    public function setCliente(int $value): static
    {
        $this->cliente = $value;
        return $this;
    }

    public function getImptot(): string
    {
        return $this->imptot;
    }

    public function setImptot(string $value): static
    {
        $this->imptot = $value;
        return $this;
    }

    public function getEmitido(): bool
    {
        return $this->emitido;
    }

    public function setEmitido(bool $value): static
    {
        $this->emitido = $value;
        return $this;
    }

    public function getUsuarioultmod(): ?int
    {
        return $this->usuarioultmod;
    }

    public function setUsuarioultmod(?int $value): static
    {
        $this->usuarioultmod = $value;
        return $this;
    }

    public function getFecultmod(): ?DateTime
    {
        return $this->fecultmod;
    }

    public function setFecultmod(?DateTime $value): static
    {
        $this->fecultmod = $value;
        return $this;
    }
}
