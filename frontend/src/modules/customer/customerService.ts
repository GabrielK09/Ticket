import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function getAllCustomersService(ownerId: string): Promise<any> {
    try {
        const res = await api.get(`/customer/all/${ownerId}`)

        return returnSuccessApi(true, res.data.mesage, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function createCustomer(payMent: customerContract): Promise<any> {
    try {
        const res = await api.post('/customer/create', payMent);

        return returnSuccessApi(true, res.data.message, res.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function disableOrActiveCustomerService(customerId: string, ownerId: string, action: string): Promise<any> {
    try {
        const payLoad = {
            owner_id: ownerId,
            customer_id: customerId,
            action: action
        };

        const res = await api.put('/customer/new-status-customer', payLoad);
        
        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function getCustomerDataService(customerId: string, ownerId: string): Promise<any> {
    try {
        const res = await api.get(`customer/${ownerId}/customer-data/${customerId}`);
        const data: customerContract = res.data.data;
    
        const customer = {
            owner_id: ownerId,
            company_name: data.company_name,
            trade_name: data.trade_name,
            cnpj_cpf: data.cnpj_cpf,
            phone: data.phone,
            cep: data.cep,
            address: data.address,
            number: data.number,
            customerType: data.cnpj_cpf.length === 14 ? 'Jurídica' : 'Física'
        };

        return returnSuccessApi(true, '', customer);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };  
};

export async function updateCustomerService(payLoad: any, customerId: string): Promise<any> {
    try {
        const res = await api.put(`/customer/update/${customerId}`, payLoad);
        
        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};