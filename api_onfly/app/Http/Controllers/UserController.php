<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\BO\UserBO;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    private $return;
    private $code;
    private $message;

    /**
     * Set default values to return in
     */
    public function __construct()
    {
        $this->return  = false;
        $this->code    = config('httpstatus.success.ok');
        $this->message = null;
    }

    /**
     * Busca todas as despesas do usuario logado
     *
     */
    public function getExpenses()
    {
        $this->code = config('httpstatus.success.created');

        $userBO = new UserBO();
        $this->return = $userBO->getExpenses();
        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao salvar";
        }

        return new UserResource($this->return);
    }
}
