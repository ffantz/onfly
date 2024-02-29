<?php

namespace App\BO;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

/**
 * Define a regra de negocio do modelo, sendo a unica camada permitida a acessar a camada de banco de dados (repository)
 *
 * @author Flávio Caetano <flavio.santos@empresta.com.br>
 */
class UserBO
{
    /**
     * Busca as despesas de um usuario
     *
     * @return User
     */
    public function getExpenses(): ?User
    {
        return UserRepository::getExpenses();
    }
}
