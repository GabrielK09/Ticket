<template>    
    <section class="text-2xl">
        <div
            class="m-2"
        >
            <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) técnico</h2>

            <div class="ml-2 text-xs">
                <div 
                    @click="router.replace({ path: `/${companyNameUrl}/admin/technicals` })"
                    class="flex mb-auto mt-auto cursor-pointer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 back-row">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>      
                    <span class="back-technicel-label">
                        Voltar para listagem
                    </span>
                </div>
            </div>

            <q-form
                @submit.prevent="submitTechnicel"
                class="q-gutter-md mt-4 form"
            >
                <div class="p-4 inputs">
                    <q-select 
                        v-model="technicel.gender" 
                        :options="technicelGenders" 
                        label="Gênero" 
                        outlined
                        stack-label
                        dense
                        class="mb-8"
                    />
                    
                    <q-select 
                        v-model="technicel.technicelTypes" 
                        :options="technicelTypes" 
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
                                Nome fantasia <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="technicel.cnpj_cpf" 
                        type="text" 
                        label="E-mail *" 
                        stack-label
                        outlined
                        dense
                        :mask="
                            technicel.technicelTypes === 'Jurídica'
                            ? '##.###.###/####-##'
                            : '###.###.###-##'
                        "
                        class="mb-4"
                        :error="!!formErrors.cnpj_cpf"
                        :error-message="formErrors.cnpj_cpf"
                        @blur="CNPJData(technicel.cnpj_cpf)"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                {{ 
                                    technicel.technicelTypes === 'Jurídica' 
                                    ? 'CNPJ'
                                    : 'CPF'
                                }} <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="technicel.phone" 
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
                        v-model="technicel.cep" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        mask="#####-###"
                        class="mb-4"
                        :error="!!formErrors.cep"
                        :error-message="formErrors.cep"
                        @blur="CEPData(technicel.cep)"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                CEP <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="technicel.address" 
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
                        v-model="technicel.number" 
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
                            :label="`Cadastrar ${returnGender(technicel.gender)}`"
                            :loading="loadingLogin"
                            no-caps

                        />
                    </div>
                </div>
            </q-form>
        </div>
    </section>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { computed, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { createTechnicel } from '../../technicalsService';
    import { getCNPJData } from 'src/services/cnpjService/cnpjService';
    import * as Yup from 'yup';
    import formatValues from 'src/util/formatValues';
    import { getCepData } from 'src/services/cep/cepService';

    const technicelSchema = Yup.object({
        company_name: Yup.string().required('A razão social do cliente é obrigatório!'),
        trade_name: Yup.string().required('O nome fantasia do cliente é obrigatório!'),
        cnpj_cpf: Yup.string().required('O CPF/CNPJ do cliente é obrigatório!'),
        phone: Yup.string().required('O telefone do cliente é obrigatório!'),
        cep: Yup.string().required('O CEP do cliente é obrigatório!'),
        address: Yup.string().required('O endereço do cliente é obrigatório!'),
        number: Yup.string().required('O número do cliente é obrigatório!'), 
        gender: Yup.string().required('O genêro do técnico é obrigatório!')
    });

    const technicelTypes: string[] = [
        'Jurídica',
        'Física'
    ];

    const technicelGenders: string[] = [
        'M',
        'F',
        'O',
    ];

    const formErrors = ref<Record<string, string>>({});

    const router = useRouter();
    const $q = useQuasar();
    const companyNameUrl = LocalStorage.getItem('companie_name_url');

    const technicel = ref<technicalsContract>({
        owner_id: LocalStorage.getItem('owner_id'),
        company_name: '',
        trade_name: '',
        cnpj_cpf: '',
        phone: '',
        cep: '',
        address: '',
        number: '',
        gender: 'M',
        availability: false,
        technicelTypes: 'Jurídica',
    });

    let loadingLogin = ref<boolean>(false);

    const companyNameUpper = computed({
        get: () => technicel.value.company_name,
        set: (val: string) => {
            technicel.value.company_name = val.toUpperCase();  
            technicel.value.trade_name = val.toUpperCase();  
        }
    });
    
    const tradeNameUpper = computed({
        get: () => technicel.value.trade_name,
        set: (val: string) => {
            technicel.value.trade_name = val.toUpperCase();  
        }
    });

    const returnGender = (gender: string): string => {
        if(gender.toUpperCase() === 'O') return 'Técnic'; 
        if(gender.toUpperCase() === 'F') return 'Técnica'; 
        return 'Técnico'; 

    };

    const CEPData = async (val: string): Promise<void> => {
        if(formatValues(val).length === 8) 
        {
            const res = await getCepData(val);
            const data: ReturnCepData = res.data;

            if(res.success)
            {
                technicel.value.address = data.logradouro || data.bairro;
                  
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message
                });
            };
        };
    };

    const CNPJData = async (val: string): Promise<void> => {
        if(formatValues(val).length === 14) 
        {
            const res = await getCNPJData(val);
            const data: ReturnCNPJData = res.data;

            if(res.success)
            {
                if(technicel.value.company_name !== '' || technicel.value.trade_name) 
                {
                    technicel.value.address = data.address.street;
                    technicel.value.number = data.address.number;
                    technicel.value.cep = data.address.zip;  
                    
                } else {
                    technicel.value.company_name = data.company.name;
                    technicel.value.trade_name = data.company.name;
                    technicel.value.address = data.address.street;
                    technicel.value.number = data.address.number;
                    technicel.value.cep = data.address.zip;  
                    
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

    const submitTechnicel = async (): Promise<void> => {
        try {
            await technicelSchema.validate(technicel.value, { abortEarly: false });
            
            const res = await createTechnicel(technicel.value);
            
            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message
                    
                });
                
                router.replace({
                    name: 'technicals.index'
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
                    message: error.response?.data?.message

                });
            };
        };
    };
</script>