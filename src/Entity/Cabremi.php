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
 * Entity class for "cabremi" table
 */
#[Entity]
#[Table(name: "cabremi")]
class Cabremi extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'tcomp' => 'tcomp',
        'serie' => 'serie',
        'ncomp' => 'ncomp',
        'cantrengs' => 'cantrengs',
        'comprador' => 'comprador',
        'fecharemi' => 'fecharemi',
        'observaciones' => 'observaciones',
        'calle' => 'calle',
        'numero' => 'numero',
        'pisodto' => 'pisodto',
        'codpais' => 'codpais',
        'codprov' => 'codprov',
        'codloc' => 'codloc',
        'codpost' => 'codpost',
        'patente' => 'patente',
        'patremolque' => 'patremolque',
        'cuit' => 'cuit',
        'fechahora' => 'fechahora',
        'usuario' => 'usuario',
        'tcomprel' => 'tcomprel',
        'serierel' => 'serierel',
        'ncomprel' => 'ncomprel',
        'usuarioultmod' => 'usuarioultmod',
        'fechaultmod' => 'fechaultmod',
    ];

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

    #[Column(type: "integer", nullable: true)]
    private ?int $cantrengs;

    #[Column(type: "integer", nullable: true)]
    private ?int $comprador;

    #[Column(type: "date")]
    private DateTime $fecharemi;

    #[Column(type: "string", nullable: true)]
    private ?string $observaciones;

    #[Column(type: "string", nullable: true)]
    private ?string $calle;

    #[Column(type: "string", nullable: true)]
    private ?string $numero;

    #[Column(type: "string", nullable: true)]
    private ?string $pisodto;

    #[Column(type: "integer", nullable: true)]
    private ?int $codpais;

    #[Column(type: "integer", nullable: true)]
    private ?int $codprov;

    #[Column(type: "integer", nullable: true)]
    private ?int $codloc;

    #[Column(type: "string", nullable: true)]
    private ?string $codpost;

    #[Column(type: "string", nullable: true)]
    private ?string $patente;

    #[Column(type: "string", nullable: true)]
    private ?string $patremolque;

    #[Column(type: "string", nullable: true)]
    private ?string $cuit;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechahora;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "integer", nullable: true)]
    private ?int $tcomprel;

    #[Column(type: "integer", nullable: true)]
    private ?int $serierel;

    #[Column(type: "integer", nullable: true)]
    private ?int $ncomprel;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechaultmod;

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

    public function getCantrengs(): ?int
    {
        return $this->cantrengs;
    }

    public function setCantrengs(?int $value): static
    {
        $this->cantrengs = $value;
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

    public function getFecharemi(): DateTime
    {
        return $this->fecharemi;
    }

    public function setFecharemi(DateTime $value): static
    {
        $this->fecharemi = $value;
        return $this;
    }

    public function getObservaciones(): ?string
    {
        return HtmlDecode($this->observaciones);
    }

    public function setObservaciones(?string $value): static
    {
        $this->observaciones = RemoveXss($value);
        return $this;
    }

    public function getCalle(): ?string
    {
        return HtmlDecode($this->calle);
    }

    public function setCalle(?string $value): static
    {
        $this->calle = RemoveXss($value);
        return $this;
    }

    public function getNumero(): ?string
    {
        return HtmlDecode($this->numero);
    }

    public function setNumero(?string $value): static
    {
        $this->numero = RemoveXss($value);
        return $this;
    }

    public function getPisodto(): ?string
    {
        return HtmlDecode($this->pisodto);
    }

    public function setPisodto(?string $value): static
    {
        $this->pisodto = RemoveXss($value);
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

    public function getCodprov(): ?int
    {
        return $this->codprov;
    }

    public function setCodprov(?int $value): static
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

    public function getCodpost(): ?string
    {
        return HtmlDecode($this->codpost);
    }

    public function setCodpost(?string $value): static
    {
        $this->codpost = RemoveXss($value);
        return $this;
    }

    public function getPatente(): ?string
    {
        return HtmlDecode($this->patente);
    }

    public function setPatente(?string $value): static
    {
        $this->patente = RemoveXss($value);
        return $this;
    }

    public function getPatremolque(): ?string
    {
        return HtmlDecode($this->patremolque);
    }

    public function setPatremolque(?string $value): static
    {
        $this->patremolque = RemoveXss($value);
        return $this;
    }

    public function getCuit(): ?string
    {
        return HtmlDecode($this->cuit);
    }

    public function setCuit(?string $value): static
    {
        $this->cuit = RemoveXss($value);
        return $this;
    }

    public function getFechahora(): ?DateTime
    {
        return $this->fechahora;
    }

    public function setFechahora(?DateTime $value): static
    {
        $this->fechahora = $value;
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

    public function getTcomprel(): ?int
    {
        return $this->tcomprel;
    }

    public function setTcomprel(?int $value): static
    {
        $this->tcomprel = $value;
        return $this;
    }

    public function getSerierel(): ?int
    {
        return $this->serierel;
    }

    public function setSerierel(?int $value): static
    {
        $this->serierel = $value;
        return $this;
    }

    public function getNcomprel(): ?int
    {
        return $this->ncomprel;
    }

    public function setNcomprel(?int $value): static
    {
        $this->ncomprel = $value;
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
