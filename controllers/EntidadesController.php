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

class EntidadesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/EntidadesList[/{codnum}]", [PermissionMiddleware::class], "list.entidades")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/EntidadesAdd[/{codnum}]", [PermissionMiddleware::class], "add.entidades")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/EntidadesView[/{codnum}]", [PermissionMiddleware::class], "view.entidades")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/EntidadesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.entidades")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/EntidadesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.entidades")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesDelete");
    }

    // query
    #[Map(["GET","POST","OPTIONS"], "/EntidadesQuery", [PermissionMiddleware::class], "query.entidades")]
    public function query(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EntidadesSearch", "EntidadesQuery");
    }
}
