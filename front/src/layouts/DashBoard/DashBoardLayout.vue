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
                <q-list padding class="p-2">
                    <q-item 
                        v-for="row in ticketRows"
                        v-ripple
                        clickable
                        :key="row.name"
                        :to="`/admin/${row.path}`"
                        :active="route.path === row.path"
                        class="rounded mt-3"
                        active-class="my-link"
                    >
                        <q-item-section avatar>
                            <q-icon :name="row.icon" />
                        </q-item-section>

                        <q-item-section>
                            {{ row.label }}
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-toolbar>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout> 
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { useRoute } from 'vue-router';

    const route = useRoute();
    const drawerLeft = ref<boolean>(true);

    const ticketRows = ref<ticketRows[]>([
        { label: 'DashBoard', icon: 'dashboard', name: 'dashboard', path: ''},
        { label: 'Clientes', icon: 'group', name: 'customers', path: 'customers'},
        { label: 'Tickets', icon: 'confirmation_number', name: 'ticket', path: 'ticket'},
    ]);
</script>

<style lang="scss">
    .my-link {
        color: #fff;
        background: #07425f;
    }
</style>