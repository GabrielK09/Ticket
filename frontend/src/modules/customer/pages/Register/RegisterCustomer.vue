<template>    
    <section class="text-2xl">
        <div
            class="m-2"
        >
            <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) cliente</h2>

            <div class="ml-2 text-xs">
                <div 
                    @click="router.replace({ path: `/${companyName}/admin/customers` })"
                    class="flex mb-auto mt-auto cursor-pointer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 back-row">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>      
                    <span class="back-customer-label">
                        Voltar para listagem
                    </span>
                </div>
            </div>

            <q-form
                @submit.prevent="submitCustomer"
                class="q-gutter-md mt-4 form"
            >
                <div class="p-4 inputs">
                    <q-select 
                        v-model="customer.customerType" 
                        :options="customerTypes" 
                        label="Tipo de cadastro" 
                        outlined
                        stack-label
                        dense
                        class="mb-8"
                    />

                    <q-input 
                        label="" 
                        v-model="companyNameUpper" 
                        stack-label
                        outlined
                        type="text"
                        dense
                        class="mb-4"
                        :error="!!formErrors.company_name"
                        :error-message="formErrors.company_name"

                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Razão social <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>
                
                    <q-input 
                        v-model="tradeNameUpper" 
                        type="text" 
                        label="E-mail *" 
                        stack-label
                        outlined
                        dense
                        class="mb-4"
                        :error="!!formErrors.trade_name"
                        :error-message="formErrors.trade_name"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Nome fantasia <span v-show="!configCustomer.trade_name_null" class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="customer.cnpj_cpf" 
                        type="text" 
                        label="E-mail *" 
                        stack-label
                        outlined
                        dense
                        :mask="
                            customer.customerType === 'Jurídica'
                            ? '##.###.###/####-##'
                            : '###.###.###-##'
                        "
                        class="mb-4"
                        :error="!!formErrors.cnpj_cpf"
                        :error-message="formErrors.cnpj_cpf"
                        @blur="CNPJData(customer.cnpj_cpf)"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                {{ 
                                    customer.customerType === 'Jurídica' 
                                    ? 'CNPJ'
                                    : 'CPF'
                                }} <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="customer.phone" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        mask="(##) ####-####"
                        class="mb-4"
                        :error="!!formErrors.phone"
                        :error-message="formErrors.phone"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Telefone <span v-show="!configCustomer.phone_null" class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="customer.cep" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        mask="#####-###"
                        class="mb-4"
                        :error="!!formErrors.cep"
                        :error-message="formErrors.cep"
                        @blur="CEPData(customer.cep)"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                CEP <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="customer.address" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        class="mb-4"
                        :error="!!formErrors.address"
                        :error-message="formErrors.address"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Endereço <span v-show="!configCustomer.address_null" class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="customer.number" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        class="mb-4"
                        :error="!!formErrors.number"
                        :error-message="formErrors.number"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Número do endereço <span v-show="!configCustomer.number_address_null" class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <div class="flex flex-center">
                        <q-btn 
                            color="primary" 
                            type="submit" 
                            label="Cadastrar cliente"
                            no-caps
                            :loading="loadingLogin"
                        />
                    </div>
                </div>
            </q-form>
        </div>
    </section>
    <pre>
        {{ configCustomer }}
    </pre>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { computed, onMounted, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { createCustomer } from '../../customerService';
    import { getCNPJData } from 'src/services/cnpjService/cnpjService';
    import * as Yup from 'yup';
    import formatValues from 'src/util/formatValues';
    import { getCepData } from 'src/services/cep/cepService';
    import { getCustomerConfigService } from 'src/services/configs/customer/customerConfigService';

    const OWNER_ID: string = LocalStorage.getItem('owner_id');

    function convertToBool(val: any): boolean { return val === 1 ? true : false; };

    const configCustomer = ref<customerConfig>({
        owner_id: OWNER_ID,
        default_type: 'J',
        trade_name_null: false,
        phone_null: false,
        address_null: false,
        number_address_null: false
    });

    const customer = ref<customerContract>({
        owner_id: OWNER_ID,
        company_name: '',
        trade_name: '',
        cnpj_cpf: '',
        phone: '',
        cep: '',
        address: '',
        number: '',
        customerType: 'Jurídica'

    });

    function formatCustomerType(char: string): 'J'|'F'
    {
        return char === 'J' ? 'J' : 'F';
    };

    const getCustomerConfig = async(): Promise<any> => {
        const res = await getCustomerConfigService(OWNER_ID);

        const data: customerConfig = res.data;
        
        configCustomer.value = {
            owner_id: OWNER_ID,
            address_null: convertToBool(data.address_null),
            default_type:  formatCustomerType(data.default_type),
            number_address_null: convertToBool(data.number_address_null),
            phone_null: convertToBool(data.phone_null),
            trade_name_null: convertToBool(data.trade_name_null)
        };        

        customer.value.customerType = data.default_type === 'J' ? customerTypes[0].label : customerTypes[1].label;
        
    };

    const customerSchema = computed(() =>
        Yup.object({
            company_name: Yup.string().required('A razão social do cliente é obrigatório!'),
            trade_name: configCustomer.value.trade_name_null ? Yup.string().nullable() : Yup.string().required('O nome fantasia do cliente é obrigatório!'),
            cnpj_cpf: Yup.string().required('O CPF/CNPJ do cliente é obrigatório!'),
            phone: configCustomer.value.phone_null ? Yup.string().nullable() : Yup.string().required('O telefone do cliente é obrigatório!'),
            cep: Yup.string().required('O CEP do cliente é obrigatório!'),
            address: configCustomer.value.address_null ? Yup.string().nullable() : Yup.string().required('O endereço do cliente é obrigatório!') ,
            number: configCustomer.value.number_address_null ? Yup.string().nullable() : Yup.string().required('O número do cliente é obrigatório!')

        })
    );

    const customerTypes = [
        {label: 'Júridica', value: 'J'},
        {label: 'Física', value: 'F'},
    ];

    const formErrors = ref<Record<string, string>>({});

    const router = useRouter();
    const $q = useQuasar();

    const companyName = LocalStorage.getItem('companie_name_url');

    let loadingLogin = ref<boolean>(false);

    const companyNameUpper = computed({
        get: () => customer.value.company_name,
        set: (val: string) => {
            customer.value.company_name = val.toUpperCase();  
            customer.value.trade_name = val.toUpperCase();  
        }
    });
    
    const tradeNameUpper = computed({
        get: () => customer.value.trade_name,
        set: (val: string) => {
            customer.value.trade_name = val.toUpperCase();  
        }
    });

    const CEPData = async (val: string): Promise<any> => {
        if(formatValues(val).length === 8) 
        {
            const res = await getCepData(val);
            const data: ReturnCepData = res.data;

            if(res.success)
            {
                customer.value.address = data.logradouro || data.bairro;
                  
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message
                });
            };
        };
    };

    const CNPJData = async (val: string): Promise<any> => {
        if(formatValues(val).length === 14) 
        {
            const res = await getCNPJData(val);
            const data: ReturnCNPJData = res.data;

            if(res.success)
            {
                if(customer.value.company_name !== '' || customer.value.trade_name) 
                {
                    customer.value.address = data.address.street;
                    customer.value.number = data.address.number;
                    customer.value.cep = data.address.zip;  
                } else {
                    customer.value.company_name = data.company.name;
                    customer.value.trade_name = data.company.name;
                    customer.value.address = data.address.street;
                    customer.value.number = data.address.number;
                    customer.value.cep = data.address.zip;  
                };
                
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: 'CNPJ inválido ou não localizado!',

                });
            };
        };
    };

    const submitCustomer = async () => {
        try {
            await customerSchema.value.validate(customer.value, { abortEarly: false });
            
            const res = await createCustomer(customer.value);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.data.message
                    
                });
                
                router.replace({
                    name: 'customers.index'

                });
                
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message

                });
            };
            
        } catch (error: any) {
            console.error('Erro:', error.inner);
            
            if(error.inner)
            {
                formErrors.value = {};

                error.inner.forEach((err: any) => {
                    formErrors.value[err.path] = err.message;

                    $q.notify({
                        type: 'negative',
                        position: 'top',
                        message: err.message

                    });
                });  
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: error.response?.data?.message || 'Erro na criação do cliente!'

                });
            };
        };
    };

    onMounted(() => {
        getCustomerConfig();
        
    }); 
</script>