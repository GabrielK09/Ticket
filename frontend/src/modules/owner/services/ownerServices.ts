import { api } from "src/boot/axios";

export async function getAllCompanies(id: string): Promise<any> {
    try {
        const res = await api.get(`/owner/all/${id}`);
        
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

export async function ownerRegister(ownerData: ownerContract): Promise<any> {
    try {
        const res = await api.post('/owner/create', ownerData);
        
        return {
            success: res.data.success,
            message: res.data.message,
            data: res.data

        };
        
    } catch (error) {
        console.error('Erro: ', error);
        
        return {
            success: false,
            message: error.response.data?.message || 'Erro na operação!',
            status: error.response.status

        };
    };
};

