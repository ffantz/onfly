<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CustomRulesRequest extends FormRequest
{
    /**
     * Chama os metodos dinamicamente
     *
     * @return  Array
     */
    public function rules(): array
    {
        $method = "validateTo" . Str::ucfirst($this->route()->getActionMethod());
        return $this->$method();
    }
}
