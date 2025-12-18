import { api } from "src/boot/axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";

const PREFIX_URL = '/technicel'

export async function getAllTechnicalsService(ownerId: string): Promise<any> {
    try {
        const res = await api.get(`${PREFIX_URL}/all/${ownerId}`, {
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
        const res = await api.post(`${PREFIX_URL}/creat`, payLoad, {
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

        const res = await api.put(`${PREFIX_URL}/new-status-technicel`, payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });
        
        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };
};

export async function getCommissionByTechnical(technicelId: string): Promise<any> {
    try {
        const res = await api.get(`${PREFIX_URL}/get/${technicelId}/commission`, {
            headers: {
                Accept: 'application/json'
            }
        });  
        
        return returnSuccessApi(true, '', res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};  

export async function updateCommissionTechnicalService(payLoad: any): Promise<any> {
    try {
        const res = await api.put(`${PREFIX_URL}/update/${payLoad.technical_id}/commission`, payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });

        console.log(res);
        

        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};  

export async function commissionTechnicalService(payLoad: any): Promise<any> {
    try {  
          const res = await api.post(`${PREFIX_URL}/create/commission`, payLoad, {
            headers: {
                Accept: 'application/json'
            }
        });
        
        return returnSuccessApi(true, res.data.message, res.data.data);

    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);

    };   
};