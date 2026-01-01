<template>
    <section class="register-form">
        <div class="m-2 app">
            <div class="q-pa-sm">
                <div
                    @click="router.replace({ path: '/owners' })"
                    class="flex items-center cursor-pointer text-grey-7"
                >
                    <q-icon name="arrow_back" size="18px" class="q-mr-xs" />
                    <span class="back-customer-label text-caption">Voltar para listagem</span>
                </div>

                <h2 class="text-grey-7 text-h6 q-mt-md q-mb-lg register-title">
                    Cadastre sua empresa
                </h2>

                <q-form 
                    @submit.prevent="submitRegisterOwner"
                >
                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-md-6">
                            <q-select
                                v-model="owner.ownerType"
                                :options="ownerTypes"
                                label="Tipo de cadastro"
                                outlined
                                dense
                                emit-value
                                map-options
                                :options-dense="true"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model="owner.cnpj_cpf"
                                outlined
                                dense
                                :label="owner.ownerType === 'Jurídica' ? 'CNPJ *' : 'CPF *'"
                                :mask="owner.ownerType === 'Jurídica' ? '##.###.###/####-##' : '###.###.###-##'"
                                :error="!!formErrors.cnpj_cpf"
                                :rules="[owner.ownerType !== 'Jurídica' ? validateCPF : null, checkExistsCnpjCpf]"
                                :error-message="formErrors.cnpj_cpf"
                                @blur="CNPJData(owner.cnpj_cpf)"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model.trim="owner.company_name"
                                outlined
                                dense
                                :label="owner.ownerType === 'Jurídica' ? 'Razão social *' : 'Nome completo *'"
                                :error="!!formErrors.company_name"
                                :error-message="formErrors.company_name"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model.trim="owner.trade_name"
                                outlined
                                dense
                                label="Nome fantasia *"
                                :error="!!formErrors.trade_name"
                                :error-message="formErrors.trade_name"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model="owner.phone"
                                outlined
                                dense
                                label="Telefone *"
                                mask="(##) #####-####"
                                :error="!!formErrors.phone"
                                :error-message="formErrors.phone"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model="owner.cep"
                                outlined
                                dense
                                label="CEP *"
                                mask="#####-###"
                                :error="!!formErrors.cep"
                                :error-message="formErrors.cep"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model.trim="owner.address"
                                outlined
                                dense
                                label="Endereço *"
                                :error="!!formErrors.address"
                                :error-message="formErrors.address"
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <q-input
                                v-model.trim="owner.number"
                                outlined
                                dense
                                label="Número *"
                                :error="!!formErrors.number"
                                :error-message="formErrors.number"
                            />
                        </div>

                        <div class="col-12">
                            <q-select
                                v-model="owner.cnae"
                                :options="options"
                                option-value="value"
                                option-label="label"
                                outlined
                                dense
                                label="CNAE *"
                                use-input
                                input-debounce="0"
                                clearable
                                hide-selected
                                fill-input
                                @filter="filterCnaeList"
                                :error="!!formErrors.cnae"
                                :error-message="formErrors.cnae"
                            />
                        </div>

                        <div class="col-12">
                            <q-input
                                v-model.trim="owner.activity"
                                outlined
                                dense
                                label="Atividade *"
                                :error="!!formErrors.activity"
                                :error-message="formErrors.activity"
                            />
                        </div>

                        <div class="col-12 flex flex-center q-mt-md">
                            <q-btn
                                color="primary"
                                type="submit"
                                no-caps
                                label="Cadastrar"
                                :loading="loadingLogin"
                            />
                        </div>
                    </div>
                </q-form>
            </div>
        </div>
    </section>
    <pre>
        {{ owner }}
    </pre>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { onMounted, ref } from 'vue';
    import { checkExistsCnpjCpfService, ownerRegister } from '../services/ownerServices';
    import * as Yup from 'yup';
    import { useRouter } from 'vue-router';
    import { validateCPF } from 'src/util/validate/validateCPFCNPJ';
    import { getCNPJData } from 'src/services/cnpjService/cnpjService';
    import { cnaeApiService } from 'src/services/api/cnaeApi/cnaeApi';
import { formatCPFCNPJ } from 'src/util/formatCPFCNPJ';

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
            const cnaeObject: any = owner.value.cnae;            
            const prePayLoad = owner.value = {
                id: null,
                user_id: LocalStorage.getItem('user_id'),
                company_name: owner.value.company_name,
                trade_name: owner.value.trade_name,
                cnpj_cpf: owner.value.cnpj_cpf,
                phone: owner.value.phone,
                cep: owner.value.cep,
                address: owner.value.address,
                number: owner.value.number,
                cnae: cnaeObject.value,
                activity: owner.value.activity,
                ownerType: 'Jurídica'
            };


            await ownerSchema.validate(prePayLoad, { abortEarly: false });
            
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
            const filtred = cnaeList.filter((v: cnaeListProps) => v.label.toLowerCase().indexOf(char) > -1);
            options.value = filtred;

        });
    };

    const checkExistsCnpjCpf = (val: string) => {
        if(val === '') return;
        if(formatCPFCNPJ(val).length < 14) return;

        return true;
    };

    onMounted(getCnaeApi);
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