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

class CabfacController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CabfacList[/{codnum}]", [PermissionMiddleware::class], "list.cabfac")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabfacList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CabfacAdd[/{codnum}]", [PermissionMiddleware::class], "add.cabfac")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabfacAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CabfacView[/{codnum}]", [PermissionMiddleware::class], "view.cabfac")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabfacView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CabfacEdit[/{codnum}]", [PermissionMiddleware::class], "edit.cabfac")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabfacEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CabfacDelete[/{codnum}]", [PermissionMiddleware::class], "delete.cabfac")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CabfacDelete");
    }
}
