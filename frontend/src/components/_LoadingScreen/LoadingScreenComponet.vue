<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-40 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-700">{{ showMessage }}</h1>
            <q-spinner color="primary" size="40px" />      
        </div>
    </div>
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';

    const showMessage = ref<string>('');

    const messages = {
        'commission': 'Carregando comissões ...',
        'config-customer': 'Carregand configurações do clientes ...',
        'config-technical': 'Carregand configurações do clientes ...',
        
    };

    const props = defineProps<{
        module: 'commission'|'config-customer'|'config-technical'
    }>();

    onMounted(() => {
        showMessage.value = messages[props.module];
        
    });

</script>