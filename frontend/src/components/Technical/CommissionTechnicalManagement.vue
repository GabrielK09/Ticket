<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card v-if="!showLoadingComponent">
            <LoadingScreenComponet 
                :module="'commission'"

            />
        </q-card>

        <q-card class="w-[100%] h-[50%]" v-if="showLoadingComponent">
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
                        placeholder="0,00"
                        mask="##,##"
                        fill-mask="0"
                        reverse-fill-mask
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
                    @click.prevent="showDialogClose" 
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
    import { ref, watch } from 'vue';
    import * as Yup from 'yup';
    import LoadingScreenComponet from '../_LoadingScreen/LoadingScreenComponet.vue';

    const $q = useQuasar();

    const props = defineProps<{
        showDialog: boolean,
        technicalName: string,
        technicalId: string,
    }>();

    const emits = defineEmits([
        'update:showDialog'
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
    
    const internalDialog = ref(props.showDialog);

    let showLoading = ref<boolean>(false);
    let showLoadingComponent = ref<boolean>(false);
    let alreadyHave = ref<boolean>(false);

    watch(
        () => props.technicalId,
        async (newId, oldId) => {
            if(props.showDialog && newId !== oldId)
            {
                await loadComission();

            };
        }
    );

    const handleSubmit = (): void => {
        console.warn('Vai chamar handleSubmit: alreadyHave.value: ', alreadyHave.value);

        if(alreadyHave.value)
        {
            console.warn('Vai chamar updateCommissionTechnical');
            updateCommissionTechnical();

        } else {
            console.warn('Vai chamar commissionTechnicalSubmit');
            commissionTechnicalSubmit();

        };
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

                emits('update:showDialog', false);

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

                emits('update:showDialog', false);
                
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

        } finally {
            showLoadingComponent.value = true;

        };
    };

    watch(
        () => props.showDialog,
        async (open) => {
            internalDialog.value = open;

            if(open) 
            {
                await loadComission();

            };
        },
        { immediate: true }
    );

    const showDialogClose = () => {
        $q.dialog({
            message: 'Deseja sair do cadastro de comissão?',
            cancel: {
                label: 'Não',
                color: 'red',
                push: true
            },

            ok: {
                label: 'Sim',
                color: 'green',
                push: true
            }

        }).onCancel(() => {
            return;

        }).onOk(() => {
            close();

        });
    };

    const close = () => {
        emits('update:showDialog', false);
        resetForm();
    };
</script>