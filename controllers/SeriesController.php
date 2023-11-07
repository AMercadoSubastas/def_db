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

class SeriesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/SeriesList[/{codnum}]", [PermissionMiddleware::class], "list.series")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SeriesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/SeriesAdd[/{codnum}]", [PermissionMiddleware::class], "add.series")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SeriesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/SeriesView[/{codnum}]", [PermissionMiddleware::class], "view.series")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SeriesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/SeriesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.series")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SeriesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/SeriesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.series")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SeriesDelete");
    }
}
