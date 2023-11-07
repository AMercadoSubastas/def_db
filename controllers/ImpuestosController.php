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

class ImpuestosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ImpuestosList[/{codnum}]", [PermissionMiddleware::class], "list.impuestos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpuestosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ImpuestosAdd[/{codnum}]", [PermissionMiddleware::class], "add.impuestos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpuestosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ImpuestosView[/{codnum}]", [PermissionMiddleware::class], "view.impuestos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpuestosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ImpuestosEdit[/{codnum}]", [PermissionMiddleware::class], "edit.impuestos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpuestosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ImpuestosDelete[/{codnum}]", [PermissionMiddleware::class], "delete.impuestos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpuestosDelete");
    }
}
