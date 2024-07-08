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
 * Entity class for "remates" table
 */
#[Entity]
#[Table(name: "remates")]
class Remate extends AbstractEntity
{
    #[Column(type: "integer")]
    private int $ncomp;

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $tcomp;

    #[Column(type: "integer")]
    private int $serie;

    #[Column(type: "integer")]
    private int $codcli;

    #[Column(type: "string")]
    private string $direccion;

    #[Column(type: "integer", nullable: true)]
    private ?int $codpais;

    #[Column(type: "integer")]
    private int $codprov;

    #[Column(type: "integer", nullable: true)]
    private ?int $codloc;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecest;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecreal;

    #[Column(type: "float", nullable: true)]
    private ?float $imptot;

    #[Column(type: "float", nullable: true)]
    private ?float $impbase;

    #[Column(type: "integer")]
    private int $estado;

    #[Column(type: "integer")]
    private int $cantlotes;

    #[Column(type: "time", nullable: true)]
    private ?DateTime $horaest;

    #[Column(type: "time", nullable: true)]
    private ?DateTime $horareal;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "datetime")]
    private DateTime $fecalta;

    #[Column(type: "string", nullable: true)]
    private ?string $observacion;

    #[Column(type: "integer")]
    private int $tipoind;

    #[Column(type: "integer", nullable: true)]
    private ?int $sello;

    #[Column(name: "plazoSAP", type: "string", nullable: true)]
    private ?string $plazoSap;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecultmod;

    #[Column(type: "float", nullable: true)]
    private ?float $servicios;

    #[Column(type: "float", nullable: true)]
    private ?float $gastos;

    #[Column(type: "boolean")]
    private bool $tasa;

    public function __construct()
    {
        $this->codcli = 940;
        $this->codpais = 1;
        $this->estado = 0;
        $this->sello = 0;
        $this->tasa = true;
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

    public function getCodcli(): int
    {
        return $this->codcli;
    }

    public function setCodcli(int $value): static
    {
        $this->codcli = $value;
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

    public function getCodpais(): ?int
    {
        return $this->codpais;
    }

    public function setCodpais(?int $value): static
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

    public function getCodloc(): ?int
    {
        return $this->codloc;
    }

    public function setCodloc(?int $value): static
    {
        $this->codloc = $value;
        return $this;
    }

    public function getFecest(): ?DateTime
    {
        return $this->fecest;
    }

    public function setFecest(?DateTime $value): static
    {
        $this->fecest = $value;
        return $this;
    }

    public function getFecreal(): ?DateTime
    {
        return $this->fecreal;
    }

    public function setFecreal(?DateTime $value): static
    {
        $this->fecreal = $value;
        return $this;
    }

    public function getImptot(): ?float
    {
        return $this->imptot;
    }

    public function setImptot(?float $value): static
    {
        $this->imptot = $value;
        return $this;
    }

    public function getImpbase(): ?float
    {
        return $this->impbase;
    }

    public function setImpbase(?float $value): static
    {
        $this->impbase = $value;
        return $this;
    }

    public function getEstado(): int
    {
        return $this->estado;
    }

    public function setEstado(int $value): static
    {
        $this->estado = $value;
        return $this;
    }

    public function getCantlotes(): int
    {
        return $this->cantlotes;
    }

    public function setCantlotes(int $value): static
    {
        $this->cantlotes = $value;
        return $this;
    }

    public function getHoraest(): ?DateTime
    {
        return $this->horaest;
    }

    public function setHoraest(?DateTime $value): static
    {
        $this->horaest = $value;
        return $this;
    }

    public function getHorareal(): ?DateTime
    {
        return $this->horareal;
    }

    public function setHorareal(?DateTime $value): static
    {
        $this->horareal = $value;
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

    public function getFecalta(): DateTime
    {
        return $this->fecalta;
    }

    public function setFecalta(DateTime $value): static
    {
        $this->fecalta = $value;
        return $this;
    }

    public function getObservacion(): ?string
    {
        return HtmlDecode($this->observacion);
    }

    public function setObservacion(?string $value): static
    {
        $this->observacion = RemoveXss($value);
        return $this;
    }

    public function getTipoind(): int
    {
        return $this->tipoind;
    }

    public function setTipoind(int $value): static
    {
        $this->tipoind = $value;
        return $this;
    }

    public function getSello(): ?int
    {
        return $this->sello;
    }

    public function setSello(?int $value): static
    {
        $this->sello = $value;
        return $this;
    }

    public function getPlazoSap(): ?string
    {
        return HtmlDecode($this->plazoSap);
    }

    public function setPlazoSap(?string $value): static
    {
        $this->plazoSap = RemoveXss($value);
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

    public function getServicios(): ?float
    {
        return $this->servicios;
    }

    public function setServicios(?float $value): static
    {
        $this->servicios = $value;
        return $this;
    }

    public function getGastos(): ?float
    {
        return $this->gastos;
    }

    public function setGastos(?float $value): static
    {
        $this->gastos = $value;
        return $this;
    }

    public function getTasa(): bool
    {
        return $this->tasa;
    }

    public function setTasa(bool $value): static
    {
        $this->tasa = $value;
        return $this;
    }
}
