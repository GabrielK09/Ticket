<template>
    <q-page padding>
        <section class="text-xl">
            <div
                class="m-2"
            >
                <div class="flex justify-between">
                    <h2 class="text-gray-600 m-2">Técnicos</h2>

                    <div class="mt-auto mb-auto">
                        <q-btn 
                            no-caps 
                            class="bg-sky-500 text-white" 
                            label="Cadastrar novo técnico"
                            :to="`/${companyName}/register/technicel`"
                        />
                    </div>
                </div>

                <div class="">
                    <q-table
                        borded
                        :rows="technicels"
                        :columns="columns"
                        row-key="name"
                        class="rounded-xl"
                        :filter="searchInput"
                    >
                        <template v-slot:top-right>
                            <q-input 
                                outlined
                                v-model="searchInput" 
                                type="text" 
                                label="" 
                            >
                                <template v-slot:append>
                                    <q-icon name="search" />
                                </template>

                                <template v-slot:label>
                                    <span class="text-xs">Buscar por um técnico(a) ...</span>
                                </template>
                            </q-input>
                        </template>

                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td
                                    v-for="col in props.cols"
                                    :key="col.name"
                                    :props="props"
                                >
                                    <template v-if="col.name === 'actions'">
                                        <q-btn 
                                            :class="{
                                                'bg-sky-500 text-white': props.row.technical_id !== 1 && isActive(props.row.active),
                                                'bg-gray-500 text-white': props.row.technical_id === 1 || !isActive(props.row.active),
                                            }"

                                            icon="edit" 
                                            size="10px"
                                            :to="`/${companyName}/edit/technical/${props.row.technical_id}`"
                                            :disable="props.row.technical_id === 1 || !isActive(props.row.active)"
                                        />

                                        <q-btn 
                                            :class="{
                                                'bg-red-500 text-white': props.row.technical_id !== 1 && isActive(props.row.active),
                                                'bg-green-500 text-white': props.row.technical_id !== 1 && !isActive(props.row.active),
                                                'bg-gray-500 text-white': props.row.technical_id === 1 || !isActive(props.row.active),
                                            }"
                                            class="ml-4"
                                            :icon="isActive(props.row.active) ? 'delete' : 'add'" 
                                            size="10px"
                                            @click="showDialogDisableTechnical(props.row.technical_id, props.row.active)"
                                        />
                                    </template>

                                    <template v-else>
                                        <span 
                                            :class="{
                                                'text-gray-500': !isActive(props.row.active)
                                            }"
                                        >
                                            {{ col.value }}

                                        </span>
                                    </template>
                                </q-td>
                            </q-tr>
                        </template>
                    
                        <template v-slot:no-data>
                            <div class="ml-auto mr-auto">
                                <q-icon name="warning" size="30px"/>
                                <span class="mt-auto mb-auto ml-2 text-xs">Sem técnicos cadastrados</span>

                            </div>
                        </template>
                    </q-table>
                </div>
            </div>
        </section>
    </q-page>
</template>

<script setup lang="ts">
    import { QTableColumn, LocalStorage, useQuasar } from 'quasar';
    import { isActive } from 'src/util/isActive/isActive';
    import { formatCPFCNPJ } from 'src/util/formatCPFCNPJ';
    import { onMounted, ref } from 'vue';
    import { getAllTechnicalsService, disableOrActiveTechnicelService } from '../technicalsService';
 
    const $q = useQuasar();
    const searchInput = ref('');
    const companyName = LocalStorage.getItem('companie_name_url');
    const ownerId: string = LocalStorage.getItem('owner_id');
    const allTechnicals = ref<technicalsContract[]>([]);
    const technicels = ref<technicalsContract[]>([]);

    const columns: QTableColumn[] = [
        {
            field: 'technical_id',
            label: 'ID',
            name: 'technical_id',
            align: 'center'
        },
        {
            field: 'company_name',
            label: 'Nome',
            name: 'company_name',
            align: 'center'
        },
        {
            field: 'cnpj_cpf',
            label: 'CNPJ/CPF',
            name: 'cnpj_cpf',
            format: formatCPFCNPJ,
            align: 'center'
        },
        {
            field: 'address',
            label: 'Endereço',
            name: 'address',
            align: 'center'
        },
        {
            field: 'actions',
            label: 'Ações',
            name: 'actions',
            align: 'center'
        }
    ];

    const index = async (): Promise<void> => {
        const res = await getAllTechnicalsService(ownerId);
        
        if(res.success)
        {
            technicels.value = res.data;
            allTechnicals.value = [...technicels.value];
        };
    };

    const showDialogDisableTechnical = (technicelId: string, currentStatus: number): void  => {
        $q.dialog({
            title: `Deseja realmente ${currentStatus === 1 ? 'desativar' : 'ativar'} esse técnico?`,
            ok: {
                label: 'Sim',
                color: 'green'

            },
            cancel: {
                label: 'Não',
                color: 'red'

            }
        }).onOk(() => {
            disableOrActiveTechnical(technicelId, currentStatus === 1 ? 'disable' : 'active');

        }).onCancel(() => {
            return;

        });
    };

    const disableOrActiveTechnical = async (technicelId: string, action: string): Promise<void> => {
        const res = await disableOrActiveTechnicelService(technicelId, ownerId, action);

        if(res.success)
        {
            $q.notify({
                type: 'positive',
                position: 'top',
                message: res.message,
            }); 

            index();

        } else {
            $q.notify({
                type: 'negative',
                position: 'top',
                message: res.message,

            });
        };
    };
    
    onMounted(() => {
        index();
    });
</script>   