import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

const CONFIG_TECHNICAL_PREFIX = '/config/technicel';

export async function updateTechnicalConfigService(payLoad: technicalConfig): Promise<any> 
{
    try {
        const res = await api.put(`${CONFIG_TECHNICAL_PREFIX}/update-config`, payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });
        return returnSuccessApi(true, res.data.message, res.data.data);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};

export async function getTechnicalConfigService(ownerId: string): Promise<any>
{
    try {
        const res = await api.get(`${CONFIG_TECHNICAL_PREFIX}/get-config/${ownerId}`, {
            headers: {
                Accept: 'application/json'
            }
        });

        return returnSuccessApi(true, res.data.message, res.data.data);
    
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};