import { api } from "src/boot/axios";

export async function loginService(email: string, password: string): Promise<any>
{
    try {
        const res = await api.post('/auth/login', {
            email: email,
            password: password

        });

        console.log('Res: ', res.data);
        
        
        return {
            success: res.data.success,
            message: res.data.message,
            data: res.data

        };
    } catch (error) {
        console.error(error);
        
        return {
            success: false,
            message: error.response.data?.message || 'Erro na operação!',
            status: error.response.status,
            data: error.response?.data?.data

        };
    };
};

export async function registerService(name:string, email: string, password: string) {
    try {
        const res = await api.post('/auth/register', {
            name: name,
            email: email,
            password: password

        });
        
        return {
            success: res.data.success,
            message: res.data.message,
            data: res.data

        };
    } catch (error) {
        console.error(error);
        
        return {
            success: false,
            message: error.response.data?.message || 'Erro na operação!',
            status: error.response.status,
            data: error.response?.data?.data

        };
    };   
};