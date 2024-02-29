<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\BO\ExpenseBO;
use App\Models\Expense;
use App\Http\Resources\ExpenseResource;

/**
 * Camada de gerenciamento de rotas e direcionamento para a camada de BO
 * Possui no construtor a referencia para todas as politicas de permissao de acao
 * Metodos de exibicao de dados possuem a transformacao dos mesmos de forma a limpar o retorno, enquanto metodos de acao no banco retornam os dados originais
 *
 * @author Flávio Caetano <flavio.santos@empresta.com.br>
 */
class ExpenseController extends Controller
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

        $this->authorizeResource(Expense::class, 'expense');
    }

    /**
     * Displays a resource's list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->index();

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao buscar";
        }

        return ExpenseResource::collection($this->return);
    }

    /**
     * Store a new resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $this->code = config('httpstatus.success.created');

        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->store($request);
        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao salvar";
        } else {
            $this->message = "Despesa criada com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $this->code = config('httpstatus.success.created');

        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->update($request, $expense);

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao editar";
        } else {
            $this->message = "Despesa atualizada com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->destroy($expense);

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao remover";
        } else {
            $this->message = "Despesa deletada com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }
}
