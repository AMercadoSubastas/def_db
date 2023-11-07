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

class ImprangosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ImprangosList[/{keys:.*}]", [PermissionMiddleware::class], "list.imprangos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ImprangosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ImprangosAdd[/{keys:.*}]", [PermissionMiddleware::class], "add.imprangos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ImprangosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ImprangosView[/{keys:.*}]", [PermissionMiddleware::class], "view.imprangos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ImprangosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ImprangosEdit[/{keys:.*}]", [PermissionMiddleware::class], "edit.imprangos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ImprangosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ImprangosDelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.imprangos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ImprangosDelete");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("imprangos")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["codimp","secuencia"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
