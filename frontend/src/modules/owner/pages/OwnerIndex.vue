<template>  
    <div class="flex">
        {{ LocalStorage.getItem('user') }}
        
        <h2>Todas as suas empresas</h2>

        <div class="flex flex-row">
            <div class="">
                <router-link to="/register/owner">
                    <div class="flex justify-center mt-8">
                        <svg   
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor" 
                            class="size-12"

                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                                                    
                    </div>

                    <div class="text-h6 text-center mt-5">Adicionar uma nova empresa</div>
                </router-link>
            </div>

            <q-card v-for="companie in allCompanies" class="my-card">
                <q-card-section>
                    {{ companie }}

                    <q-btn 
                        color="primary" 
                        label="Entrar" 
                        no-caps
                        :to="`${companie.company_name}/admin`"
                    />
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { getAllCompanies } from '../services/ownerServices';
    import { onMounted, ref} from 'vue';

    const $q = useQuasar();
    const allCompanies = ref<ownerContract[]>([]);

    const index = async () => {
        const res = await getAllCompanies(LocalStorage.getItem('user_id'));

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

    onMounted(async () => {
        await index();
    });
</script>