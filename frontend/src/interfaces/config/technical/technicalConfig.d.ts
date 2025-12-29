interface technicalConfig {
    owner_id: string;
    default_type: string;
    trade_name_null: boolean;
    phone_null: boolean;
    address_null: boolean;
    number_address_null: boolean;
    default_commission_type: 'R$'|'%';
    fixed_commission_value: number;
};