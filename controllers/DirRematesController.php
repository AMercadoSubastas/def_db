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

class DirRematesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DirRematesList[/{codigo}]", [PermissionMiddleware::class], "list.dir_remates")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DirRematesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DirRematesAdd[/{codigo}]", [PermissionMiddleware::class], "add.dir_remates")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DirRematesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DirRematesView[/{codigo}]", [PermissionMiddleware::class], "view.dir_remates")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DirRematesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DirRematesEdit[/{codigo}]", [PermissionMiddleware::class], "edit.dir_remates")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DirRematesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DirRematesDelete[/{codigo}]", [PermissionMiddleware::class], "delete.dir_remates")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DirRematesDelete");
    }
}
