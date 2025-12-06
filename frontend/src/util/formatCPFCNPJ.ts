export default function formatCPFCNPJ(cnpjCpf: string): string {
    const newStr = cnpjCpf.length === 14 
                ? cnpjCpf.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3-$4")
                : cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                
    return newStr;
}