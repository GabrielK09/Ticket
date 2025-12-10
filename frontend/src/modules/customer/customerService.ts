import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function createCustomer(payMent: customerContract) {
    try {
        const res = await api.post('/customer/create', payMent);

        return returnSuccessApi(true, res.data.message, res.data);

    } catch (error) {
        console.error(error.response.data.errors);

        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};