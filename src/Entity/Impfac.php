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
 * Entity class for "impfac" table
 */
#[Entity]
#[Table(name: "impfac")]
class Impfac extends AbstractEntity
{
    public static array $propertyNames = [
        'codnum' => 'codnum',
        'tcomp' => 'tcomp',
        'serie' => 'serie',
        'ncomp' => 'ncomp',
        'nreng' => 'nreng',
        'codimp' => 'codimp',
        'porcen' => 'porcen',
        'valor' => 'valor',
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
    private ?int $nreng;

    #[Column(type: "integer")]
    private int $codimp;

    #[Column(type: "float")]
    private float $porcen;

    #[Column(type: "float")]
    private float $valor;

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

    public function getNreng(): ?int
    {
        return $this->nreng;
    }

    public function setNreng(?int $value): static
    {
        $this->nreng = $value;
        return $this;
    }

    public function getCodimp(): int
    {
        return $this->codimp;
    }

    public function setCodimp(int $value): static
    {
        $this->codimp = $value;
        return $this;
    }

    public function getPorcen(): float
    {
        return $this->porcen;
    }

    public function setPorcen(float $value): static
    {
        $this->porcen = $value;
        return $this;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $value): static
    {
        $this->valor = $value;
        return $this;
    }
}
