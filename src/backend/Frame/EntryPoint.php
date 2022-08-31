<?php

declare(strict_types=1);

namespace App\backend\Frame;

use App\backend\Application\ContentRoutes;
use App\backend\Application\Utilidades\Http;
/**
 * @author Dorian Armijos
 * @link <>
 * @author Nataly Fernandez
 * @link<>
 *
 * Esta clase enlaza las rutas con sus controladores
 * y imprime la pagina en si
 */
class EntryPoint
{
    /**
     * Son las rutas que llegan por el cliente
     *
     * @var string
     */
    private $route;
    /**
     * Es el metodo por el cual se realiza la solicitud
     * puede ser POST o GET
     *
     * @var string
     */
    private $method;
    /**
     * Es la clase que contiene todas las rutas padres
     *
     * @var ContentRoutes
     */
    private $contentRoutes;
    /**
     * Es la variable que muestra si es una ruta padre
     *
     * @var string
     */
    private string $indicatorRoute;
    /**
     * Son las rutas padres que llegan por la solitud
     *
     * @var array
     */
    private const  REFERENCES_PARENT_ROUTES = [
        'docente' => 'docente',
        'admin' => 'admin',
        'evaluador' => 'evaluador',
        'secretaria' => 'secretaria',
        'coordinador' => 'coordinador',
        'datos' => 'datos'
    ];
    public function __construct(
        string $route,
        string $method,
        ContentRoutes $contentRoutes
    ) {
        $this->route = $route;
        $this->method = $method;
        $this->contentRoutes = $contentRoutes;
        $this->verifyRoute();
        $this->configIndicatorRoute();
    }
    /**
     * Esta funcion verifica que la ruta si se encuentra en
     * mayusculas se diriga hacia la misma ruta en minusculas
     * para que el motor de busqueda le trate como que la ruta
     * pertenece al mismo dominio
     *
     * @return void
     */
    private function verifyRoute(): void
    {
        if (strtolower($this->route) !== $this->route) {
            http_response_code(Http::STATUS_MOVED_PERMANENTLY);
            Http::redirect(strtolower($this->route));
        }
    }

    /**
     * Esta duncion se encarga de separar la ruta padre de las hijas
     * por ejmplo la ruta admin/inicio separada para saber que ruta padre es
     * quedaria admin y esa ruta se busca en el contenedor de rutas
     * y se obtine las rutas del admin
     *
     * @return void
     */
    private function configIndicatorRoute(): void
    {
        $refRoute = preg_split('/\//', $this->route);
        $this->indicatorRoute = count($refRoute) <= 1 ? '' : $refRoute[0];
    }
    private function loadTemplate(string $template, array $variables = []): string
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../Views/' . $template;
        return ob_get_clean();
    }
    /**
     * Esta funcion imprime como tal las vistas y pone en
     * funcionamiento al sistema
     *
     * @return void
     */
    public function run(): void
    {
        /**
         * Se busca si la ruta que llega es una ruta padre para agregar a la variable $parentRoute
         * caso contrario que siga con la ruta que envio el cliente
         */
        if (empty($this->indicatorRoute) && isset(self::REFERENCES_PARENT_ROUTES[$this->route])) {
            $parentRoute = $this->contentRoutes->getRoutes(self::REFERENCES_PARENT_ROUTES[$this->route]);
        } else {
            $parentRoute = $this->contentRoutes->getRoutes($this->indicatorRoute);
        }

        if ($parentRoute) {
            // Si existe esa ruta a continiacion se emparejan las variables con sus contenidos
            $rutas = $parentRoute->getRoutes();
            $template = $parentRoute->getTemplate();
            $restrigciones = $parentRoute->getRestrict();
            if (
                !isset($rutas[$this->route]) ||
                !isset($rutas[$this->route][$this->method])
            ) {
                // Se verifica que si exite la ruta o el metodo para esa ruta
                http_response_code(Http::STATUS_NOT_FOUND);
                Http::redirect('/error-404');
            }

            if (
                isset($restrigciones['login']) &&
                !$this->contentRoutes->getAutentificacion()->comprobacionSesion()
                ) {
                    // Si la ruta contiene la restingcion de que debe estar logueado primero
                    // y si no lo esta lo redirige hacia un error de login con la cabecera
                    // no autorizado 401
                http_response_code(Http::STATUS_UNAUTHORIZED);
                Http::redirect('/error-login');
            }

            $usuario = $this->contentRoutes->getAutentificacion()->getUsuario();

            if (
                isset($restrigciones['permisos']) &&
                !$usuario->tienePermisos($restrigciones['permisos'])
               ) {
                Http::redirect('/error-permisos');
            }

            if (isset($restrigciones['api-key'])) {
                if ($this->method === 'POST') {
                    if (!isset($_POST['tok_'])) {
                        http_response_code(Http::STATUS_FORBIDDEN);
                        Http::responseJson(json_encode(
                            [
                            'ident' => 0,
                            'mensaje' => 'Error no contiene un token para acceder al recurso'
                            ]
                        ));
                    }
                }

                if ($this->method === 'GET') {
                    if (!isset($_GET['tok_'])) {
                        http_response_code(Http::STATUS_FORBIDDEN);
                        Http::responseJson(json_encode(
                            [
                            'ident'=> 0,
                            'mensaje' => 'Error no contiene un token para acceder al recurso'
                            ]
                        ));
                    }
                }
            }

            if ( isset($_POST['tok_']) && $_SESSION['token'] !== $_POST['tok_'] ||
                isset($_GET['tok_']) && $_SESSION['token'] !== $_GET['tok_'] ) {
                    http_response_code(Http::STATUS_FORBIDDEN);
                    Http::responseJson(json_encode(
                        [
                            'ident' => 0,
                            'mensaje' => 'Error token invalido / token expirado'
                        ]
                    ));
            }

            $controller = $rutas[$this->route][$this->method]['controller'];
            $action = $rutas[$this->route][$this->method]['action'];

            $pagina = $controller->$action();
            $titulo = $pagina['title'];
            $fragmentoHTML = $pagina['template'];
            if (isset($pagina['variables'])) {
                $contenido = $this->loadTemplate($fragmentoHTML, $pagina['variables']);
            } else {
                $contenido =  $this->loadTemplate($fragmentoHTML);
            }

            echo $this->loadTemplate(
                'templates/'. $template,
                [
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'usuario' => $usuario
                ]
            );
        } else {
            http_response_code(Http::STATUS_NOT_FOUND);
            Http::redirect('/error-404');
        }
    }
}
