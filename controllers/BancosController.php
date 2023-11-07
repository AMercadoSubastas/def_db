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

class BancosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/BancosList[/{codnum}]", [PermissionMiddleware::class], "list.bancos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BancosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/BancosAdd[/{codnum}]", [PermissionMiddleware::class], "add.bancos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BancosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/BancosView[/{codnum}]", [PermissionMiddleware::class], "view.bancos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BancosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/BancosEdit[/{codnum}]", [PermissionMiddleware::class], "edit.bancos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BancosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/BancosDelete[/{codnum}]", [PermissionMiddleware::class], "delete.bancos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BancosDelete");
    }
}
