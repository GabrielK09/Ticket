<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card v-if="showLoadingComponent">
            <LoadingScreenComponet 
                :module="'commission'"
                @update:hidden-dialog-by-error="internalDialog = $event"
                :show-cancel-operation="showCancelOperation"
            />
        </q-card>

        <q-card class="w-[100%] h-max" v-if="!showLoadingComponent">
            <q-card-section>
                <span
                    class="q-ml-sm"
                >
                    Cadastro de comissões do funcionário: <span class="font-bold">{{ props.technicalId }}-{{ props.technicalName }}</span>
                </span>

                <div class="p-2 m-4">
                    <q-input 
                        v-model="commissionTechnical.commission_value" 
                        stack-label
                        type="number"
                        outlined
                        label="Valor" 
                    />
                    
                    <div class="mt-4 border rounded-md p-4 flex flex-col">
                        <span class="text-center mb-4">Tipo de comissão</span>

                        <q-btn 
                            color="primary" 
                            no-capas
                            label="R$"
                            class="mb-1"
                            :flat="commissionTechnical.commission_type === '%'"
                            @click="commissionTechnical.commission_type = 'R$'"
                        />

                        <q-btn 
                            color="primary" 
                            no-capas
                            label="%"
                            :flat="commissionTechnical.commission_type === 'R$'"
                            @click="commissionTechnical.commission_type = '%'"
                        />
                    </div>
                </div>
            </q-card-section>

            <q-card-actions align="right">
                <q-btn 
                    title="Sair"
                    icon="close" 
                    color="red" 
                    @click.prevent="close" 
                />

                <q-btn 
                    title="Salvar"
                    icon="save" 
                    color="primary"
                    @click="handleSubmit"
                    :loading="showLoading"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { 
        commissionTechnicalService, 
        getCommissionByTechnical, 
        updateCommissionTechnicalService 

    } from 'src/modules/technicals/technicalsService';
    
    import { computed, onMounted, ref, watch } from 'vue';
    import * as Yup from 'yup';
    import LoadingScreenComponet from '../_LoadingScreen/LoadingScreenComponet.vue';

    const $q = useQuasar();

    const props = defineProps<{
        showDialog: boolean,
        technicalName: string,
        technicalId: string,
    }>();

    const emits = defineEmits([
        'update:hiddenDialog'
    ]);

    const formErrors = ref<Record<string, string>>({});

    const commissionTechnicalSchema = Yup.object({
        commission_value: Yup.number().required('O valor de comissão precisa ser informado!').min(0, 'O valor de comissão não pode ser menor que zero!'),
        commission_type: Yup.string().required('O tipo de comissão precisa ser informado!'),
    });

    const commissionTechnical = ref<commissionTechnical>({
        owner_id: LocalStorage.getItem('owner_id'),
        technical_id: props.technicalId,
        commission_type: 'R$',
        commission_value: 0
    });
    
    let showLoading = ref<boolean>(false);
    let showLoadingComponent = ref<boolean>(true);
    let showCancelOperation = ref<boolean>(false);
    let alreadyHave = ref<boolean>(false);

    const handleSubmit = (): void => {
        console.warn('Vai chamar handleSubmit: alreadyHave.value: ', alreadyHave.value);

        alreadyHave.value ? updateCommissionTechnical() : commissionTechnicalSubmit();
    };

    const updateCommissionTechnical = async (): Promise<void> => {
        showLoading.value = true;

        try {
            await commissionTechnicalSchema.validate(commissionTechnical.value, { abortEarly: false });

            const res = await updateCommissionTechnicalService(commissionTechnical.value);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message
                });

                emits('update:hiddenDialog', false);

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

            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: error.response?.data?.message

                });
            };
        } finally {
            showLoading.value = false;
        };
    };

    const commissionTechnicalSubmit = async(): Promise<void> => {
        showLoading.value = true;

        try {
            await commissionTechnicalSchema.validate(commissionTechnical.value, { abortEarly: false });

            const res = await commissionTechnicalService(commissionTechnical.value);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message
                });

                emits('update:hiddenDialog', false);
                
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

            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: error.response?.data?.message

                });
            };

        } finally {
            showLoading.value = false;

        };
    };

    const resetForm = () => {
        alreadyHave.value = false;
        formErrors.value = {};

        commissionTechnical.value = {
            owner_id: LocalStorage.getItem('owner_id'),
            technical_id: props.technicalId,
            commission_type: 'R$',
            commission_value: 0
        };
    };

    const loadComission = async(): Promise<void> => {
        console.log('Passou pelo loadComission');
        
        try {
            resetForm();

            const res = await getCommissionByTechnical(commissionTechnical.value.owner_id, props.technicalId);
        
            if(res?.data !== null)
            {
                alreadyHave.value = true;
                
                commissionTechnical.value = {
                    owner_id: res.data.owner_id,
                    technical_id: res.data.technical_id,
                    commission_type: res.data.commission_type,
                    commission_value: res.data.commission_value
                };     
            } else {
                alreadyHave.value = false;

            };

            showLoadingComponent.value = false;

        } catch(error) {
            console.error('Erro: ', error);
            
        };
    };

    const internalDialog = computed({
        get: () => props.showDialog,
        set: (v: boolean) => emits('update:hiddenDialog', v)
        
    });

    const close = () => {
        emits('update:hiddenDialog', false);
        resetForm();

        let x = '2,2';

        x.replace(/\D/g, '.')
    };

    onMounted(() => {
        loadComission();
    });
</script>