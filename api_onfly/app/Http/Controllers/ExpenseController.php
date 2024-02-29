<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\ExpenseRequest;
use App\BO\ExpenseBO;

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

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Store a new resource in storage.
     *
     * @param  \App\Http\Requests\CanalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CanalRequest $request)
    {
        $this->code = config('httpstatus.success.created');

        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->store($request);
        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao salvar";
        } else {
            $this->message = "Canal criado com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Store a new resource in storage.
     *
     * @param  \App\Http\Requests\CanalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(CanalRequest $request)
    {
        $this->code = config('httpstatus.success.created');

        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->save($request);
        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao salvar";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function show(Canal $canal)
    {
        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->show($canal);

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao exibir";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CanalRequest  $request
     * @param  \App\Models\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function update(CanalRequest $request, Canal $canal)
    {
        $this->code = config('httpstatus.success.created');

        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->update($request, $canal);

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao editar";
        } else {
            $this->message = "Canal atualizado com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Canal $canal)
    {
        $expenseBO = new ExpenseBO();
        $this->return = $expenseBO->destroy($canal);

        if (!$this->return) {
            $this->code    = config('httpstatus.server_error.internal_server_error');
            $this->message = "Erro ao remover";
        } else {
            $this->message = "Canal deletado com sucesso.";
        }

        return collection($this->return, $this->code, $this->message);
    }
}
