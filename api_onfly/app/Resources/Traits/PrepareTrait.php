<?php
namespace App\Resources\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Define um escopo generico para ser reutilizado em models
 *
 * @author Flávio Caetano <flavoluzio22@gmail.com>
 */
trait PrepareTrait
{
    /**
     * Chama outros metodos dinamicamente
     *
     * @param Request $request
     * @param object $object opcional, geralmente um model
     * @return void
     */
    public function prepare(Request $request, $object = null)
    {
        /*
         * A criaçao desse array permite uma quantidade dinamica de parametros
         */
        $params = [
            'request' => $request,
            'object' => $object,
        ];

        $method = isset($object->method) ? "prepare".Str::ucfirst($object->method) : "prepare".Str::ucfirst(debug_backtrace()[1]['function']);
        return $this->$method($params);
    }
}
