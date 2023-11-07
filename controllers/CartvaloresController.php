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

class CartvaloresController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CartvaloresList[/{codnum}]", [PermissionMiddleware::class], "list.cartvalores")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CartvaloresList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CartvaloresView[/{codnum}]", [PermissionMiddleware::class], "view.cartvalores")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CartvaloresView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CartvaloresEdit[/{codnum}]", [PermissionMiddleware::class], "edit.cartvalores")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CartvaloresEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CartvaloresDelete[/{codnum}]", [PermissionMiddleware::class], "delete.cartvalores")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CartvaloresDelete");
    }
}
