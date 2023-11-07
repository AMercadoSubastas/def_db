<?php

namespace PHPMaker2024\Subastas2024;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Platforms;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use FastRoute\RouteParser\Std;
use Illuminate\Encryption\Encrypter;
use HTMLPurifier_Config;
use HTMLPurifier;

// Connections and entity managers
$definitions = [];
$dbids = array_keys(Config("Databases"));
foreach ($dbids as $dbid) {
    $definitions["connection." . $dbid] = \DI\factory(function (string $dbid) {
        return ConnectDb(Db($dbid));
    })->parameter("dbid", $dbid);
    $definitions["entitymanager." . $dbid] = \DI\factory(function (ContainerInterface $c, string $dbid) {
        $cache = IsDevelopment()
            ? DoctrineProvider::wrap(new ArrayAdapter())
            : DoctrineProvider::wrap(new FilesystemAdapter(directory: Config("DOCTRINE.CACHE_DIR")));
        $config = Setup::createAttributeMetadataConfiguration(
            Config("DOCTRINE.METADATA_DIRS"),
            IsDevelopment(),
            null,
            $cache
        );
        $conn = $c->get("connection." . $dbid);
        return new EntityManager($conn, $config);
    })->parameter("dbid", $dbid);
}

return [
    "app.cache" => \DI\create(CacheProvider::class),
    "app.flash" => fn(ContainerInterface $c) => new Messages(),
    "app.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "email.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "sms.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "app.audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler($GLOBALS["RELATIVE_PATH"] . "log/audit.log")), // For audit trail
    "app.logger" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log/log.log")),
    "sql.logger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debug.stack");
        }
        $loggers[] = $c->get("debug.sql.logger");
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "app.csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "html.purifier.config" => fn(ContainerInterface $c) => HTMLPurifier_Config::createDefault(),
    "html.purifier" => fn(ContainerInterface $c) => new HTMLPurifier($c->get("html.purifier.config")),
    "debug.stack" => \DI\create(DebugStack::class),
    "debug.sql.logger" => \DI\create(DebugSqlLogger::class),
    "debug.timer" => \DI\create(Timer::class),
    "app.security" => \DI\create(AdvancedSecurity::class),
    "user.profile" => \DI\create(UserProfile::class),
    "app.session" => \DI\create(HttpSession::class),
    "mime.types" => \DI\create(MimeTypes::class),
    "app.language" => \DI\create(Language::class),
    PermissionMiddleware::class => \DI\create(PermissionMiddleware::class),
    ApiPermissionMiddleware::class => \DI\create(ApiPermissionMiddleware::class),
    JwtMiddleware::class => \DI\create(JwtMiddleware::class),
    Std::class => \DI\create(Std::class),
    Encrypter::class => fn(ContainerInterface $c) => new Encrypter(AesEncryptionKey(base64_decode(Config("AES_ENCRYPTION_KEY"))), Config("AES_ENCRYPTION_CIPHER")),

    // Tables
    "bancos" => \DI\create(Bancos::class),
    "cabfac" => \DI\create(Cabfac::class),
    "cabrecibo" => \DI\create(Cabrecibo::class),
    "cabremi" => \DI\create(Cabremi::class),
    "calificacion" => \DI\create(Calificacion::class),
    "cartvalores" => \DI\create(Cartvalores::class),
    "concafact" => \DI\create(Concafact::class),
    "concafactven" => \DI\create(Concafactven::class),
    "detfac" => \DI\create(Detfac::class),
    "detrecibo" => \DI\create(Detrecibo::class),
    "detremi" => \DI\create(Detremi::class),
    "dir_remates" => \DI\create(DirRemates::class),
    "entidades" => \DI\create(Entidades::class),
    "formapago" => \DI\create(Formapago::class),
    "impfac" => \DI\create(Impfac::class),
    "imprangos" => \DI\create(Imprangos::class),
    "impuestos" => \DI\create(Impuestos::class),
    "liquidacion" => \DI\create(Liquidacion::class),
    "localidades" => \DI\create(Localidades::class),
    "lotes" => \DI\create(Lotes::class),
    "medpago" => \DI\create(Medpago::class),
    "monedas" => \DI\create(Monedas::class),
    "niveles" => \DI\create(Niveles::class),
    "paises" => \DI\create(Paises::class),
    "provincias" => \DI\create(Provincias::class),
    "remates" => \DI\create(Remates::class),
    "rubros" => \DI\create(Rubros::class),
    "series" => \DI\create(Series::class),
    "sucbancos" => \DI\create(Sucbancos::class),
    "tipcomp" => \DI\create(Tipcomp::class),
    "tipoenti" => \DI\create(Tipoenti::class),
    "tipoindustria" => \DI\create(Tipoindustria::class),
    "tipoiva" => \DI\create(Tipoiva::class),
    "usuarios" => \DI\create(Usuarios::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "a_facprov" => \DI\create(AFacprov::class),
    "lista_catalogo" => \DI\create(ListaCatalogo::class),
    "lista_vendedor" => \DI\create(ListaVendedor::class),
    "lista_rematador" => \DI\create(ListaRematador::class),
    "lista_martillero" => \DI\create(ListaMartillero::class),
    "a_liquid" => \DI\create(ALiquid::class),
    "lista_ivaventas" => \DI\create(ListaIvaventas::class),
    "lista_ivacompras" => \DI\create(ListaIvacompras::class),
    "l_ret_iva_sufridas" => \DI\create(LRetIvaSufridas::class),
    "l_iib_sufridas" => \DI\create(LIibSufridas::class),
    "l_ret_ganan_sufridas" => \DI\create(LRetGananSufridas::class),
    "l_ret_suss_sufridas" => \DI\create(LRetSussSufridas::class),
    "l_gastos" => \DI\create(LGastos::class),
    "l_liq_ibb" => \DI\create(LLiqIbb::class),
    "l_recymedpag" => \DI\create(LRecymedpag::class),
    "l_ivaxls" => \DI\create(LIvaxls::class),
    "l_compras_xls" => \DI\create(LComprasXls::class),
    "l_ret_iva_practicadas" => \DI\create(LRetIvaPracticadas::class),
    "ncndxlot" => \DI\create(Ncndxlot::class),
    "ncndxconc" => \DI\create(Ncndxconc::class),
    "pagofacturas" => \DI\create(Pagofacturas::class),
    "emicbtes" => \DI\create(Emicbtes::class),
    "emiliquid" => \DI\create(Emiliquid::class),
    "a_fcxconci" => \DI\create(AFcxconci::class),
    "ncndxconci" => \DI\create(Ncndxconci::class),
    "v_afcautxlot" => \DI\create(VAfcautxlot::class),
    "v_afcmanxlot" => \DI\create(VAfcmanxlot::class),
    "v_afcautxconc" => \DI\create(VAfcautxconc::class),
    "v_afcmanxconc" => \DI\create(VAfcmanxconc::class),
    "v_afacutxconc_i" => \DI\create(VAfacutxconcI::class),
    "v_ancaut" => \DI\create(VAncaut::class),
    "v_ancman" => \DI\create(VAncman::class),
    "v_andaut" => \DI\create(VAndaut::class),
    "v_andman" => \DI\create(VAndman::class),
    "v_recibocobuna" => \DI\create(VRecibocobuna::class),
    "v_recibocob" => \DI\create(VRecibocob::class),
    "v_cargaremate" => \DI\create(VCargaremate::class),
    "v_modificar_remate" => \DI\create(VModificarRemate::class),
    "v_afcautxconcB" => \DI\create(VAfcautxconcB::class),
    "v_afcautxlotB" => \DI\create(VAfcautxlotB::class),
    "a_fcxconciB" => \DI\create(AFcxconciB::class),
    "v_lista_facncA" => \DI\create(VListaFacncA::class),
    "v_lista_facncB" => \DI\create(VListaFacncB::class),
    "v_ancA4" => \DI\create(VAncA4::class),
    "v_ancB4" => \DI\create(VAncB4::class),
    "v_ancA6" => \DI\create(VAncA6::class),
    "v_ancB6" => \DI\create(VAncB6::class),
    "l_recibo_reemision" => \DI\create(LReciboReemision::class),
    "v_andA4" => \DI\create(VAndA4::class),
    "v_andB4" => \DI\create(VAndB4::class),
    "v_andA6" => \DI\create(VAndA6::class),
    "v_andB6" => \DI\create(VAndB6::class),
    "l_citicompras" => \DI\create(LCiticompras::class),
    "l_citicompras_alic" => \DI\create(LCiticomprasAlic::class),
    "l_citiventas" => \DI\create(LCitiventas::class),
    "l_citiventas_alic" => \DI\create(LCitiventasAlic::class),
    "l_ranking_cli" => \DI\create(LRankingCli::class),
    "l_ranking_pro" => \DI\create(LRankingPro::class),
    "l_ranking_cli_cant" => \DI\create(LRankingCliCant::class),
    "l_ranking_pro_cant" => \DI\create(LRankingProCant::class),
    "l_ranking_cli_com" => \DI\create(LRankingCliCom::class),
    "lista_facxremate" => \DI\create(ListaFacxremate::class),
    "lista_import_lotes" => \DI\create(ListaImportLotes::class),
    "lista_boletase" => \DI\create(ListaBoletase::class),
    "lista_facncA_consultar" => \DI\create(ListaFacncAConsultar::class),
    "lista_facncB_consultar" => \DI\create(ListaFacncBConsultar::class),
    "lista_lotesweb" => \DI\create(ListaLotesweb::class),
    "lista_pasolotesweb" => \DI\create(ListaPasolotesweb::class),
    "lista_pasolotesparc" => \DI\create(ListaPasolotesparc::class),
    "l_retenciones" => \DI\create(LRetenciones::class),
    "l_vtasxjuris" => \DI\create(LVtasxjuris::class),
    "l_bolsenia" => \DI\create(LBolsenia::class),
    "l_liqymedpago" => \DI\create(LLiqymedpago::class),
    "l_facxmes" => \DI\create(LFacxmes::class),
    "l_faltantes" => \DI\create(LFaltantes::class),
    "lista_impdebxrem" => \DI\create(ListaImpdebxrem::class),
    "l_comisxremjuris" => \DI\create(LComisxremjuris::class),
    "l_lotes_xls" => \DI\create(LLotesXls::class),
    "l_ctacte_cli" => \DI\create(LCtacteCli::class),
    "a_anulliq" => \DI\create(AAnulliq::class),
    "l_comisxremjurist" => \DI\create(LComisxremjurist::class),
    "l_vtasxjuris_consolidado" => \DI\create(LVtasxjurisConsolidado::class),
    "l_retenciones_div" => \DI\create(LRetencionesDiv::class),
    "v_afcxloteA10" => \DI\create(VAfcxloteA10::class),
    "v_afcxconcA10" => \DI\create(VAfcxconcA10::class),
    "afcxlot" => \DI\create(Afcxlot::class),
    "l_WafcxlotA10" => \DI\create(LWafcxlotA10::class),
    "v_wafcautxconcA10" => \DI\create(VWafcautxconcA10::class),
    "v_wancA10" => \DI\create(VWancA10::class),
    "v_wcbteint" => \DI\create(VWcbteint::class),
    "v_wcbteintdev" => \DI\create(VWcbteintdev::class),
    "l_facncint" => \DI\create(LFacncint::class),

    // User table
    "usertable" => \DI\get("usuarios"),
] + $definitions;
