interface ticketContract {
    readonly owner_id: string;
    customer_id: string;
    title: string;
    description: string;
    priority: string;
    location: string;
    location_value: number;
    increase_value: number;
    increase_tpye: string;
    discount_value: number;
    discount_type: string;
    base_value: number;           

    date_paid: string;
    status: string;

    // Para alterações e finalização
    ticket_id: string;
    ticket_code: string;
    operation: string;
    amount_paid: number;
    pay_ment_form_id: string;
};