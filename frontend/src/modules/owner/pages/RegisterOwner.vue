<template>
    <section class="text-2xl register-form">
        <div
            class="m-2 app"
        >        
            <h2 class="text-gray-600 register-title m-2">Cadastre sua empresa!</h2>

            <div class="ml-2 text-xs">
                <div 
                    @click="router.replace({ path: '/owners' })"
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
                @submit.prevent="submitRegisterOwner"
                class="q-gutter-md mt-4 form"
            >
                <div class="p-4">
                    <q-select 
                        v-model="owner.ownerType" 
                        :options="ownerTypes" 
                        label="Tipo de cadastro" 
                        outlined
                        stack-label
                        dense
                        class="mb-6"
                    />

                    <q-input 
                        label="" 
                        v-model="owner.company_name" 
                        stack-label
                        outlined
                        type="text"
                        dense
                        class="mb-2"
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
                        v-model="owner.trade_name" 
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
                        v-model="owner.cnpj_cpf" 
                        type="text" 
                        label="E-mail *" 
                        stack-label
                        outlined
                        dense
                        :mask="
                            owner.ownerType === 'Jurídica'
                            ? '##.###.###/####-##'
                            : '###.###.###-##'
                        "
                        class="mb-4"
                        :error="!!formErrors.cnpj_cpf"
                        :error-message="formErrors.cnpj_cpf"
                        :rules="[owner.ownerType !== 'Jurídica' ? validateCPF : null]"
                        @blur="CNPJData(owner.cnpj_cpf)"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                {{ 
                                    owner.ownerType === 'Jurídica' 
                                    ? 'CNPJ'
                                    : 'CPF'
                                }} <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="owner.phone" 
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
                        v-model="owner.cep" 
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
                        v-model="owner.address" 
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
                        v-model="owner.number" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        class="mb-1"
                        :error="!!formErrors.number"
                        :error-message="formErrors.number"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Número do endereço <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-select 
                        v-model="owner.cnae" 
                        :options="options" 
                        option-value="cnae"
                        label=""
                        stack-label
                        emit-value
                        map-options
                        outlined
                        dense
                        :use-input="owner.cnae === ''"
                        input-debounce="0"
                        class="mb-4"
                        @filter="filterCnaeList"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                CNAE <span class="text-red-500">*</span>
                            </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <div class="h-4">
                                {{ scope.opt.label }}
                            </div>
                        </template>
                    </q-select>

                    <q-input 
                        v-model="owner.activity" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        class="mb-4"
                        :error="!!formErrors.activity"
                        :error-message="formErrors.activity"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                Atividade <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <div class="flex flex-center">
                        <q-btn 
                            color="primary" 
                            type="submit" 
                            :loading="loadingLogin"
                            label="Cadastrar empresa"
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
    import { onMounted, ref } from 'vue';
    import { ownerRegister } from '../services/ownerServices';
    import * as Yup from 'yup';
    import { useRouter } from 'vue-router';
    import { validateCPF } from 'src/util/validate/validateCPFCNPJ';
    import { getCNPJData } from 'src/services/cnpjService/cnpjService';
    import { cnaeApiService } from 'src/services/api/cnaeApi/cnaeApi';

    type cnaeListProps = {
        label: string;
        value: string;
        attachment: string;
    };

    const $q = useQuasar();
    const router = useRouter();
    const formErrors = ref<Record<string, string>>({});

    const ownerTypes: string[] = [
        'Jurídica',
        'Física'
    ];

    let cnaeList: any[] = [] ;
    let options = ref(cnaeList);

    let loadingLogin = ref<boolean>(false);

    const ownerSchema = Yup.object({
        user_id: Yup.string().required(''),
        company_name: Yup.string().required('A razão social da empresa é obrigatório!'),
        trade_name: Yup.string().required('O nome fantasia da empresa é obrigatório!'),
        cnpj_cpf: Yup.string().required('O CPF/CNPJ da empresa é obrigatório!'),
        phone: Yup.string().required('O telefone da empresa é obrigatório!'),
        cep: Yup.string().required('O CEP da empresa é obrigatório!'),
        address: Yup.string().required('O endereço da empresa é obrigatório!'),
        number: Yup.string().required('O número da empresa é obrigatório!'), 
        cnae: Yup.string().required('O CNAE da empresa é obrigatório!'),
        activity: Yup.string().required('A atividade da empresa é obrigatório!'),

    });
    
    const owner = ref<ownerContract>({
        id: null,
        user_id: LocalStorage.getItem('user_id'),
        company_name: '',
        trade_name: '',
        cnpj_cpf: '',
        phone: '',
        cep: '',
        address: '',
        number: '',
        cnae: '',
        activity: '',
        ownerType: 'Jurídica'
    });
    
    const submitRegisterOwner = async () => {
        $q.notify({
            type: 'info',
            color: 'green',
            position: 'top',
            message: 'Processando dados...'

        });
        
        loadingLogin.value = true;

        try {
            await ownerSchema.validate(owner.value, { abortEarly: false });

            const res = await ownerRegister(owner.value);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    message: res.message,
                    position: 'top'
                });

                router.replace({
                    path: '/owners'

                });
            } else {
                 $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message

                });   
            };

        } catch (error) {
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
        } finally {
            loadingLogin.value = false;
        };
    };

    const CNPJData = async (val: string): Promise<any> => {
        if(owner.value.ownerType === 'Jurídica' && val.replace(/\D/g, '').length === 14) 
        {
            const res = await getCNPJData(val);
            const data: ReturnCNPJData = res.data;

            console.log(res);

            if(res.success)
            {
                owner.value.address = data.address.street;
                owner.value.number = data.address.number;
                owner.value.cep = data.address.zip;
                owner.value.company_name = data.company.name;
                owner.value.trade_name = data.company.name;
                
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: 'CNPJ inválido ou não localizado!'

                });
            };
        };
    };

    const getCnaeApi = async() => {
        options.value = (await cnaeApiService()).map(i => ({
            label: `${i.cnae} - ${i.description} - Anexo: ${i.attachment}`,
            value: i.cnae
        }));

        cnaeList = options.value;
    };

    const filterCnaeList = (val: string, update: any): any => {
        if(val === ''){            
            update(() => {
                options.value = cnaeList;
            });
            return;
        };

        update(() => {
            const char = val.toLowerCase();            
            options.value = cnaeList.filter((v: cnaeListProps) => v.label.toLowerCase().indexOf(char) > -1);
        });
    };

    onMounted(() => {
        getCnaeApi();
    });
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
        .register-form {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }   

        .register-form .app {
            width: 40%;
        }

        .back-row {
            width: 0.75rem;
            height: 0.75rem;

        }
    }
</style>