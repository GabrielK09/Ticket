import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function getAllTechnicalsService(ownerId: string): Promise<any> {
    try {
        const res = await api.get(`/technicals/all/${ownerId}`)

        return returnSuccessApi(true, res.data.mesage, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};
