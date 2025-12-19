<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card v-if="!showLoadingComponent">
            <LoadingScreenComponet 
                :module="'config-customer'"

            />
        </q-card>

        <q-card class="w-[100%] h-[50%]" v-if="showLoadingComponent">
            <q-card-section>
                <div class="p-2 m-4">
                    
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
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { useQuasar } from 'quasar';
    import { ref } from 'vue';
    import LoadingScreenComponet from '../../_LoadingScreen/LoadingScreenComponet.vue';

    const $q = useQuasar();
    
    const props = defineProps<{
        showDialog: boolean
    }>();

    const formErrors = ref<Record<string, string>>({});
    const internalDialog = ref(props.showDialog);

    let showLoading = ref<boolean>(false);
    let showLoadingComponent = ref<boolean>(false);

    const emits = defineEmits([
        'update:showDialog'
    ]);

    const close = () => {
        emits('update:showDialog', false);
    };
</script>