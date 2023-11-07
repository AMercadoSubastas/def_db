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

class LotesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/LotesList[/{codnum}]", [PermissionMiddleware::class], "list.lotes")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LotesList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/LotesView[/{codnum}]", [PermissionMiddleware::class], "view.lotes")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LotesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/LotesEdit[/{codnum}]", [PermissionMiddleware::class], "edit.lotes")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LotesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/LotesDelete[/{codnum}]", [PermissionMiddleware::class], "delete.lotes")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LotesDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/LotesPreview", [PermissionMiddleware::class], "preview.lotes")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LotesPreview", null, false);
    }
}
