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

class RematesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RematesList[/{codnum}]", [PermissionMiddleware::class], "list.remates")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RematesList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RematesView[/{codnum}]", [PermissionMiddleware::class], "view.remates")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RematesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RematesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.remates")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RematesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RematesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.remates")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RematesDelete");
    }
}
