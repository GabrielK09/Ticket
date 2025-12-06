<template>
    <q-dialog v-model="confirm" persistent>
        <q-card>
            <q-card-section class="flex flex-col w-80">
                <q-avatar 
                    class="ml-auto mr-auto mb-4"
                    icon="account_circle" 
                    color="primary" 
                    text-color="white" 
                />

                <span class="q-ml-sm text-center">Dados do usuário</span>

                <q-form
                    @submit="updateUser"                    
                    class="q-gutter-md"
                >
                    <div class="p-4">
                        <q-input 
                            v-model="userData.name" 
                            type="text" 
                            label="" 
                            stack-label
                            :error="!!formErrors.name"
                            :error-message="formErrors.name"
                            
                        >
                            <template v-slot:label>
                                <span>Nome</span>
                            </template>
                        </q-input>
                        
                        <q-input 
                            v-model="userData.email" 
                            type="text" 
                            label="" 
                            stack-label
                            :error="!!formErrors.email"
                            :error-message="formErrors.email"
                        >
                            <template v-slot:label>
                                <span>E-mail </span>
                            </template>
                        </q-input>

                    </div>                   

                    <div class="flex justify-center">                    
                        <q-card-actions>
                            <q-btn 
                                flat 
                                no-caps 
                                label="Alterar" 
                                type="submit" 
                                color="primary"
                            />
                            
                            <q-btn 
                                flat 
                                no-caps
                                label="Fechar" 
                                color="primary" 
                                v-close-popup 
                            />
                        </q-card-actions>
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { getUserDataService, updateUserService } from 'src/services/user/userService';
    import { onMounted, ref } from 'vue';
    import * as Yup from 'yup';
    
    let confirm = ref<boolean>(true);
    const userData = ref<userContract>({
        id: LocalStorage.getItem('user_id'),
        email: '',
        name: ''

    });

    const $q = useQuasar();
    const formErrors = ref<Record<string, string>>({});

    const userSchema = Yup.object({
        name: Yup.string().required('O nome é necessário!'),
        email: Yup.string()
                    .required('O e-mail é necessáro!')
                    .email('Digite um e-mail válido!')

    });

    const emits = defineEmits([
        'updateView'
    ]);

    const props = defineProps<{
        userId: string
    }>();

    const getUserData = async() => {
        const res = await getUserDataService(props.userId);

        userData.value = res.data.data;
        
    };

    const updateUser = async() => {
        try {
            await userSchema.validate(userData.value, { abortEarly: false });

            const res = await updateUserService(userData.value);
  
            if(res.success)
            {
                LocalStorage.setItem('user', userData.value.name);

                $q.notify({
                    type: 'positive',
                    position: 'top',
                    message: res.message
                    
                });
                
                confirm.value = false;

                emits('updateView');

            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: res.message

                });
            };

        } catch (error) {
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

    onMounted(async () => {
        await getUserData();
    });
</script>