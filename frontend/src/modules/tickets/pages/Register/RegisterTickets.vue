<template>
    
    <section class="text-2xl">
        <div
            class="m-2"
        >
            <h2 class="text-gray-600 register-title m-2">Cadastrar um(a) novo(a) cliente</h2>

            <div class="ml-2 text-xs">
                <div 
                    @click="router.replace({ path: `/${LocalStorage.getItem('companie_name')}/admin/ticket` })"
                    class="flex mb-auto mt-auto cursor-pointer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 back-row">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>      
                    <span class="back-ticket-label">
                        Voltar para listagem
                    </span>
                </div>
            </div>

            <div>
                <q-form
                    @submit="submitTicket"
                    class="q-gutter-md mt-4 form"
                >
                    <div class="p-4 inputs">
                        <q-input 
                            label="" 
                            v-model="ticket.title" 
                            stack-label
                            outlined
                            type="text"
                            dense
                            class="mb-4"
                            :error="!!formErrors.title"
                            :error-message="formErrors.title"
                        >
                            <template v-slot:label>
                                <div class="text-sm">
                                    Título <span class="text-red-500">*</span>
                                </div>
                            </template>
                        </q-input>

                        <q-input 
                            label="" 
                            v-model="ticket.description" 
                            stack-label
                            outlined
                            type="textarea"
                            dense
                            class="mb-4"
                            :error="!!formErrors.description"
                            :error-message="formErrors.description"
                        >
                            <template v-slot:label>
                                <div class="text-sm">
                                    Descrição <span class="text-red-500">*</span>
                                </div>
                            </template>
                        </q-input>

                        <q-select
                            label="" 
                            :options="prioritys"
                            v-model="ticket.priority"
                            stack-label
                            outlined
                            type="text"
                            dense
                            class="mb-4"
                            :error="!!formErrors.priority"
                            :error-message="formErrors.priority"
                        >
                            <template v-slot:label>
                                <div class="text-sm">
                                    Prioridade <span class="text-red-500">*</span>
                                </div>
                            </template>
                        </q-select>

                        <q-input 
                            label="" 
                            v-model="ticket.location" 
                            stack-label
                            outlined
                            type="text"
                            dense
                            class="mb-4"
                            :error="!!formErrors.location"
                            :error-message="formErrors.location"
                        >
                            <template v-slot:label>
                                <div class="text-sm">
                                    Local <span class="text-red-500">*</span>
                                </div>
                            </template>
                        </q-input>

                        <div class="p-2 border rounded-md">
                            <span class="text-sm ml-1">
                                Valores
                            </span>

                            <q-input 
                                label="" 
                                v-model="ticket.location_value" 
                                stack-label
                                outlined
                                type="text"
                                dense
                                class="mb-4 mt-4"
                            >
                                <template v-slot:label>
                                    <div class="text-sm">
                                        Frete <span class="text-red-500">*</span>
                                    </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="flex flex-center mt-8">
                            <q-btn 
                                color="primary" 
                                type="submit" 
                                label="Cadastrar cliente"
                                no-caps
                            />
                        </div>
                    </div>
                </q-form>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import * as Yup from 'yup';
    import { createTicket } from '../../ticketService';

    const ticketSchema = Yup.object({
        title: Yup.string().required('O título do ticket é necessário'),
        description: Yup.string().required('A descrição do ticket é necessário'),
        priority: Yup.string().required('A prioridade do ticket é necessário'),
        location: Yup.string().required('O local do ticket é necessário'),
        increase_tpye: Yup.string().required('O tipo de acréscimo do ticket é necessário'),
        discount_type: Yup.string().required('O tipo do desconto  do ticket é necessário'),

    });

    const prioritys: string[] = [
        'Baixa',
        'Alta'
    ];

    const formErrors = ref<Record<string, string>>({});

    const router = useRouter();
    const $q = useQuasar();

    const ticket = ref<ticketContract>({
        owner_id: LocalStorage.getItem('owner_id'),
        customer_id: '',
        title: '',
        description: '',
        priority: '',
        location: '',
        location_value: 0,
        increase_value: 0,
        increase_tpye: '',
        discount_value: 0,
        discount_type: '',
        base_value: 0,           

        date_paid: '',
        status: '',
  
        // Para alterações e finalização
        ticket_id: '',
        ticket_code: '',
        operation: '',
        amount_paid: 0,
        pay_ment_form_id: ''
    });

    const submitTicket = async () => {
        try {
            await ticketSchema.validate(ticket.value, { abortEarly: false });
            
            const res = await createTicket(ticket.value);

            if(res.success)
            {
                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.data.message
                    
                });
                
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message

                });
            };
            
        } catch (error: any) {
            if(error.inner)
            {
                formErrors.value = {};

                error.inner.forEach((err: any) => {
                    formErrors.value[err.path] = err.message;

                    $q.notify({
                        type: 'negative',
                        position: 'top',
                        message: err.message

                    });
                });  

            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: error.response?.data?.message

                });
            };
        };
    };
</script>

<style lang="scss">
    @media (max-width: 1336px) {
        .register-title {
            text-align: center;
        }

        .back-ticket-label {
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
    }
</style>