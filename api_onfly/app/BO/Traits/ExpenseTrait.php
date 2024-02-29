<?php

namespace App\BO\Traits;

use Illuminate\Http\Request;
use App\Resources\Traits\PrepareTrait;

/**
 * Define os dados a serem persistidos no banco de dados
 *
 */
trait ExpenseTrait
{
    use PrepareTrait;

    /**
     * Método responsável por receber os dados e prepará-los para chamar a função desejada
     *   seu nome deve ser a junção da palavra prepare com o nome do método que o chamará
     *
     * @param array $params
     * @return void
     */
    public function prepareStore(array $params)
    {
        $objetoRequest                   = $params['request'];
        $objetoClasse                    = $params['object'];

        $arrayRetorno = [];
        $arrayRetorno['user_id']     = \Auth::user()->id;
        $arrayRetorno['description'] = $objetoRequest->description;
        $arrayRetorno['cost']        = $objetoRequest->cost;
        $arrayRetorno['date']        = $objetoRequest->date;

        return array_filter($arrayRetorno);
    }

    /**
     * Método responsável por receber os dados e prepará-los para chamar a função desejada
     *   seu nome deve ser a junção da palavra prepare com o nome do método que o chamará
     *
     * @param array $params
     * @return void
     */
    public function prepareUpdate(array $params)
    {
        $objetoRequest                   = $params['request'];
        $objetoClasse                    = $params['object'];

        $arrayRetorno = [];
        $arrayRetorno['description'] = $objetoRequest->description;
        $arrayRetorno['cost']        = $objetoRequest->cost;
        $arrayRetorno['date']        = $objetoRequest->date;

        return array_filter($arrayRetorno);
    }
}
