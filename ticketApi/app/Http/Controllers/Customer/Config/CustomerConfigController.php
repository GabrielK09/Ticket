<?php

namespace App\Http\Controllers\Customer\Config;

use App\Enum\Config\DefaultMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Config\CustomerConfigRequest;
use App\Services\Config\Customer\CustomerConfigService;

class CustomerConfigController extends Controller
{
    public function __construct(
        protected CustomerConfigService $customerConfigService
        
    ){}

    public function show(string $id)
    {
        return apiSuccess(DefaultMessages::NO_CONTENT_MESSAGE, $this->customerConfigService->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerConfigRequest $request)
    {
        return apiSuccess(DefaultMessages::CONFIG_SUCCESS, $this->customerConfigService->update($request->validated()));
    }
}
