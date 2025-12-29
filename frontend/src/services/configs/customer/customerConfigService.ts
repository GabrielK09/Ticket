import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

const CONFIG_CUSTOMER_PREFIX = '/config/customer';

export async function updateCustomerConfigService(payLoad: customerConfig): Promise<any> 
{
    try {
        const res = await api.put(`${CONFIG_CUSTOMER_PREFIX}/update-config`, payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });

        return returnSuccessApi(true, res.data.message, res.data.data);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function getCustomerConfigService(ownerId: string): Promise<any> 
{
    try {
        const res = await api.get(`${CONFIG_CUSTOMER_PREFIX}/get-config/${ownerId}`, {
            headers: {
                Accept: 'application/json'
            }
        });

        return returnSuccessApi(true, res.data.message, res.data.data);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };      
};