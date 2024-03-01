<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomRulesRequest;

class ExpenseRequest extends CustomRulesRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return Bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return Array
     */
    public function validateDefault(): array
    {
        return [
            // Your default validation
        ];
    }

    /**
     * @return Array
     */
    public function validateToStore(): array
    {
        return [
            'description' => 'required|max:191',
            'date' => 'required|date|before_or_equal:now',
            'cost' => 'required|gte:0|decimal:0,2',
        ];
    }

    /**
     * @return Array
     */
    public function validateToUpdate(): array
    {
        return [
            'description' => 'required|max:191',
            'date' => 'required|date|before_or_equal:now',
            'cost' => 'required|gte:0|decimal:0,2',
        ];
    }

    /**
     * @return Array
     */
    public function validateToDestroy(): array
    {
        return [
            // 'id' => 'required',
        ];
    }

    /**
     * @return Array
     */
    public function messages(): array
    {
        return [
            'description.required' => 'O campo descriçao é obrigatorio.',
            'date.required' => 'O campo data é obrigatorio.',
            'cost.required' => 'O campo valor é obrigatorio.',

            'description.max' => 'A descricao deve conter no maximo 191 caracteres.',

            'date.date' => 'O campo data deve ser uma data valida.',

            'date.before_or_equal' => 'A data deve ser igual ou antes de hoje.',

            'cost.gte' => 'O campo valor deve ser maior que 0.',

            'cost.decimal' => 'O campo valor deve ter no maximo 2 casas decimais.'
        ];
    }

    protected function getValidatorInstance()
    {
        // Captura o parâmetro injetado na rota sem utilizar query.
        // Assim, a rota que seria dessa forma: /usuario?id=12
        // passa a ser utilizada dessa forma: /usuario/12
        // $data = $this->all();
        // $data['exemplo'] = trim($this->exemplo);

        // foreach ($this->getNameParams() AS $key => $value)
        // {
        //     if (\trim($this->$value) != ""){
        //         $data[$value] = trim($this->$value);
        //     }
        // }
        // $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
