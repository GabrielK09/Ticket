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
            <span class="flex justify-center mt-4 text-sm">Empresa: {{ companyName }}</span> 

            <q-toolbar>
                <q-list padding class="p-2">
                    <q-item 
                        v-for="row in ticketRows"
                        v-ripple
                        clickable
                        :key="row.name"
                        :to="`/${companyName}/admin/${row.path}`"
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

            <div class="fixed bottom-0 flex flex-center mt-4">
                <q-btn 
                    class=" mb-4" 
                    icon="store" 
                    flat 
                    no-caps
                    label="Trocar de empresa"
                    @click="changeCompanyDialog"
                />
                
                <q-btn 
                    class="mb-4" 
                    icon="logout" 
                    flat 
                    no-caps
                    label="Sair"
                    @click="logoutDialog"
                />
            </div>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout> 
    
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { LocalStorage, useQuasar } from 'quasar';
    import { logoutService } from 'src/services/auth/authService';

    const $q = useQuasar();
    const route = useRoute();
    const router = useRouter();
    const drawerLeft = ref<boolean>(true);
    const companyName = LocalStorage.getItem('companie_name');
        
    const ticketRows = ref<ticketRows[]>([
        { label: 'DashBoard', icon: 'dashboard', name: 'dashboard', path: ''},
        { label: 'Clientes', icon: 'group', name: 'customers', path: 'customers'},
        { label: 'Tickets', icon: 'confirmation_number', name: 'ticket', path: 'ticket'},

    ]);

    const changeCompanyDialog = () => {
        $q.dialog({
            message: 'Deseja realmente trocar de empresa?',

            cancel: {
                label: 'Não',
                color: 'red',
                push: true
            },

            ok: {
                label: 'Sim',
                color: 'green',
                push: true
            }
        }).onCancel(() => {
            return;

        }).onOk(() => {
            changeCompany();

        });
    };

    const changeCompany = () => {
        LocalStorage.remove('companie_id');
        LocalStorage.remove('companie_name');  
        
        router.replace({
            path: '/owners'
            
        });
    };

    const logoutDialog = () => {
        $q.dialog({
            message: 'Deseja realmente sair?',
            cancel: {
                label: 'Não',
                color: 'red',
                push: true
            },

            ok: {
                label: 'Sim',
                color: 'green',
                push: true
            }
        }).onCancel(() => {
            return;

        }).onOk(() => {
            logout();

        });
    };

    const logout = async() => {
        const res = await logoutService();

        if(res.success)
        {
            $q.notify({
                type: 'positive',
                message: res.message,
                position: 'top'
            });

            LocalStorage.remove('auth_token');
            
            LocalStorage.remove('user_id');
            LocalStorage.remove('user');

            router.push({
                path: '/login'
            })
        } else {
            $q.notify({
                type: 'negative',
                message: res.message,
                position: 'top'
            });
        };
    };

    onMounted(() => {
        if(!LocalStorage.getItem('companie_id') && !LocalStorage.getItem('companie_name')) {
            router.replace({
                path: '/owners'

            });
        };
    });

</script>

<style lang="scss">
    .my-link {
        color: #fff;
        background: #07425f;
    }

    .fixed-logout-button {
        display: flex;
    }

    @media (max-width: 1100px) {
        .fixed-logout-button {
            position: fixed;
            bottom: 0;
            margin: 0 0 2rem 0;
            background-color: aqua;
        }   
    }

    @media (min-width: 1100px) {
        .fixed-logout-button {
            background-color: aqua;
        }
    }
</style>