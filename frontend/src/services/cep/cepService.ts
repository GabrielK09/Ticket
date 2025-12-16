import axios from "axios";
import { returnErrorApi, returnSuccessApi } from "src/helpers/return/returnApi";
import formatValues from "src/util/formatValues";

export async function getCepData(cep: string): Promise<any>  {
    try {

        const res = await axios.get(`${process.env.API_CEP}/${formatValues(cep)}/json`);
        const data: ReturnCepData = res.data;

        return returnSuccessApi(true, '', data);
        
    } catch (error) {
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
        
    };
};