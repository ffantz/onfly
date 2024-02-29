<?php

namespace App\BO;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\ExpenseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Expense;
use App\BO\Traits\ExpenseTrait;
use App\Notifications\ExpenseNotification;

/**
 * Define a regra de negocio do modelo, sendo a unica camada permitida a acessar a camada de banco de dados (repository)
 *
 * @author Flávio Caetano <flavio.santos@empresta.com.br>
 */
class ExpenseBO
{
    use ExpenseTrait;

    /**
     * Displays a resource's list
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return ExpenseRepository::index();
    }

    /**
     * Store a new resource in storage
     *
     * @param \App\Http\Requests\ExpenseRequest  $request
     * @return Expense
     */
    public function store($request): Expense
    {
        $expense = ExpenseRepository::store($this->prepare($request));
        $expense->email = \Auth::user()->email;

        // $expense->notify((new ExpenseNotification($expense))->delay(now()->addMinutes(1)));
        return $expense;
    }

    /**
     * Display an specific resource.
     *
     * @param \App\Models\Expense  $expense
     * @return \App\Models\Expense
     */
    public function show($expense): \App\Models\Expense
    {
        return $expense;
    }

    /**
     * Update an specific resource in storage.
     *
     * @param \App\Http\Requests\ExpenseRequest  $request
     * @param \App\Models\Expense  $expense
     * @return bool
     */
    public function update($request, $expense): bool
    {
        return ExpenseRepository::update($this->prepare($request, $expense), $expense);
    }

    /**
     * Delete an specific resource from storage.
     *
     * @param \App\Models\Expense  $expense
     * @return bool
     */
    public function destroy($expense): bool
    {
        return ExpenseRepository::destroy($expense);
    }
}
