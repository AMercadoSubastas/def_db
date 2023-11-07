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

class DetreciboController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DetreciboList[/{codnum}]", [PermissionMiddleware::class], "list.detrecibo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DetreciboAdd[/{codnum}]", [PermissionMiddleware::class], "add.detrecibo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DetreciboView[/{codnum}]", [PermissionMiddleware::class], "view.detrecibo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DetreciboEdit[/{codnum}]", [PermissionMiddleware::class], "edit.detrecibo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DetreciboDelete[/{codnum}]", [PermissionMiddleware::class], "delete.detrecibo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/DetreciboPreview", [PermissionMiddleware::class], "preview.detrecibo")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetreciboPreview", null, false);
    }
}
