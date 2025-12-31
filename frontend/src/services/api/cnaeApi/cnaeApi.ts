import { apiService } from "src/boot/axios";
import { returnErrorApi } from "src/helpers/return/returnApi";

export async function cnaeApiService(): Promise<cnaeApi[]> {
    try {
        const res = await apiService.get('/cnaes');
        const data: cnaeApi[] = res.data;

        return data;

    } catch (error) {
        ;console.error('Erro: ', error);
        
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};