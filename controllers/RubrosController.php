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

class RubrosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RubrosList[/{codnum}]", [PermissionMiddleware::class], "list.rubros")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RubrosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RubrosAdd[/{codnum}]", [PermissionMiddleware::class], "add.rubros")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RubrosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RubrosView[/{codnum}]", [PermissionMiddleware::class], "view.rubros")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RubrosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RubrosEdit[/{codnum}]", [PermissionMiddleware::class], "edit.rubros")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RubrosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RubrosDelete[/{codnum}]", [PermissionMiddleware::class], "delete.rubros")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RubrosDelete");
    }
}
