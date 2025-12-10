import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function createTicket(params: any): Promise<any> {
    try {
        const res = await api.post('/tickets', params);

        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};