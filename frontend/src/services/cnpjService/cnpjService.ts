import axios from "axios";
import { returnSuccessApi, returnErrorApi } from "src/helpers/return/returnApi";
import formatValues from "src/util/formatValues";

export async function getCNPJData(cnpj: string): Promise<any> {
    try {        
        const res = await axios.get(`${process.env.API_CNPJ_URL}/${formatValues(cnpj)}`);
        const data: ReturnCNPJData = res.data;

        const dataForReturn = {
            address: data.address,
            company: data.company
        };

        return returnSuccessApi(true, 'Dados do CNPJ!', dataForReturn);
        
    } catch (error) {
        
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};