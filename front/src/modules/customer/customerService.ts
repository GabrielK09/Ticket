import { api } from "src/boot/axios";

export async function createCustomer(payMent: customerContract) {
    try {
        const res = await api.post('/customer/create');

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
            status: error.response.status

        };
    };   
};