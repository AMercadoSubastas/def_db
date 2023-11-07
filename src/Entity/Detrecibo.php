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
 * Entity class for "detrecibo" table
 */
#[Entity]
#[Table(name: "detrecibo")]
class Detrecibo extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'tcomp' => 'tcomp',
        'serie' => 'serie',
        'ncomp' => 'ncomp',
        'nreng' => 'nreng',
        'tcomprel' => 'tcomprel',
        'serierel' => 'serierel',
        'ncomprel' => 'ncomprel',
        'netocbterel' => 'netocbterel',
        'usuario' => 'usuario',
        'fechahora' => 'fechahora',
        'nrodoc' => 'nrodoc',
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

    #[Column(type: "integer")]
    private int $nreng;

    #[Column(type: "integer")]
    private int $tcomprel;

    #[Column(type: "integer")]
    private int $serierel;

    #[Column(type: "integer")]
    private int $ncomprel;

    #[Column(type: "decimal")]
    private string $netocbterel;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "string")]
    private string $nrodoc;

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

    public function getNreng(): int
    {
        return $this->nreng;
    }

    public function setNreng(int $value): static
    {
        $this->nreng = $value;
        return $this;
    }

    public function getTcomprel(): int
    {
        return $this->tcomprel;
    }

    public function setTcomprel(int $value): static
    {
        $this->tcomprel = $value;
        return $this;
    }

    public function getSerierel(): int
    {
        return $this->serierel;
    }

    public function setSerierel(int $value): static
    {
        $this->serierel = $value;
        return $this;
    }

    public function getNcomprel(): int
    {
        return $this->ncomprel;
    }

    public function setNcomprel(int $value): static
    {
        $this->ncomprel = $value;
        return $this;
    }

    public function getNetocbterel(): string
    {
        return $this->netocbterel;
    }

    public function setNetocbterel(string $value): static
    {
        $this->netocbterel = $value;
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

    public function getNrodoc(): string
    {
        return HtmlDecode($this->nrodoc);
    }

    public function setNrodoc(string $value): static
    {
        $this->nrodoc = RemoveXss($value);
        return $this;
    }
}
