<template>
    <q-page>
        <section class="text-2xl">
            <div
                class="m-2"
            >
                <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) cliente</h2>

                <div class="ml-2 text-xs">
                    <div 
                        @click="router.replace({ path: '/customers' })"
                        class="flex mb-auto mt-auto cursor-pointer"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 back-row">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>      
                        <span class="back-customer-label">
                            Voltar para listagem
                        </span>
                    </div>
                </div>

                <div>
                    <q-form
                        @submit="createAttendant"
                        class="q-gutter-md mt-4 form"
                    >
                        <div class="bg-gray-200 p-4 rounded-md grid grid-cols-4 gap-4">
                            <q-select 
                                v-model="attendant.confirmPassword" 
                                :options="customerTypes" 
                                label="Tipo de cadastro" 
                                outlined
                                stack-label
                                dense

                            />

                            <q-input 
                                label="" 
                                v-model="attendant.name" 
                                stack-label
                                outlined
                                type="text"
                                dense
                            >
                                <template v-slot:label>
                                    <div class="text-sm">
                                        Nome do cliente <span class="text-red-500">*</span>
                                    </div>
                                </template>
                            </q-input>
                        
                            <q-input 
                                v-model="attendant.email" 
                                type="text" 
                                label="E-mail *" 
                                stack-label
                                outlined
                                dense
                            >
                                <template v-slot:label>
                                    <div class="text-sm">
                                        Nome do cliente <span class="text-red-500">*</span>
                                    </div>
                                </template>
                            </q-input>
                        </div>
                    </q-form>
                </div>
            </div>
        </section>
    </q-page>
</template>

<script setup lang="ts">
    import { api } from 'src/boot/axios';
    import camelcaseKeys from 'camelcase-keys';
    import { LocalStorage, useQuasar } from 'quasar';
    import { onMounted, ref } from 'vue';
    import { useRouter } from 'vue-router';

    const customerTypes: string[] = [
        'Júridica',
        'Física'
    ];

    const router = useRouter();
    const $q = useQuasar();
    const ownerCode = LocalStorage.getItem("ownerCode") as number;
    
    const attendant = ref({
        ownerCode: ownerCode,
        name: '',
        email: '',
        confirmPassword: 'Júridica',
        password: ''
    });
    const createAttendant = async () => {
        
    };
</script>

<style lang="scss">
    @media (max-width: 1336px) {
        .register-title {
            text-align: center;
        }

        .back-customer-label {
            display: none;
        }

        .back-row {
            width: 1rem;
            height: 1rem;
        }
    }

    @media (min-width: 1336px) {
        .back-row {
            width: 0.75rem;
            height: 0.75rem;
        }

        .form {
            .inputs {
                padding: 15px;
                margin: 10px;
            }
        }
    }
</style>