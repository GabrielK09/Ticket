<?php

namespace App\Http\Controllers\Technicel\Config;

use App\Enum\Config\DefaultMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Technicel\TechnicelCommissionRequest;
use App\Services\Technicel\Config\TechnicelConfigService;
use Illuminate\Http\Request;

class TechnicelConfigController extends Controller
{
    public function __construct(
        protected TechnicelConfigService $technicelConfigService
    ){}

    public function show(string $id)
    {
        return apiSuccess(DefaultMessages::NO_CONTENT_MESSAGE, $this->technicelConfigService->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TechnicelCommissionRequest $request)
    {
        return apiSuccess(DefaultMessages::CONFIG_SUCCESS, $this->technicelConfigService->update($request->validated()));
    }
}
