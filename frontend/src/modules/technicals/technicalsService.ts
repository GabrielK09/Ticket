import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

export async function getAllTechnicalsService(ownerId: string): Promise<any> {
    try {
        const res = await api.get(`/technicel/all/${ownerId}`, {
            headers: {
                Accept: 'application/json'
            }
        })

        return returnSuccessApi(true, res.data.mesage, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function createTechnicel(payLoad: technicalsContract): Promise<any> {
    try {
        const res = await api.post('/technicel/create', payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });
        
        return returnSuccessApi(true, res.data.message, res.data.data);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function disableOrActiveTechnicelService(technicelId: string, ownerId: string, action: string): Promise<any> {
    try {
        const payLoad = {
            owner_id: ownerId,
            customer_id: technicelId,
            action: action
        };

        const res = await api.put('/technicel/new-status-technicel', payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });
        
        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};