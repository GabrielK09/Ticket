import { api } from "src/boot/axios";

export default async function ownerRegister(ownerData: ownerContract) {
    try {
        const res = await api.post('/owner/create', {
            

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