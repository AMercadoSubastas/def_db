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

class LiquidacionController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/LiquidacionList[/{codnum}]", [PermissionMiddleware::class], "list.liquidacion")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LiquidacionList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/LiquidacionAdd[/{codnum}]", [PermissionMiddleware::class], "add.liquidacion")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LiquidacionAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/LiquidacionView[/{codnum}]", [PermissionMiddleware::class], "view.liquidacion")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LiquidacionView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/LiquidacionEdit[/{codnum}]", [PermissionMiddleware::class], "edit.liquidacion")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LiquidacionEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/LiquidacionDelete[/{codnum}]", [PermissionMiddleware::class], "delete.liquidacion")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LiquidacionDelete");
    }
}
