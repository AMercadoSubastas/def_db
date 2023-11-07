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

class ProvinciasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ProvinciasList[/{codnum}]", [PermissionMiddleware::class], "list.provincias")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProvinciasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ProvinciasAdd[/{codnum}]", [PermissionMiddleware::class], "add.provincias")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProvinciasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ProvinciasView[/{codnum}]", [PermissionMiddleware::class], "view.provincias")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProvinciasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ProvinciasEdit[/{codnum}]", [PermissionMiddleware::class], "edit.provincias")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProvinciasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ProvinciasDelete[/{codnum}]", [PermissionMiddleware::class], "delete.provincias")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProvinciasDelete");
    }
}
