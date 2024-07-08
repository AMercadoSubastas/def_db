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
 * Entity class for "detremi" table
 */
#[Entity]
#[Table(name: "detremi")]
class Detremi extends AbstractEntity
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
    private int $nreng;

    #[Column(type: "integer", nullable: true)]
    private ?int $codlote;

    #[Column(type: "string", nullable: true)]
    private ?string $desclote;

    #[Column(type: "string", nullable: true)]
    private ?string $descorlote;

    #[Column(type: "string", nullable: true)]
    private ?string $estado;

    #[Column(type: "datetime")]
    private DateTime $fechahora;

    #[Column(type: "integer", nullable: true)]
    private ?int $usuario;

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

    public function getCodlote(): ?int
    {
        return $this->codlote;
    }

    public function setCodlote(?int $value): static
    {
        $this->codlote = $value;
        return $this;
    }

    public function getDesclote(): ?string
    {
        return HtmlDecode($this->desclote);
    }

    public function setDesclote(?string $value): static
    {
        $this->desclote = RemoveXss($value);
        return $this;
    }

    public function getDescorlote(): ?string
    {
        return HtmlDecode($this->descorlote);
    }

    public function setDescorlote(?string $value): static
    {
        $this->descorlote = RemoveXss($value);
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
}
