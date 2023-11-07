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
 * Entity class for "cabfac" table
 */
#[Entity]
#[Table(name: "cabfac")]
class Cabfac extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'tcomp' => 'tcomp',
        'serie' => 'serie',
        'ncomp' => 'ncomp',
        'fecval' => 'fecval',
        'fecdoc' => 'fecdoc',
        'fecreg' => 'fecreg',
        'cliente' => 'cliente',
        'cpago' => 'cpago',
        'fecvenc' => 'fecvenc',
        'direc' => 'direc',
        'dnro' => 'dnro',
        'pisodto' => 'pisodto',
        'codpost' => 'codpost',
        'codpais' => 'codpais',
        'codprov' => 'codprov',
        'codloc' => 'codloc',
        'telef' => 'telef',
        'codrem' => 'codrem',
        'estado' => 'estado',
        'emitido' => 'emitido',
        'moneda' => 'moneda',
        'totneto' => 'totneto',
        'totbruto' => 'totbruto',
        'totiva105' => 'totiva105',
        'totiva21' => 'totiva21',
        'totimp' => 'totimp',
        'totcomis' => 'totcomis',
        'totneto105' => 'totneto105',
        'totneto21' => 'totneto21',
        'tipoiva' => 'tipoiva',
        'porciva' => 'porciva',
        'nrengs' => 'nrengs',
        'fechahora' => 'fechahora',
        'usuario' => 'usuario',
        'tieneresol' => 'tieneresol',
        'leyendafc' => 'leyendafc',
        'concepto' => 'concepto',
        'nrodoc' => 'nrodoc',
        'tcompsal' => 'tcompsal',
        'seriesal' => 'seriesal',
        'ncompsal' => 'ncompsal',
        'en_liquid' => 'enLiquid',
        'CAE' => 'cae',
        'CAEFchVto' => 'caeFchVto',
        'Resultado' => 'resultado',
        'usuarioultmod' => 'usuarioultmod',
        'fecultmod' => 'fecultmod',
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

    #[Column(type: "date")]
    private DateTime $fecval;

    #[Column(type: "date")]
    private DateTime $fecdoc;

    #[Column(type: "date")]
    private DateTime $fecreg;

    #[Column(type: "integer", nullable: true)]
    private ?int $cliente;

    #[Column(type: "integer", nullable: true)]
    private ?int $cpago;

    #[Column(type: "date")]
    private DateTime $fecvenc;

    #[Column(type: "string", nullable: true)]
    private ?string $direc;

    #[Column(type: "string", nullable: true)]
    private ?string $dnro;

    #[Column(type: "string", nullable: true)]
    private ?string $pisodto;

    #[Column(type: "string", nullable: true)]
    private ?string $codpost;

    #[Column(type: "integer", nullable: true)]
    private ?int $codpais;

    #[Column(type: "integer", nullable: true)]
    private ?int $codprov;

    #[Column(type: "integer", nullable: true)]
    private ?int $codloc;

    #[Column(type: "string", nullable: true)]
    private ?string $telef;

    #[Column(type: "integer", nullable: true)]
    private ?int $codrem;

    #[Column(type: "string", nullable: true)]
    private ?string $estado;

    #[Column(type: "boolean", nullable: true)]
    private ?bool $emitido;

    #[Column(type: "integer", nullable: true)]
    private ?int $moneda = 0;

    #[Column(type: "decimal", nullable: true)]
    private ?string $totneto = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totbruto = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totiva105 = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totiva21 = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totimp = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totcomis = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totneto105 = "0.00";

    #[Column(type: "decimal", nullable: true)]
    private ?string $totneto21 = "0.00";

    #[Column(type: "integer", nullable: true)]
    private ?int $tipoiva = 0;

    #[Column(type: "float", nullable: true)]
    private ?float $porciva = 0;

    #[Column(type: "integer", nullable: true)]
    private ?int $nrengs;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer")]
    private int $usuario = 1;

    #[Column(type: "boolean", nullable: true)]
    private ?bool $tieneresol = false;

    #[Column(type: "string", nullable: true)]
    private ?string $leyendafc;

    #[Column(type: "string", nullable: true)]
    private ?string $concepto;

    #[Column(type: "string", nullable: true)]
    private ?string $nrodoc;

    #[Column(type: "integer", nullable: true)]
    private ?int $tcompsal;

    #[Column(type: "integer", nullable: true)]
    private ?int $seriesal;

    #[Column(type: "integer", nullable: true)]
    private ?int $ncompsal;

    #[Column(name: "en_liquid", type: "integer", nullable: true)]
    private ?int $enLiquid;

    #[Column(name: "CAE", type: "bigint", nullable: true)]
    private ?string $cae;

    #[Column(name: "CAEFchVto", type: "date", nullable: true)]
    private ?DateTime $caeFchVto;

    #[Column(name: "Resultado", type: "string", nullable: true)]
    private ?string $resultado;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuarioultmod;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecultmod;

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

    public function getFecval(): DateTime
    {
        return $this->fecval;
    }

    public function setFecval(DateTime $value): static
    {
        $this->fecval = $value;
        return $this;
    }

    public function getFecdoc(): DateTime
    {
        return $this->fecdoc;
    }

    public function setFecdoc(DateTime $value): static
    {
        $this->fecdoc = $value;
        return $this;
    }

    public function getFecreg(): DateTime
    {
        return $this->fecreg;
    }

    public function setFecreg(DateTime $value): static
    {
        $this->fecreg = $value;
        return $this;
    }

    public function getCliente(): ?int
    {
        return $this->cliente;
    }

    public function setCliente(?int $value): static
    {
        $this->cliente = $value;
        return $this;
    }

    public function getCpago(): ?int
    {
        return $this->cpago;
    }

    public function setCpago(?int $value): static
    {
        $this->cpago = $value;
        return $this;
    }

    public function getFecvenc(): DateTime
    {
        return $this->fecvenc;
    }

    public function setFecvenc(DateTime $value): static
    {
        $this->fecvenc = $value;
        return $this;
    }

    public function getDirec(): ?string
    {
        return HtmlDecode($this->direc);
    }

    public function setDirec(?string $value): static
    {
        $this->direc = RemoveXss($value);
        return $this;
    }

    public function getDnro(): ?string
    {
        return HtmlDecode($this->dnro);
    }

    public function setDnro(?string $value): static
    {
        $this->dnro = RemoveXss($value);
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

    public function getCodpost(): ?string
    {
        return HtmlDecode($this->codpost);
    }

    public function setCodpost(?string $value): static
    {
        $this->codpost = RemoveXss($value);
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

    public function getTelef(): ?string
    {
        return HtmlDecode($this->telef);
    }

    public function setTelef(?string $value): static
    {
        $this->telef = RemoveXss($value);
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

    public function getEstado(): ?string
    {
        return HtmlDecode($this->estado);
    }

    public function setEstado(?string $value): static
    {
        $this->estado = RemoveXss($value);
        return $this;
    }

    public function getEmitido(): ?bool
    {
        return $this->emitido;
    }

    public function setEmitido(?bool $value): static
    {
        $this->emitido = $value;
        return $this;
    }

    public function getMoneda(): ?int
    {
        return $this->moneda;
    }

    public function setMoneda(?int $value): static
    {
        $this->moneda = $value;
        return $this;
    }

    public function getTotneto(): ?string
    {
        return $this->totneto;
    }

    public function setTotneto(?string $value): static
    {
        $this->totneto = $value;
        return $this;
    }

    public function getTotbruto(): ?string
    {
        return $this->totbruto;
    }

    public function setTotbruto(?string $value): static
    {
        $this->totbruto = $value;
        return $this;
    }

    public function getTotiva105(): ?string
    {
        return $this->totiva105;
    }

    public function setTotiva105(?string $value): static
    {
        $this->totiva105 = $value;
        return $this;
    }

    public function getTotiva21(): ?string
    {
        return $this->totiva21;
    }

    public function setTotiva21(?string $value): static
    {
        $this->totiva21 = $value;
        return $this;
    }

    public function getTotimp(): ?string
    {
        return $this->totimp;
    }

    public function setTotimp(?string $value): static
    {
        $this->totimp = $value;
        return $this;
    }

    public function getTotcomis(): ?string
    {
        return $this->totcomis;
    }

    public function setTotcomis(?string $value): static
    {
        $this->totcomis = $value;
        return $this;
    }

    public function getTotneto105(): ?string
    {
        return $this->totneto105;
    }

    public function setTotneto105(?string $value): static
    {
        $this->totneto105 = $value;
        return $this;
    }

    public function getTotneto21(): ?string
    {
        return $this->totneto21;
    }

    public function setTotneto21(?string $value): static
    {
        $this->totneto21 = $value;
        return $this;
    }

    public function getTipoiva(): ?int
    {
        return $this->tipoiva;
    }

    public function setTipoiva(?int $value): static
    {
        $this->tipoiva = $value;
        return $this;
    }

    public function getPorciva(): ?float
    {
        return $this->porciva;
    }

    public function setPorciva(?float $value): static
    {
        $this->porciva = $value;
        return $this;
    }

    public function getNrengs(): ?int
    {
        return $this->nrengs;
    }

    public function setNrengs(?int $value): static
    {
        $this->nrengs = $value;
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

    public function getUsuario(): int
    {
        return $this->usuario;
    }

    public function setUsuario(int $value): static
    {
        $this->usuario = $value;
        return $this;
    }

    public function getTieneresol(): ?bool
    {
        return $this->tieneresol;
    }

    public function setTieneresol(?bool $value): static
    {
        $this->tieneresol = $value;
        return $this;
    }

    public function getLeyendafc(): ?string
    {
        return HtmlDecode($this->leyendafc);
    }

    public function setLeyendafc(?string $value): static
    {
        $this->leyendafc = RemoveXss($value);
        return $this;
    }

    public function getConcepto(): ?string
    {
        return HtmlDecode($this->concepto);
    }

    public function setConcepto(?string $value): static
    {
        $this->concepto = RemoveXss($value);
        return $this;
    }

    public function getNrodoc(): ?string
    {
        return HtmlDecode($this->nrodoc);
    }

    public function setNrodoc(?string $value): static
    {
        $this->nrodoc = RemoveXss($value);
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

    public function getEnLiquid(): ?int
    {
        return $this->enLiquid;
    }

    public function setEnLiquid(?int $value): static
    {
        $this->enLiquid = $value;
        return $this;
    }

    public function getCae(): ?string
    {
        return $this->cae;
    }

    public function setCae(?string $value): static
    {
        $this->cae = $value;
        return $this;
    }

    public function getCaeFchVto(): ?DateTime
    {
        return $this->caeFchVto;
    }

    public function setCaeFchVto(?DateTime $value): static
    {
        $this->caeFchVto = $value;
        return $this;
    }

    public function getResultado(): ?string
    {
        return HtmlDecode($this->resultado);
    }

    public function setResultado(?string $value): static
    {
        $this->resultado = RemoveXss($value);
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
