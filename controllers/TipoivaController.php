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

class TipoivaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoivaList[/{codnum}]", [PermissionMiddleware::class], "list.tipoiva")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoivaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoivaAdd[/{codnum}]", [PermissionMiddleware::class], "add.tipoiva")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoivaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoivaView[/{codnum}]", [PermissionMiddleware::class], "view.tipoiva")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoivaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoivaEdit[/{codnum}]", [PermissionMiddleware::class], "edit.tipoiva")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoivaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoivaDelete[/{codnum}]", [PermissionMiddleware::class], "delete.tipoiva")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoivaDelete");
    }
}
