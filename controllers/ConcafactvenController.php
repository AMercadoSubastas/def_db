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

class ConcafactvenController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ConcafactvenList[/{codnum}]", [PermissionMiddleware::class], "list.concafactven")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactvenList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ConcafactvenAdd[/{codnum}]", [PermissionMiddleware::class], "add.concafactven")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactvenAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ConcafactvenView[/{codnum}]", [PermissionMiddleware::class], "view.concafactven")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactvenView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ConcafactvenEdit[/{codnum}]", [PermissionMiddleware::class], "edit.concafactven")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactvenEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ConcafactvenDelete[/{codnum}]", [PermissionMiddleware::class], "delete.concafactven")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactvenDelete");
    }
}
