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
 * Entity class for "cartvalores" table
 */
#[Entity]
#[Table(name: "cartvalores")]
class Cartvalore extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'tcomp' => 'tcomp',
        'serie' => 'serie',
        'ncomp' => 'ncomp',
        'codban' => 'codban',
        'codsuc' => 'codsuc',
        'codcta' => 'codcta',
        'tipcta' => 'tipcta',
        'codchq' => 'codchq',
        'codpais' => 'codpais',
        'importe' => 'importe',
        'fechaemis' => 'fechaemis',
        'fechapago' => 'fechapago',
        'entrego' => 'entrego',
        'recibio' => 'recibio',
        'fechaingr' => 'fechaingr',
        'fechaentrega' => 'fechaentrega',
        'tcomprel' => 'tcomprel',
        'serierel' => 'serierel',
        'ncomprel' => 'ncomprel',
        'estado' => 'estado',
        'moneda' => 'moneda',
        'fechahora' => 'fechahora',
        'usuario' => 'usuario',
        'tcompsal' => 'tcompsal',
        'seriesal' => 'seriesal',
        'ncompsal' => 'ncompsal',
        'codrem' => 'codrem',
        'cotiz' => 'cotiz',
        'usurel' => 'usurel',
        'fecharel' => 'fecharel',
        'ususal' => 'ususal',
        'fechasal' => 'fechasal',
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
    private ?int $codban;

    #[Column(type: "integer", nullable: true)]
    private ?int $codsuc;

    #[Column(type: "string", nullable: true)]
    private ?string $codcta;

    #[Column(type: "string", nullable: true)]
    private ?string $tipcta;

    #[Column(type: "string", nullable: true)]
    private ?string $codchq;

    #[Column(type: "integer", nullable: true)]
    private ?int $codpais;

    #[Column(type: "decimal")]
    private string $importe = "0.00";

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fechaemis;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fechapago;

    #[Column(type: "integer", nullable: true)]
    private ?int $entrego;

    #[Column(type: "integer", nullable: true)]
    private ?int $recibio;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fechaingr;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fechaentrega;

    #[Column(type: "integer", nullable: true)]
    private ?int $tcomprel;

    #[Column(type: "integer", nullable: true)]
    private ?int $serierel;

    #[Column(type: "integer", nullable: true)]
    private ?int $ncomprel;

    #[Column(type: "string")]
    private string $estado;

    #[Column(type: "integer")]
    private int $moneda = 1;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "integer", nullable: true)]
    private ?int $tcompsal;

    #[Column(type: "integer", nullable: true)]
    private ?int $seriesal;

    #[Column(type: "integer", nullable: true)]
    private ?int $ncompsal;

    #[Column(type: "integer", nullable: true)]
    private ?int $codrem;

    #[Column(type: "float", nullable: true)]
    private ?float $cotiz;

    #[Column(type: "integer", nullable: true)]
    private ?int $usurel;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecharel;

    #[Column(type: "integer", nullable: true)]
    private ?int $ususal;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechasal;

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

    public function getCodban(): ?int
    {
        return $this->codban;
    }

    public function setCodban(?int $value): static
    {
        $this->codban = $value;
        return $this;
    }

    public function getCodsuc(): ?int
    {
        return $this->codsuc;
    }

    public function setCodsuc(?int $value): static
    {
        $this->codsuc = $value;
        return $this;
    }

    public function getCodcta(): ?string
    {
        return HtmlDecode($this->codcta);
    }

    public function setCodcta(?string $value): static
    {
        $this->codcta = RemoveXss($value);
        return $this;
    }

    public function getTipcta(): ?string
    {
        return HtmlDecode($this->tipcta);
    }

    public function setTipcta(?string $value): static
    {
        $this->tipcta = RemoveXss($value);
        return $this;
    }

    public function getCodchq(): ?string
    {
        return HtmlDecode($this->codchq);
    }

    public function setCodchq(?string $value): static
    {
        $this->codchq = RemoveXss($value);
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

    public function getImporte(): string
    {
        return $this->importe;
    }

    public function setImporte(string $value): static
    {
        $this->importe = $value;
        return $this;
    }

    public function getFechaemis(): ?DateTime
    {
        return $this->fechaemis;
    }

    public function setFechaemis(?DateTime $value): static
    {
        $this->fechaemis = $value;
        return $this;
    }

    public function getFechapago(): ?DateTime
    {
        return $this->fechapago;
    }

    public function setFechapago(?DateTime $value): static
    {
        $this->fechapago = $value;
        return $this;
    }

    public function getEntrego(): ?int
    {
        return $this->entrego;
    }

    public function setEntrego(?int $value): static
    {
        $this->entrego = $value;
        return $this;
    }

    public function getRecibio(): ?int
    {
        return $this->recibio;
    }

    public function setRecibio(?int $value): static
    {
        $this->recibio = $value;
        return $this;
    }

    public function getFechaingr(): ?DateTime
    {
        return $this->fechaingr;
    }

    public function setFechaingr(?DateTime $value): static
    {
        $this->fechaingr = $value;
        return $this;
    }

    public function getFechaentrega(): ?DateTime
    {
        return $this->fechaentrega;
    }

    public function setFechaentrega(?DateTime $value): static
    {
        $this->fechaentrega = $value;
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

    public function getEstado(): string
    {
        return HtmlDecode($this->estado);
    }

    public function setEstado(string $value): static
    {
        $this->estado = RemoveXss($value);
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

    public function getFechahora(): DateTime
    {
        return $this->fechahora;
    }

    public function setFechahora(DateTime $value): static
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

    public function getTcompsal(): ?int
    {
        return $this->tcompsal;
    }

    public function setTcompsal(?int $value): static
    {
        $this->tcompsal = $value;
        return $this;
    }

    public function getSeriesal(): ?int
    {
        return $this->seriesal;
    }

    public function setSeriesal(?int $value): static
    {
        $this->seriesal = $value;
        return $this;
    }

    public function getNcompsal(): ?int
    {
        return $this->ncompsal;
    }

    public function setNcompsal(?int $value): static
    {
        $this->ncompsal = $value;
        return $this;
    }

    public function getCodrem(): ?int
    {
        return $this->codrem;
    }

    public function setCodrem(?int $value): static
    {
        $this->codrem = $value;
        return $this;
    }

    public function getCotiz(): ?float
    {
        return $this->cotiz;
    }

    public function setCotiz(?float $value): static
    {
        $this->cotiz = $value;
        return $this;
    }

    public function getUsurel(): ?int
    {
        return $this->usurel;
    }

    public function setUsurel(?int $value): static
    {
        $this->usurel = $value;
        return $this;
    }

    public function getFecharel(): ?DateTime
    {
        return $this->fecharel;
    }

    public function setFecharel(?DateTime $value): static
    {
        $this->fecharel = $value;
        return $this;
    }

    public function getUsusal(): ?int
    {
        return $this->ususal;
    }

    public function setUsusal(?int $value): static
    {
        $this->ususal = $value;
        return $this;
    }

    public function getFechasal(): ?DateTime
    {
        return $this->fechasal;
    }

    public function setFechasal(?DateTime $value): static
    {
        $this->fechasal = $value;
        return $this;
    }
}
