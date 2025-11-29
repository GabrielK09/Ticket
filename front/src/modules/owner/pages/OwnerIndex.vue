<template>  
    <div class="flex">
        {{ LocalStorage.getItem('user') }}
        
        Home Page        
    </div>
</template>

<script setup lang="ts">
    import { LocalStorage } from 'quasar';
    import { api } from 'src/boot/axios';
    import { onMounted } from 'vue';

    const index = async () => {
        const allOwners = await api.get(`/owner/all/${LocalStorage.getItem('user_id')}`);

        console.log(allOwners.data);
        
    };

    onMounted(async () => {
        await index();
    });
</script>