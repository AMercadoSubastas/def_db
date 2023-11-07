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
 * Entity class for "entidades" table
 */
#[Entity]
#[Table(name: "entidades")]
class Entidade extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'razsoc' => 'razsoc',
        'calle' => 'calle',
        'numero' => 'numero',
        'pisodto' => 'pisodto',
        'codpais' => 'codpais',
        'codprov' => 'codprov',
        'codloc' => 'codloc',
        'codpost' => 'codpost',
        'tellinea' => 'tellinea',
        'telcelu' => 'telcelu',
        'tipoent' => 'tipoent',
        'tipoiva' => 'tipoiva',
        'cuit' => 'cuit',
        'calif' => 'calif',
        'fecalta' => 'fecalta',
        'usuario' => 'usuario',
        'contacto' => 'contacto',
        'mailcont' => 'mailcont',
        'cargo' => 'cargo',
        'fechahora' => 'fechahora',
        'activo' => 'activo',
        'pagweb' => 'pagweb',
        'tipoind' => 'tipoind',
        'usuarioultmod' => 'usuarioultmod',
        'fecultmod' => 'fecultmod',
    ];

    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $razsoc;

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
    private ?string $tellinea;

    #[Column(type: "string", nullable: true)]
    private ?string $telcelu;

    #[Column(type: "integer")]
    private int $tipoent;

    #[Column(type: "integer")]
    private int $tipoiva = 1;

    #[Column(type: "string", nullable: true)]
    private ?string $cuit;

    #[Column(type: "integer", nullable: true)]
    private ?int $calif;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecalta;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "string", nullable: true)]
    private ?string $contacto;

    #[Column(type: "string", nullable: true)]
    private ?string $mailcont;

    #[Column(type: "string", nullable: true)]
    private ?string $cargo;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fechahora;

    #[Column(type: "boolean")]
    private bool $activo = true;

    #[Column(type: "string", nullable: true)]
    private ?string $pagweb;

    #[Column(type: "integer", nullable: true)]
    private ?int $tipoind;

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

    public function getRazsoc(): string
    {
        return HtmlDecode($this->razsoc);
    }

    public function setRazsoc(string $value): static
    {
        $this->razsoc = RemoveXss($value);
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

    public function getTellinea(): ?string
    {
        return HtmlDecode($this->tellinea);
    }

    public function setTellinea(?string $value): static
    {
        $this->tellinea = RemoveXss($value);
        return $this;
    }

    public function getTelcelu(): ?string
    {
        return HtmlDecode($this->telcelu);
    }

    public function setTelcelu(?string $value): static
    {
        $this->telcelu = RemoveXss($value);
        return $this;
    }

    public function getTipoent(): int
    {
        return $this->tipoent;
    }

    public function setTipoent(int $value): static
    {
        $this->tipoent = $value;
        return $this;
    }

    public function getTipoiva(): int
    {
        return $this->tipoiva;
    }

    public function setTipoiva(int $value): static
    {
        $this->tipoiva = $value;
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

    public function getCalif(): ?int
    {
        return $this->calif;
    }

    public function setCalif(?int $value): static
    {
        $this->calif = $value;
        return $this;
    }

    public function getFecalta(): ?DateTime
    {
        return $this->fecalta;
    }

    public function setFecalta(?DateTime $value): static
    {
        $this->fecalta = $value;
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

    public function getContacto(): ?string
    {
        return HtmlDecode($this->contacto);
    }

    public function setContacto(?string $value): static
    {
        $this->contacto = RemoveXss($value);
        return $this;
    }

    public function getMailcont(): ?string
    {
        return HtmlDecode($this->mailcont);
    }

    public function setMailcont(?string $value): static
    {
        $this->mailcont = RemoveXss($value);
        return $this;
    }

    public function getCargo(): ?string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(?string $value): static
    {
        $this->cargo = RemoveXss($value);
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

    public function getActivo(): bool
    {
        return $this->activo;
    }

    public function setActivo(bool $value): static
    {
        $this->activo = $value;
        return $this;
    }

    public function getPagweb(): ?string
    {
        return HtmlDecode($this->pagweb);
    }

    public function setPagweb(?string $value): static
    {
        $this->pagweb = RemoveXss($value);
        return $this;
    }

    public function getTipoind(): ?int
    {
        return $this->tipoind;
    }

    public function setTipoind(?int $value): static
    {
        $this->tipoind = $value;
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
