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
 * Entity class for "lotes" table
 */
#[Entity]
#[Table(name: "lotes")]
class Lote extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "integer")]
    private int $codrem;

    #[Column(type: "integer", nullable: true)]
    private ?int $codcli;

    #[Column(type: "integer", nullable: true)]
    private ?int $codrubro;

    #[Column(type: "integer")]
    private int $estado;

    #[Column(type: "integer")]
    private int $moneda;

    #[Column(type: "float", nullable: true)]
    private ?float $preciobase;

    #[Column(type: "float", nullable: true)]
    private ?float $preciofinal;

    #[Column(type: "float", nullable: true)]
    private ?float $comiscobr;

    #[Column(type: "float", nullable: true)]
    private ?float $comispag;

    #[Column(type: "integer", nullable: true)]
    private ?int $comprador;

    #[Column(type: "float", nullable: true)]
    private ?float $ivari;

    #[Column(type: "float", nullable: true)]
    private ?float $ivarni;

    #[Column(type: "integer", nullable: true)]
    private ?int $codimpadic;

    #[Column(type: "float", nullable: true)]
    private ?float $impadic;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "string", nullable: true)]
    private ?string $descor;

    #[Column(type: "string", nullable: true)]
    private ?string $observ;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "datetime")]
    private DateTime $fecalta;

    #[Column(type: "integer")]
    private int $secuencia;

    #[Column(type: "string")]
    private string $codintlote;

    #[Column(type: "integer")]
    private int $codintnum;

    #[Column(type: "string", nullable: true)]
    private ?string $codintsublote;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecultmod;

    #[Column(name: "dir_secuencia", type: "integer", nullable: true)]
    private ?int $dirSecuencia;

    public function __construct()
    {
        $this->estado = 0;
        $this->moneda = 1;
        $this->preciobase = 0;
        $this->preciofinal = 0;
        $this->comiscobr = 10;
        $this->comispag = 0;
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

    public function getCodrem(): int
    {
        return $this->codrem;
    }

    public function setCodrem(int $value): static
    {
        $this->codrem = $value;
        return $this;
    }

    public function getCodcli(): ?int
    {
        return $this->codcli;
    }

    public function setCodcli(?int $value): static
    {
        $this->codcli = $value;
        return $this;
    }

    public function getCodrubro(): ?int
    {
        return $this->codrubro;
    }

    public function setCodrubro(?int $value): static
    {
        $this->codrubro = $value;
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

    public function getMoneda(): int
    {
        return $this->moneda;
    }

    public function setMoneda(int $value): static
    {
        $this->moneda = $value;
        return $this;
    }

    public function getPreciobase(): ?float
    {
        return $this->preciobase;
    }

    public function setPreciobase(?float $value): static
    {
        $this->preciobase = $value;
        return $this;
    }

    public function getPreciofinal(): ?float
    {
        return $this->preciofinal;
    }

    public function setPreciofinal(?float $value): static
    {
        $this->preciofinal = $value;
        return $this;
    }

    public function getComiscobr(): ?float
    {
        return $this->comiscobr;
    }

    public function setComiscobr(?float $value): static
    {
        $this->comiscobr = $value;
        return $this;
    }

    public function getComispag(): ?float
    {
        return $this->comispag;
    }

    public function setComispag(?float $value): static
    {
        $this->comispag = $value;
        return $this;
    }

    public function getComprador(): ?int
    {
        return $this->comprador;
    }

    public function setComprador(?int $value): static
    {
        $this->comprador = $value;
        return $this;
    }

    public function getIvari(): ?float
    {
        return $this->ivari;
    }

    public function setIvari(?float $value): static
    {
        $this->ivari = $value;
        return $this;
    }

    public function getIvarni(): ?float
    {
        return $this->ivarni;
    }

    public function setIvarni(?float $value): static
    {
        $this->ivarni = $value;
        return $this;
    }

    public function getCodimpadic(): ?int
    {
        return $this->codimpadic;
    }

    public function setCodimpadic(?int $value): static
    {
        $this->codimpadic = $value;
        return $this;
    }

    public function getImpadic(): ?float
    {
        return $this->impadic;
    }

    public function setImpadic(?float $value): static
    {
        $this->impadic = $value;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
        return $this;
    }

    public function getDescor(): ?string
    {
        return HtmlDecode($this->descor);
    }

    public function setDescor(?string $value): static
    {
        $this->descor = RemoveXss($value);
        return $this;
    }

    public function getObserv(): ?string
    {
        return HtmlDecode($this->observ);
    }

    public function setObserv(?string $value): static
    {
        $this->observ = RemoveXss($value);
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

    public function getSecuencia(): int
    {
        return $this->secuencia;
    }

    public function setSecuencia(int $value): static
    {
        $this->secuencia = $value;
        return $this;
    }

    public function getCodintlote(): string
    {
        return HtmlDecode($this->codintlote);
    }

    public function setCodintlote(string $value): static
    {
        $this->codintlote = RemoveXss($value);
        return $this;
    }

    public function getCodintnum(): int
    {
        return $this->codintnum;
    }

    public function setCodintnum(int $value): static
    {
        $this->codintnum = $value;
        return $this;
    }

    public function getCodintsublote(): ?string
    {
        return HtmlDecode($this->codintsublote);
    }

    public function setCodintsublote(?string $value): static
    {
        $this->codintsublote = RemoveXss($value);
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

    public function getDirSecuencia(): ?int
    {
        return $this->dirSecuencia;
    }

    public function setDirSecuencia(?int $value): static
    {
        $this->dirSecuencia = $value;
        return $this;
    }
}
