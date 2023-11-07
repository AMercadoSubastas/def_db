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

class DetfacController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DetfacList[/{codnum}]", [PermissionMiddleware::class], "list.detfac")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DetfacAdd[/{codnum}]", [PermissionMiddleware::class], "add.detfac")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DetfacView[/{codnum}]", [PermissionMiddleware::class], "view.detfac")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DetfacEdit[/{codnum}]", [PermissionMiddleware::class], "edit.detfac")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DetfacDelete[/{codnum}]", [PermissionMiddleware::class], "delete.detfac")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/DetfacPreview", [PermissionMiddleware::class], "preview.detfac")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetfacPreview", null, false);
    }
}
