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

class FormapagoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/FormapagoList[/{codnum}]", [PermissionMiddleware::class], "list.formapago")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormapagoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/FormapagoAdd[/{codnum}]", [PermissionMiddleware::class], "add.formapago")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormapagoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/FormapagoView[/{codnum}]", [PermissionMiddleware::class], "view.formapago")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormapagoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/FormapagoEdit[/{codnum}]", [PermissionMiddleware::class], "edit.formapago")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormapagoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/FormapagoDelete[/{codnum}]", [PermissionMiddleware::class], "delete.formapago")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormapagoDelete");
    }
}
