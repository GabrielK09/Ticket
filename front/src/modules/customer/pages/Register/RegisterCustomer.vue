<template>
    <q-page>
        <section class="text-2xl">
            <div
                class="m-2"
            >
                <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) cliente</h2>

                <div class="ml-2 text-xs">
                    <div 
                        @click="router.replace({ path: '/customers' })"
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
                                    customer.customerType === 'Júridica'
                                    ? '##.###.###/####-##'
                                    : '###.###.###-##'
                                "
                                class="mb-4"
                            >
                                <template v-slot:label>
                                    <div class="text-sm">
                                        {{ 
                                            customer.customerType === 'Júridica' 
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
    </q-page>
</template>

<script setup lang="ts">
    import { api } from 'src/boot/axios';
    import { useQuasar } from 'quasar';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
import { createCustomer } from '../../customerService';

    const customerTypes: string[] = [
        'Júridica',
        'Física'
    ];

    const router = useRouter();
    const $q = useQuasar();

    const customer = ref<customerContract>({
        owner_id: '',
        company_name: '',
        trade_name: '',
        cnpj_cpf: '',
        phone: '',
        cep: '',
        address: '',
        number: '',
        customerType: 'Júridica'
    });

    const submitCustomer = async () => {
        const res = await createCustomer(customer.value);

        if(res.data.success)
        {
            $q.notify({
                type: 'positive',
                message: res.data.message
            });
            
        } else {
            $q.notify({
                type: 'negative',
                message: res.data.message
            });
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