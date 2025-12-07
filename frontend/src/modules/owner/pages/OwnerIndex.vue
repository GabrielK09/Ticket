<template>  
    <header class="bg-[#07425f] text-white flex justify-between text-base">
        <h2 class="ml-4">Todas as suas empresas</h2>

        <div class="mt-auto mb-auto">
            <span class="mr-4 relative">
                {{ LocalStorage.getItem('user') }}

                <q-btn 
                    @click.stop="showOptions = !showOptions"
                    icon="account_circle" 
                    flat 
                    class="ml-2"
                />

                <q-list 
                    v-if="showOptions" 
                    @click.stop 
                    class="z-10 absolute right-2 bg-[#07425f] rounded-md text-xs"
                >
                    <q-item
                        clickable  
                        class="flex flex-col"
                    >
                        <q-item-section>
                            <q-btn 
                                @click="showUserData = !showUserData"
                                size="10px"
                                flat 
                                no-caps
                                icon="contact_page"
                                label="Meus dados"                                
                            />
                        </q-item-section>
                    </q-item>

                    <q-item
                        clickable  
                        class="flex flex-col"
                    >
                        <q-item-section>
                            <q-btn 
                                @click.stop="logoutDialog"
                                size="10px"
                                flat 
                                no-caps
                                icon="logout"
                                label="Sair"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>

            </span>
        </div>
    </header>

    <div class="flex flex-row justify-center mt-14">
        <div class="mr-10">
            <router-link to="/register/owner">
                <div class="flex justify-center mt-8">
                    <svg   
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke-width="1.5" 
                        stroke="currentColor" 
                        class="size-12 bg-blue-400 text-white rounded-md"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>       
                </div>

                <div class="text-h6 text-center mt-5">Adicionar uma nova empresa</div>
            </router-link>
        </div>

        <q-card v-for="companie in allCompanies" class="mr-6 companie-cards">
            <q-card-section class="flex flex-col companie-card">
                <div class="text-center">
                    <h2>{{ companie.company_name }}</h2>
                    <h3
                        class="btn cursor-pointer"
                        @click="tryClipBoard"
                        :data-clipboard-text="formatCPFCNPJ(companie.cnpj_cpf)"
                    >
                        {{ formatCPFCNPJ(companie.cnpj_cpf) }}
                    </h3>

                </div>

                <q-btn 
                    color="primary" 
                    label="Entrar" 
                    no-caps
                    @click="joinCompanie(companie.company_name, companie.id)"
                />
            </q-card-section>
        </q-card>
    </div>

    <UserData
        v-if="showUserData"
        :userId="userId"
        @update-view="updateView"
    />
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { getAllCompanies } from '../services/ownerServices';
    import { logoutService } from 'src/services/auth/authService';
    import { onMounted, ref} from 'vue';
    import formatCPFCNPJ from 'src/util/formatCPFCNPJ';
    import { useRouter } from 'vue-router';
    import UserData from 'src/components/User/UserData.vue';
    import { clipBoardFunction } from 'src/util/clipBoard/clipBoard';

    const $q = useQuasar();
    const router = useRouter();
    const allCompanies = ref<ownerContract[]>([]);
    const userId = String(LocalStorage.getItem('user_id'));

    let showOptions = ref<boolean>(false);
    let showUserData = ref<boolean>(false);

    const index = async () => {
        const res = await getAllCompanies(userId);

        if(res.success)
        {
            allCompanies.value = res.data.data;
            
        } else {
            $q.notify({ 
                type: 'negative',
                message: res.message,
                position: 'top'
                
            });
        };
    };

    const joinCompanie = (companieName: string, companieId: string) => {
        LocalStorage.setItem('companie_id', companieId);
        LocalStorage.setItem('companie_name', companieName);

        router.replace({ 
            path: `${companieName}/admin`
        });
    };

    const updateView = () => {
        location.reload();

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
            showOptions.value = false;
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
    
    const tryClipBoard = async() => {
        console.log('Init tryClipBoard');
        
        try {
            if(await clipBoardFunction())
            {
                $q.notify({
                    type: 'positive',
                    message: 'Conteúdo copiado para a área de transferência!',
                    position: 'top'

                });
            };
        } catch (error) {
            console.error('Erro:', error);
              
        };
    };

    onMounted(async () => {
        await index();
        showOptions.value = false;
    });
</script>

<style lang="scss">

    .companie-cards:hover {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
        transform: translateY(-10px);
    }

    @media (min-width: 1100px) {
        .companie-card {
            display: flex;
            justify-content: center;
            height: 240px;
            width:  240px;
        }
    }
</style>