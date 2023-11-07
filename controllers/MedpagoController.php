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

class MedpagoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/MedpagoList[/{codnum}]", [PermissionMiddleware::class], "list.medpago")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MedpagoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/MedpagoAdd[/{codnum}]", [PermissionMiddleware::class], "add.medpago")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MedpagoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/MedpagoView[/{codnum}]", [PermissionMiddleware::class], "view.medpago")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MedpagoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/MedpagoEdit[/{codnum}]", [PermissionMiddleware::class], "edit.medpago")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MedpagoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/MedpagoDelete[/{codnum}]", [PermissionMiddleware::class], "delete.medpago")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MedpagoDelete");
    }
}
