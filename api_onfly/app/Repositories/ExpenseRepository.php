<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Expense;

/**
 * Camada de acesso ao banco de dados
 *
 * @author Flávio Caetano <flavio.santos@empresta.com.br>
 */
class ExpenseRepository
{
    /**
     * Retorna os registros do Model responsável pelo acionamento.
     * A quantidade dos dados disponibilizados serão limitados pelo formato da paginação
     *
     * @return LengthAwarePaginator|null
     * @author Flávio Caetano <flavioluzio22@gmail.com>
     */
    public static function index(): ?LengthAwarePaginator
    {
        return Expense::whereUserId(\Auth::user()->id)->paginate();
    }

   /**
    * Cria um novo registro no banco de dados
    *
    * @param array $arrayData
    * @return \App\Models\Expense
    * @author Flávio Caetano <flavioluzio22@gmail.com>
    */
    public static function store(array $arrayData): Expense
    {
        return Expense::create($arrayData);
    }

    /**
     * Atualiza os dados do registro considerando o modelo e dados fornecidos
     *
     * @param array $arrayData
     * @param App\Models\Expense $expense
     * @return bool
     * @author Flávio Caetano <flavioluzio22@gmail.com>
     */
    public static function update(array $arrayData, Expense $expense): bool
    {
        return $expense->update($arrayData);
    }

    /**
     * Remove o registro considerando o modelo fornecido
     *
     * @param Expense $expense
     * @return bool
     * @author Flávio Caetano <flavioluzio22@gmail.com>
     */
    public static function destroy(Expense $expense): bool
    {
        return $expense->delete();
    }
}
