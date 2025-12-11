<?php

namespace app\Core;

class Redirect
{
    /**
     * Redireciona para uma URL absoluta ou relativa.
     *
     * @param string $url  Destino do redirecionamento
     * @param int    $status Código de status HTTP (301 permanente, 302 temporário)
     */
    public static function to(string $url, int $status = 302): void
    {
        if (!headers_sent()) {
            header("Location: {$url}", true, $status);
            exit;
        } else {
            echo "<script>window.location.href='" . htmlspecialchars($url, ENT_QUOTES) . "';</script>";
            exit;
        }
    }

    /**
     * Redireciona de volta para a página anterior.
     */
    public static function back(): void
    {
        $previous = $_SERVER['HTTP_REFERER'] ?? '/';
        self::to($previous);
    }
}
