<?php

namespace PHPMaker2024\Subastas2024;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpUnauthorizedException;
use PHPMaker2024\Subastas2024\Attributes\Delete;
use PHPMaker2024\Subastas2024\Attributes\Get;
use PHPMaker2024\Subastas2024\Attributes\Map;
use PHPMaker2024\Subastas2024\Attributes\Options;
use PHPMaker2024\Subastas2024\Attributes\Patch;
use PHPMaker2024\Subastas2024\Attributes\Post;
use PHPMaker2024\Subastas2024\Attributes\Put;

/**
 * Class others controller
 */
class OthersController extends ControllerBase
{
    // personaldata
    #[Map(["GET","POST","OPTIONS"], "/personaldata", [PermissionMiddleware::class], "personaldata")]
    public function personaldata(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonalData");
    }

    // login
    #[Map(["GET","POST","OPTIONS"], "/login[/{provider}]", [PermissionMiddleware::class], "login")]
    public function login(Request $request, Response $response, array $args): Response
    {
        global $Error;
        $Error = $this->container->get("app.flash")->getFirstMessage("error");
        return $this->runPage($request, $response, $args, "Login");
    }

    // resetpassword
    #[Map(["GET","POST","OPTIONS"], "/resetpassword", [PermissionMiddleware::class], "resetpassword")]
    public function resetpassword(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ResetPassword");
    }

    // changepassword
    #[Map(["GET","POST","OPTIONS"], "/changepassword", [PermissionMiddleware::class], "changepassword")]
    public function changepassword(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ChangePassword");
    }

    // userpriv
    #[Map(["GET","POST","OPTIONS"], "/userpriv", [PermissionMiddleware::class], "userpriv")]
    public function userpriv(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Userpriv");
    }

    // logout
    #[Map(["GET","POST","OPTIONS"], "/logout", [PermissionMiddleware::class], "logout")]
    public function logout(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Logout");
    }

    // Index
    #[Get("/[index]", [PermissionMiddleware::class], "index")]
    public function index(Request $request, Response $response, array $args): Response
    {
        global $Security, $USER_LEVEL_TABLES;
        $url = "";
        foreach ($USER_LEVEL_TABLES as $t) {
            if ($t[0] == "lista_catalogo.php") { // Check default table
                if ($Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                    break;
                }
            } elseif ($url == "") {
                if ($t[5] && $Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                }
            }
        }
        if ($url === "" && !$Security->isLoggedIn()) {
            $url = "login";
        }
        if ($url == "") {
            throw new HttpUnauthorizedException($request, DeniedMessage());
        }
        return $response->withHeader("Location", $url)->withStatus(302);
    }
}
