import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function getUserDataService(id: any): Promise<any> {
    try {
        const res = await api.get(`/user/find/${id}`, {
            headers: {
                Accept: 'application/json'
            }
        });

        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};

export async function updateUserService(userData: userContract): Promise<any> {
    try {
        const res = await api.put(`/user/update/${userData.id}`, {
            user_id: userData.id,
            name: userData.name,
            email: userData.email
        }, {
            headers: {
                Accept: 'application/json'
            }
        });

        return returnSuccessApi(true, res.data.message, res.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};