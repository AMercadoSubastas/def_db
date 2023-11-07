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

class ConcafactController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ConcafactList[/{codnum}]", [PermissionMiddleware::class], "list.concafact")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ConcafactAdd[/{codnum}]", [PermissionMiddleware::class], "add.concafact")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ConcafactView[/{codnum}]", [PermissionMiddleware::class], "view.concafact")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ConcafactEdit[/{codnum}]", [PermissionMiddleware::class], "edit.concafact")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ConcafactDelete[/{codnum}]", [PermissionMiddleware::class], "delete.concafact")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConcafactDelete");
    }
}
