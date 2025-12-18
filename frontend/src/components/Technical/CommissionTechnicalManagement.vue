<template>
    <q-dialog v-model="internalDialog" persistent>
        <q-card>
            <q-card-section>
                <span
                    class="q-ml-sm"
                >
                    Cadastro de comissões do funcionário: <span class="font-bold">{{ props.technicalId }}-{{ props.technicalName }}</span>
                </span>

                <div class="flex m-2">
                    <q-input 
                        v-model="text" 
                        stack-label
                        type="text"
                        outlined
                        label="Valor" 
                    />
                    
                    <div class="ml-2 flex flex-col">
                        <span>Tipo de comissão</span>

                        <q-btn 
                            color="primary" 
                            no-capas
                            label="R$"
                            class="mb-1"
                            
                        />

                        <q-btn 
                            color="primary" 
                            no-capas
                            label="%"
                            flat
                        />
                    </div>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn 
                    title="Sair"
                    icon="close" 
                    color="red" 
                    @click="close" 
                />

                <q-btn 
                    title="Salvar"
                    icon="save" 
                    no-caps
                    color="primary"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>

</template>

<script setup lang="ts">
    import { ref, watch } from 'vue';

    const props = defineProps<{
        showDialog: boolean,
        technicalName: string,
        technicalId: string,
    }>();

    const emits = defineEmits([
        'update:showDialog'
    ]);

    const commissionType = ref<'%'|'R$'>('R$');

    const internalDialog = ref(props.showDialog);

    watch(() => props.showDialog, val => {
        internalDialog.value = val;
    });

    const close = () => {
        emits('update:showDialog', false);
    };
</script>