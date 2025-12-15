type Address = {
    street: string,
    number: string,
    district: string,
    city: string,
    zip: string
};

type Company = { name: string };

interface ReturnCNPJData {
    company: Company;
    address: Address;
    
};