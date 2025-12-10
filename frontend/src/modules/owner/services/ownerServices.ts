import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function getAllCompanies(id: string): Promise<any> {
    try {
        const res = await api.get(`/owner/all/${id}`);

        return returnSuccessApi(true, res.data.message, res.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};

export async function ownerRegister(ownerData: ownerContract): Promise<any> {
    try {
        const res = await api.post('/owner/create', ownerData);

        return returnSuccessApi(true, res.data.message, res.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};