<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-intersection @visibility="onVisible">
                <q-skeleton type="rect" height="180px" animation="wave" />
        </q-intersection>


        <q-card>
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
                    no-caps
                    color="primary"
                    @click.prevent="handleSubmit"
                    :loading="showLoading"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>

</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { commissionTechnicalService, getCommissionByTechnical, updateCommissionTechnicalService } from 'src/modules/technicals/technicalsService';
    import { onMounted, ref, watch } from 'vue';
    import * as Yup from 'yup';

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
    let loadingSkeleton = ref<boolean>(false);
    let alreadyHave = ref<boolean>(false);
    
    watch(() => props.showDialog, val => {
        internalDialog.value = val;
    });

    const handleSubmit = () => {
        console.warn('Vai chamar handleSubmit');

        if(alreadyHave.value)
        {
            console.warn('Vai chamar updateCommissionTechnical');
            updateCommissionTechnical();

        } else {
            console.warn('Vai chamar commissionTechnicalSubmit');
            commissionTechnicalSubmit();

        };
    };

    const updateCommissionTechnical = async () => {
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

    const commissionTechnicalSubmit = async() => {
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

    const close = () => {
        emits('update:showDialog', false);
    };

    const onVisible = async () => {

    };

    onMounted(async () => {
        try {
            const res = await getCommissionByTechnical(props.technicalId);

            if(res.data !== null)
            {
                alreadyHave.value = true;
                
                commissionTechnical.value = {
                    owner_id: res.data.owner_id,
                    technical_id: res.data.owner_id,
                    commission_type: res.data.commission_type,
                    commission_value: res.data.commission_value
                };
                
            };

            alreadyHave.value = false;

        } catch (error) {
            $q.notify({
                type: 'negative',
                position: 'top',
                message: error.response?.data?.message

            });
        };
    });
</script>