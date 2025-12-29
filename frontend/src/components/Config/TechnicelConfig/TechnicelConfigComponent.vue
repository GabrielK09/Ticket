<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card v-if="showLoadingComponent">
            <LoadingScreenComponet 
                :module="'config-technical'"
                @update:hidden-dialog-by-error="internalDialog = $event"
                :show-cancel-operation="showCancelOperation"
            />
        </q-card>

        <q-card class="w-[100%]" v-if="!showLoadingComponent">
            <q-card-section>
                <div class="p-2 m-4">
                    <span class="font-bold">
                        Técnicos - Configurações
                    </span>

                    <q-select 
                        v-model="configTechnical.default_type" 
                        :options="customerType"
                        option-label="label"
                        option-value="value"
                        emit-value
                        map-options
                        label="Tipo de cadastro padrão" 
                        filled 
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <q-checkbox 
                            left-label 
                            v-model="configTechnical.trade_name_null" 
                            label="Permitir: Nome fantasia nulo"
                        />

                        <q-checkbox 
                            left-label 
                            v-model="configTechnical.phone_null" 
                            label="Permitir: Telefone nulo"
                        />
                        
                        <q-checkbox 
                            left-label 
                            v-model="configTechnical.address_null" 
                            label="Permitir: Endereço nulo"
                            
                        />

                        <q-checkbox 
                            left-label 
                            v-model="configTechnical.number_address_null" 
                            label="Permitir: N° endereço nulo"
                            
                        />
                        
                        <q-btn 
                            label="s"    
                            no-caps
                        />

                        <q-input 
                            v-model="configTechnical.fixed_commission_value" 
                            type="text" 
                            label="Label" 
                        />
                    </div>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn 
                    title="Sair"
                    icon="close" 
                    color="red" 
                    @click.prevent="emits('update:hiddenDialog', true)" 
                />

                <q-btn 
                    title="Salvar"
                    icon="save" 
                    color="primary"
                    :loading="showLoading"
                    @click="saveConfigs"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { computed, onMounted, ref } from 'vue';
    import LoadingScreenComponet from '../../_LoadingScreen/LoadingScreenComponet.vue';
    import { getTechnicalConfigService, updateTechnicalConfigService } from 'src/services/configs/technical/technicalConfigService';

    const $q = useQuasar();
    
    const props = defineProps<{
        showDialog: boolean
    }>();

    const internalDialog = computed({
        get: () => props.showDialog,
        set: (v: boolean) => emits('update:hiddenDialog', v)
    });

    const customerType = [
        {label: 'Júridica', value: 'J'},
        {label: 'Física', value: 'F'},
    ];

    const showCancelOperation = ref<boolean>(false);
    let showLoading = ref<boolean>(false);
    let showLoadingComponent = ref<boolean>(true);

    const configTechnical = ref<technicalConfig>({
        owner_id: LocalStorage.getItem('owner_id'),
        default_type: 'J',
        trade_name_null: false,
        phone_null: false,
        address_null: false,
        number_address_null: false,
        default_commission_type: 'R$',
        fixed_commission_value: 0
    });


    function formatCustomerType(char: string): 'J' | 'F'
    {
        return char === 'Júridica' ? 'J' : 'F';
    };

    function convertToBool(val: any): boolean { 
        return val === true || val === 1 || val === '1' ;
    };

    const emits = defineEmits([
        'update:hiddenDialog'
    ]);

    const saveConfigs = async(): Promise<void> => {
        showLoading.value = true;

        try {
            const prePayLoad: technicalConfig = {
                owner_id: configTechnical.value.owner_id,
                default_type: formatCustomerType(configTechnical.value.default_type),
                trade_name_null: configTechnical.value.trade_name_null,
                phone_null: configTechnical.value.phone_null,
                address_null: configTechnical.value.address_null,
                number_address_null: configTechnical.value.number_address_null,
                default_commission_type: 'R$',
                fixed_commission_value: 0
            };

            const res = await updateTechnicalConfigService(prePayLoad);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message,
                });

                emits('update:hiddenDialog', false);
                
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message,
                });
            };    
        } finally {
            showLoading.value = false;
        };
    };

    const getConfig = async(): Promise<void> => {
        try {
            const res: any = await getTechnicalConfigService(configTechnical.value.owner_id);

            const data: technicalConfig = res.data;
            
            configTechnical.value = {
                owner_id: data.owner_id,
                address_null: convertToBool(data.address_null),
                default_type: data.default_type === 'J' ? customerType[0].value : customerType[1].value,
                number_address_null: convertToBool(data.number_address_null),
                phone_null: convertToBool(data.phone_null),
                trade_name_null: convertToBool(data.trade_name_null),
                default_commission_type: data.default_commission_type,
                fixed_commission_value: data.fixed_commission_value
            };

            if(!res.success)
            {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message,
                });

                emits('update:hiddenDialog', true);
            };

            showLoadingComponent.value = false;
            
        } catch (error) {
            $q.notify({
                type: 'negative',
                position: 'top',
                message: 'Erro ao consultar as configurações, por gentileza, contate o suporte técnico!'

            });

            showCancelOperation.value = true;  
        };
    };  

    onMounted(() => {
        getConfig();
    });
</script>