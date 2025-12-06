import { api } from "src/boot/axios";

export async function getUserDataService(id: any): Promise<any> {
    try {
        const res = await api.get(`/user/find/${id}`);

        const data = res.data;

        return {
            success: res.data.success,
            message: data.message,
            data: data

        };

    } catch (error) {
        return {
            success: false,
            message: error.response.data?.message || 'Erro na operação!',
            status: error.response.status

        };
    };
};

export async function updateUserService(userData: userContract): Promise<any> {
    try {
        const res = await api.put(`/user/update/${userData.id}`, {
            user_id: userData.id,
            name: userData.name,
            email: userData.email
        });

        return {
            success: res.data.success,
            message: res.data.message,
            data: res.data

        };

    } catch (error) {
        return {
            success: false,
            message: error.response.data?.message || 'Erro na operação!',
            status: error.response.status

        };  
    };
};