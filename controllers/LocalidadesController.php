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

class LocalidadesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/LocalidadesList[/{codnum}]", [PermissionMiddleware::class], "list.localidades")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalidadesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/LocalidadesAdd[/{codnum}]", [PermissionMiddleware::class], "add.localidades")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalidadesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/LocalidadesView[/{codnum}]", [PermissionMiddleware::class], "view.localidades")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalidadesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/LocalidadesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.localidades")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalidadesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/LocalidadesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.localidades")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalidadesDelete");
    }
}
