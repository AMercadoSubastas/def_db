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
 * Entity class for "usuarios" table
 */
#[Entity]
#[Table(name: "usuarios")]
class Usuario extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $codnum;

    #[Column(type: "string")]
    private string $usuario;

    #[Column(type: "string")]
    private string $nombre;

    #[Column(type: "string")]
    private string $clave;

    #[Column(type: "integer")]
    private int $nivel;

    #[Column(type: "integer")]
    private int $activo;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "text", nullable: true)]
    private ?string $perfil;

    public function __construct()
    {
        $this->activo = 1;
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

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function setUsuario(string $value): static
    {
        $this->usuario = $value;
        return $this;
    }

    public function getNombre(): string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getClave(): string
    {
        return $this->clave;
    }

    public function setClave(string $value): static
    {
        $this->clave = EncryptPassword(Config("CASE_SENSITIVE_PASSWORD") ? $value : strtolower($value));
        return $this;
    }

    public function getNivel(): int
    {
        return $this->nivel;
    }

    public function setNivel(int $value): static
    {
        $this->nivel = $value;
        return $this;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $value): static
    {
        $this->activo = $value;
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getPerfil(): ?string
    {
        return HtmlDecode($this->perfil);
    }

    public function setPerfil(?string $value): static
    {
        $this->perfil = RemoveXss($value);
        return $this;
    }

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('usuario'),
            "userId" => null,
            "parentUserId" => null,
            "userLevel" => $this->get('nivel') ?? AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('codnum'),
        ];
    }
}
