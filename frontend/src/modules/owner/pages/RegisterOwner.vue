<template>
    <section class="text-2xl">
        <div
            class="m-2"
        >        
            <h2 class="text-gray-600 register-title m-2">Cadastre o seu emitente!</h2>

            <q-form
                @submit="submitRegisterOwner"
                class="q-gutter-md mt-4 form"
            >
                <div class="p-4 inputs">
                    <q-select 
                        v-model="owner.ownerType" 
                        :options="ownerTypes" 
                        label="Tipo de cadastro" 
                        outlined
                        stack-label
                        dense
                        class="mb-4"
                    />

                    <q-input 
                        label="" 
                        v-model="owner.company_name" 
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

                    <q-input 
                        v-model="owner.cnae" 
                        type="text" 
                        label="" 
                        stack-label
                        outlined
                        dense
                        class="mb-4"
                        :error="!!formErrors.number"
                        :error-message="formErrors.number"
                        maxlength="24"
                    >
                        <template v-slot:label>
                            <div class="text-sm">
                                CNAE <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <q-input 
                        v-model="owner.activity" 
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
                                Atividade <span class="text-red-500">*</span>
                            </div>
                        </template>
                    </q-input>

                    <div class="flex flex-center">
                        <q-btn 
                            color="primary" 
                            type="submit" 
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
    import { ref } from 'vue';
    import { ownerRegister } from '../services/ownerServices';
    import * as Yup from 'yup';
    import { useRouter } from 'vue-router';

    const $q = useQuasar();
    const router = useRouter();
    const formErrors = ref<Record<string, string>>({});

    const ownerTypes: string[] = [
        'Jurídica',
        'Física'
    ];

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
        };
    };

</script>