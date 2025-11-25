<template>
    <q-layout view="hHr LpR lFf">
        <q-btn 
            @click="drawerLeft = !drawerLeft" 
            flat 
            class="rounded" 
            icon="menu" 
        />

        <q-drawer
            v-model="drawerLeft"
            show-if-above
            :width="210"
            class="bg-[#03202e] text-white rounded-r-md dashboard"
        >
            <q-toolbar>
                <div class="flex flex-col gap-2" v-for="ticketRow in ticketRows">
                    {{ ticketRow.label }}
                </div>
                
            </q-toolbar>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout> 
</template>

<script setup lang="ts">
    import { ref } from 'vue';

    const drawerLeft = ref<boolean>(true);

    const ticketRows = ref<ticketRows[]>([
        { label: 'DashBoard', icon: 'dashBoard', name: 'dashBoard', path: '/dashBoard'},
        { label: 'Clientes', icon: 'customer', name: 'customer', path: '/customer'},
    ]);
</script>