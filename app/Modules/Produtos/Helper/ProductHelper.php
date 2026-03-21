<?php

namespace app\Modules\Produtos\Helper;


class ProdutosHelper
{
    

    public static function price_format(string $price)
    {
        // 1.000,00 / 0,00 / 0,99 - formatos esperados

        $price = str_replace('.', '', $price); // remove milhar
        $price = str_replace(',', '.', $price); // troca decimal

        return (float) $price;
    }

}