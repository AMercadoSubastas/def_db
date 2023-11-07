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

class CabreciboController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CabreciboList[/{codnum}]", [PermissionMiddleware::class], "list.cabrecibo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabreciboList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CabreciboAdd[/{codnum}]", [PermissionMiddleware::class], "add.cabrecibo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabreciboAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CabreciboView[/{codnum}]", [PermissionMiddleware::class], "view.cabrecibo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabreciboView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CabreciboEdit[/{codnum}]", [PermissionMiddleware::class], "edit.cabrecibo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabreciboEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CabreciboDelete[/{codnum}]", [PermissionMiddleware::class], "delete.cabrecibo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabreciboDelete");
    }
}
