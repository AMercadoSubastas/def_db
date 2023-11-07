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

class PaisesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PaisesList[/{codnum}]", [PermissionMiddleware::class], "list.paises")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaisesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PaisesAdd[/{codnum}]", [PermissionMiddleware::class], "add.paises")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaisesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PaisesView[/{codnum}]", [PermissionMiddleware::class], "view.paises")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaisesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PaisesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.paises")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaisesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PaisesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.paises")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaisesDelete");
    }
}
