import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function loginService(email: string, password: string): Promise<any> {
    try {
        const res = await api.post('/auth/login', {
            email: email,
            password: password

        });

        return {
            success: res.data.success,
            message: res.data.message,
            user: res.data.user,
            token: res.data.token

        };

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};

export async function registerService(name: string, email: string, password: string) {
    try {
        const res = await api.post('/auth/register', {
            name: name,
            email: email,
            password: password

        });

        return returnSuccessApi(true, res.data.message, res.data);
    } catch (error) {
        console.error(error);

        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};

export async function logoutService() {
    try {
        const res = await api.post('/auth/logout');

        return returnSuccessApi(true, res.data.message, res.data);
    } catch (error) {
        console.error(error);

        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    }
}