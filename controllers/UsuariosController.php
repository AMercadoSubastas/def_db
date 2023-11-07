<?php

namespace PHPMaker2024\Subastas2024;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\Subastas2024\Attributes\Delete;
use PHPMaker2024\Subastas2024\Attributes\Get;
use PHPMaker2024\Subastas2024\Attributes\Map;
use PHPMaker2024\Subastas2024\Attributes\Options;
use PHPMaker2024\Subastas2024\Attributes\Patch;
use PHPMaker2024\Subastas2024\Attributes\Post;
use PHPMaker2024\Subastas2024\Attributes\Put;

class UsuariosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UsuariosList[/{codnum}]", [PermissionMiddleware::class], "list.usuarios")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuariosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UsuariosAdd[/{codnum}]", [PermissionMiddleware::class], "add.usuarios")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuariosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UsuariosView[/{codnum}]", [PermissionMiddleware::class], "view.usuarios")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuariosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UsuariosEdit[/{codnum}]", [PermissionMiddleware::class], "edit.usuarios")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuariosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UsuariosDelete[/{codnum}]", [PermissionMiddleware::class], "delete.usuarios")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuariosDelete");
    }
}
