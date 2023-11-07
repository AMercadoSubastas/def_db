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

class TipoindustriaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoindustriaList[/{codnum}]", [PermissionMiddleware::class], "list.tipoindustria")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoindustriaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoindustriaAdd[/{codnum}]", [PermissionMiddleware::class], "add.tipoindustria")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoindustriaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoindustriaView[/{codnum}]", [PermissionMiddleware::class], "view.tipoindustria")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoindustriaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoindustriaEdit[/{codnum}]", [PermissionMiddleware::class], "edit.tipoindustria")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoindustriaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoindustriaDelete[/{codnum}]", [PermissionMiddleware::class], "delete.tipoindustria")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoindustriaDelete");
    }
}
