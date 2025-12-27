<template>    
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-40 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-700">{{ showMessage }}</h1>
            <q-spinner color="primary" size="40px" />      
            
            <div v-if="showCancelOperation">
                <q-btn 
                    icon="cancel"
                    label="Cancelar"
                    no-caps
                    color="red"
                    @click="emits('update:hiddenDialogByError', true)"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { computed } from 'vue';

    const messages = {
        'commission': 'Carregando comissões ...',
        'config-customer': 'Carregando configurações dos clientes ...',
        'config-technical': 'Carregando configurações dos técnicos ...',
        
    };

    const props = defineProps<{
        module: 'commission'|'config-customer'|'config-technical',
        showCancelOperation: boolean
    }>();

    const emits = defineEmits([
        'update:hiddenDialog',
        'update:hiddenDialogByError'
    ]);

    const showMessage = computed(() => messages[props.module]);
    const showCancelOperation = computed(() => props.showCancelOperation);


</script>