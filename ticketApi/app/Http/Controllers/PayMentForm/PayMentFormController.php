<?php

namespace App\Http\Controllers\PayMentForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayMentForm\PayMentFormRequest;
use App\Services\PayMent\PayMentService;
use Illuminate\Http\Request;

class PayMentFormController extends Controller
{
    public function __construct(
        protected PayMentService $payMentService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PayMentFormRequest $request)
    {
        return apiSuccess('Espécie cadastrada com sucesso!', $this->payMentService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
