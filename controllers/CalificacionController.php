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

class CalificacionController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CalificacionList[/{codnum}]", [PermissionMiddleware::class], "list.calificacion")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CalificacionAdd[/{codnum}]", [PermissionMiddleware::class], "add.calificacion")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CalificacionView[/{codnum}]", [PermissionMiddleware::class], "view.calificacion")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CalificacionEdit[/{codnum}]", [PermissionMiddleware::class], "edit.calificacion")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CalificacionDelete[/{codnum}]", [PermissionMiddleware::class], "delete.calificacion")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionDelete");
    }
}
