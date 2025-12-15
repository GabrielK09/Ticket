import axios from "axios";
import { returnSuccessApi, returnErrorApi } from "src/helpers/return/returnApi";
import { formatNoCharCPFCNPJ } from "src/util/formatCPFCNPJ";

export async function getCNPJData(cnpj: string): Promise<any> {
    try {
        console.log(process.env.API_CNPJ_URL);
        
        const res = await axios.get(`${process.env.API_CNPJ_URL}/${formatNoCharCPFCNPJ(cnpj)}`);
        const data: ReturnCNPJData = res.data;

        const dataForRetur = {
            address: data.address,
            company: data.company
        };

        return returnSuccessApi(true, 'Dados do CNPJ!', dataForRetur);
        
    } catch (error) {
        
        return returnErrorApi(false, error.response.data?.message || 'Erro na operação!', error.response?.data?.data);
    };
};