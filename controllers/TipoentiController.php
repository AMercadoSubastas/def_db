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

class TipoentiController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoentiList[/{codnum}]", [PermissionMiddleware::class], "list.tipoenti")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoentiList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoentiAdd[/{codnum}]", [PermissionMiddleware::class], "add.tipoenti")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoentiAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoentiView[/{codnum}]", [PermissionMiddleware::class], "view.tipoenti")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoentiView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoentiEdit[/{codnum}]", [PermissionMiddleware::class], "edit.tipoenti")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoentiEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoentiDelete[/{codnum}]", [PermissionMiddleware::class], "delete.tipoenti")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoentiDelete");
    }
}
