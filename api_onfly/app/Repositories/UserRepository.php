<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

/**
 * Camada de acesso ao banco de dados
 *
 * @author Flávio Caetano <flavio.santos@empresta.com.br>
 */
class UserRepository
{
    /**
     * Retorna os registros do Model responsável pelo acionamento.
     * A quantidade dos dados disponibilizados serão limitados pelo formato da paginação
     *
     * @return User|null
     * @author Flávio Caetano <flavioluzio22@gmail.com>
     */
    public static function getExpenses(): ?User
    {
    return User::whereId(\Auth::user()->id)->with('expenses')->first();
    }
}
