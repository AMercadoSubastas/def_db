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

class NivelesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/NivelesList[/{codnum}]", [PermissionMiddleware::class], "list.niveles")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NivelesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/NivelesAdd[/{codnum}]", [PermissionMiddleware::class], "add.niveles")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NivelesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/NivelesView[/{codnum}]", [PermissionMiddleware::class], "view.niveles")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NivelesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/NivelesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.niveles")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NivelesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/NivelesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.niveles")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NivelesDelete");
    }
}
