<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card v-if="!showLoadingComponent">
            <LoadingScreenComponet 
                :module="'config-technical'"
                @update:show-dialog="showLoadingComponent = !$event"

            />
        </q-card>

        <q-card class="w-[100%]" v-if="showLoadingComponent">
            <q-card-section>
                <div class="p-2 m-4">
                    <span class="font-bold">
                        Técnicos - Configurações
                    </span>

                    <div class="">
                        <q-select 
                            v-model="configCustomer.default_type" 
                            :options="customerType"
                            label="Tipo de cadastro padrão" 
                            filled 
                        />

                        <q-checkbox 
                            left-label 
                            v-model="configCustomer.trande_name_null" 
                            label="Permitir: Nome fantasia nulo"
                        />

                        <q-checkbox 
                            left-label 
                            v-model="configCustomer.phone_null" 
                            label="Permitir: Telefone nulo"
                        />
                        
                        <q-checkbox 
                            left-label 
                            v-model="configCustomer.address_null" 
                            label="Permitir: Endereço nulo"
                            
                        />

                        <q-checkbox 
                            left-label 
                            v-model="configCustomer.number_address_null" 
                            label="Permitir: N° endereço nulo"
                            
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
                    :loading="showLoading"
                    @click="saveConfigs"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { onMounted, ref } from 'vue';
    import LoadingScreenComponet from '../../_LoadingScreen/LoadingScreenComponet.vue';
    import { getCustomerConfigService, updateCustomerConfigService } from 'src/services/configs/customer/configService';

    const $q = useQuasar();
    
    const props = defineProps<{
        showDialog: boolean
    }>();

    const internalDialog = ref(props.showDialog);

    const customerType: string[] = [
        'Júridica',
        'Física',
    ];

    let showLoading = ref<boolean>(false);
    let showLoadingComponent = ref<boolean>(false);

    const configCustomer = ref<customerConfig>({
        owner_id: LocalStorage.getItem('owner_id'),
        default_type: 'J',
        trande_name_null: false,
        phone_null: false,
        address_null: false,
        number_address_null: false
    });

    function formatCustomerType(char: string): string
    {
        if(!customerType.some(types_ => types_.includes(char))) return;

        return char[0];
    };

    function convertToBool(val: any): boolean { return val === 1 ? true : false; };

    const emits = defineEmits([
        'update:showDialog'
    ]);

    const close = () => {
        emits('update:showDialog', false);
    };

    const saveConfigs = async(): Promise<void> => {
        showLoading.value = true;

        try {
            const prePayLoad: customerConfig = {
                owner_id: configCustomer.value.owner_id,
                default_type: formatCustomerType(configCustomer.value.default_type),
                trande_name_null: configCustomer.value.trande_name_null,
                phone_null: configCustomer.value.phone_null,
                address_null: configCustomer.value.address_null,
                number_address_null: configCustomer.value.number_address_null,
            };

            const res = await updateCustomerConfigService(prePayLoad);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message,
                });

                emits('update:showDialog', false);
                
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
        const res: any = await getCustomerConfigService(configCustomer.value.owner_id);

        const data: customerConfig = res.data;
        
        configCustomer.value = {
            owner_id: data.owner_id,
            address_null: convertToBool(data.address_null),
            default_type: data.default_type === 'J' ? customerType[0] : customerType[1],
            number_address_null: convertToBool(data.number_address_null),
            phone_null: convertToBool(data.phone_null),
            trande_name_null: convertToBool(data.trande_name_null)
        };

        if(!res.success)
        {
            $q.notify({
                type: 'negative',
                position: 'top',
                message: res.message,
            });

            emits('update:showDialog', false);

        };
    };  

    onMounted(() => {
        getConfig();
    });
</script>