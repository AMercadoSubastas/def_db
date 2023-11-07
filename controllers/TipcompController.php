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

class TipcompController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipcompList[/{codnum}]", [PermissionMiddleware::class], "list.tipcomp")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipcompList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipcompAdd[/{codnum}]", [PermissionMiddleware::class], "add.tipcomp")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipcompAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipcompView[/{codnum}]", [PermissionMiddleware::class], "view.tipcomp")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipcompView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipcompEdit[/{codnum}]", [PermissionMiddleware::class], "edit.tipcomp")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipcompEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipcompDelete[/{codnum}]", [PermissionMiddleware::class], "delete.tipcomp")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipcompDelete");
    }
}
