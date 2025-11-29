<template>
    
    <section class="text-2xl">
        <div
            class="m-2"
        >
            <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) cliente</h2>

            <div class="ml-2 text-xs">
                <div 
                    @click="router.replace({ path: '/admin/customers' })"
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

            <div>
                <q-form
                    @submit="submitCustomer"
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
                            class="mb-4"
                        />

                        <q-input 
                            label="" 
                            v-model="customer.company_name" 
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
                            v-model="customer.trade_name" 
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
                                    Nome fantasia <span class="text-red-500">*</span>
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
                                    Telefone <span class="text-red-500">*</span>
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
                                    Endereço <span class="text-red-500">*</span>
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
                                    Número do endereço <span class="text-red-500">*</span>
                                </div>
                            </template>
                        </q-input>

                        <div class="flex flex-center">
                            <q-btn 
                                color="primary" 
                                type="submit" 
                                label="Cadastrar cliente"
                                no-caps

                            />
                        </div>
                    </div>
                </q-form>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
    import { api } from 'src/boot/axios';
    import { LocalStorage, useQuasar } from 'quasar';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { createCustomer } from '../../customerService';
    import * as Yup from 'yup';

    const customerSchema = Yup.object({
        company_name: Yup.string().required('A razão social do cliente é obrigatório!'),
        trade_name: Yup.string().required('O nome fantasia do cliente é obrigatório!'),
        cnpj_cpf: Yup.string().required('O CPF/CNPJ do cliente é obrigatório!'),
        phone: Yup.string().required('O telefone do cliente é obrigatório!'),
        cep: Yup.string().required('O CEP do cliente é obrigatório!'),
        address: Yup.string().required('O endereço do cliente é obrigatório!'),
        number: Yup.string().required('O número do cliente é obrigatório!'), 
    });

    const customerTypes: string[] = [
        'Jurídica',
        'Física'
    ];

    const formErrors = ref<Record<string, string>>({});

    const router = useRouter();
    const $q = useQuasar();

    const customer = ref<customerContract>({
        owner_id: LocalStorage.getItem('owner_id'),
        company_name: '',
        trade_name: '',
        cnpj_cpf: '',
        phone: '',
        cep: '',
        address: '',
        number: '',
        customerType: 'Jurídica'
    });

    const submitCustomer = async () => {
        try {
            await customerSchema.validate(customer.value, { abortEarly: false });
            
            const res = await createCustomer(customer.value);

            console.log(res);
            
            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.data.message
                    
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
            };
        };
    };
</script>

<style lang="scss">
    @media (max-width: 1336px) {
        .register-title {
            text-align: center;
        }

        .back-customer-label {
            display: none;
        }

        .back-row {
            width: 1rem;
            height: 1rem;
        }
    }

    @media (min-width: 1336px) {
        .back-row {
            width: 0.75rem;
            height: 0.75rem;

        }
    }
</style>