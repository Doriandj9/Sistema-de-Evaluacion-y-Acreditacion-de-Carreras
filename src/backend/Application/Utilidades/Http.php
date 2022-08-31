<?php

declare(strict_types=1);

namespace App\backend\Application\Utilidades;

use JsonException;

class Http
{
    /**
     * HTTP 200 code
     *
     * @var int
     */
    public const STATUS_OK = 200;

    /**
     * HTTP 201 code
     *
     * @var int
     */
    public const STATUS_CREATED = 201;

    /**
     * HTTP 202 code
     *
     * @var int
     */
    public const STATUS_ACCEPTED = 202;

    /**
     * HTTP 203 code
     *
     * @var int
     */
    public const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * HTTP 204 code
     *
     * @var int
     */
    public const STATUS_NO_CONTENT = 204;

    /**
     * HTTP 301 code
     *
     * @var int
     */
    public const STATUS_MOVED_PERMANENTLY = 301;

    /**
     * HTTP 302 code
     *
     * @var int
     */
    public const STATUS_FOUND = 302;

    /**
     * HTTP 303 code
     *
     * @var int
     */
    public const STATUS_SEE_OTHER = 303;

    /**
     * HTTP 307 code
     *
     * @var int
     */
    public const STATUS_TEMPORARY_REDIRECT = 307;

    /**
     * HTTP 308 code
     *
     * @var int
     */
    public const STATUS_PERMANENT_REDIRECT = 308;
    
    /**
     * HTTP 401 code
     * 
     * @var int
     */
    public const STATUS_UNAUTHORIZED = 401;
    /**
     * HTTP 401 code
     * 
     * @var int
     */
    public const STATUS_FORBIDDEN = 401;
    /**
     * HTTP 404 code
     *
     * @var int
     */
    public const STATUS_NOT_FOUND = 404;
    /**
     * Una referencia a todos los codigos de HTTP
     *
     * @var array
     */
    public static $statusCodes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        226 => 'IM used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        451 => 'Unavailable For Legal Reasons',
        499 => 'Client Closed Request',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'Unsupported Version',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];
    /**
     * Esta funcion redirecciona una ruta
     *
     * @param string es la ruta a redireccionars por ejemplo /inicio
     */
    public static function redirect(string $ruta)
    {
        header('location: ' . $ruta);
        exit;
    }
    /**
     * Esta funcion imprime un json y termina la ejecucion
     *
     * @param string es el json string
     */
    public static function responseJson(string $json)
    {
        http_response_code(self::STATUS_OK);
        header('Content-Type: application/json');
        echo $json;
        exit;
    }
}
