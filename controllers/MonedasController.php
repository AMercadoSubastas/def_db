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

class MonedasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MonedasList[/{codnum}]", [PermissionMiddleware::class], "list.monedas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MonedasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MonedasAdd[/{codnum}]", [PermissionMiddleware::class], "add.monedas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MonedasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MonedasView[/{codnum}]", [PermissionMiddleware::class], "view.monedas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MonedasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MonedasEdit[/{codnum}]", [PermissionMiddleware::class], "edit.monedas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MonedasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MonedasDelete[/{codnum}]", [PermissionMiddleware::class], "delete.monedas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MonedasDelete");
    }
}
