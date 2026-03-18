<?php

namespace app\Core;

class HttpCode
{
    // 2xx — Sucesso
    const OK                    = 200;
    const CREATED               = 201;
    const NO_CONTENT            = 204;

    // 3xx — Redirecionamento
    const MOVED_PERMANENTLY     = 301;
    const FOUND                 = 302;

    // 4xx — Erro do Cliente
    const BAD_REQUEST           = 400;
    const UNAUTHORIZED          = 401;
    const FORBIDDEN             = 403;
    const NOT_FOUND             = 404;
    const METHOD_NOT_ALLOWED    = 405;
    const CONFLICT              = 409;
    const UNPROCESSABLE_ENTITY  = 422;
    const TOO_MANY_REQUESTS     = 429;

    // 5xx — Erro do Servidor
    const INTERNAL_SERVER_ERROR = 500;
    const BAD_GATEWAY           = 502;
    const SERVICE_UNAVAILABLE   = 503;
}