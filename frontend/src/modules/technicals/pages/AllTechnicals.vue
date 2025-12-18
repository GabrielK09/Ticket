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
                            :to="`/${companyName}/admin/register/technicel`"
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
                            <q-tr 
                                :props="props"
                            >
                                <q-td
                                    class="overflow-hidden z-50"
                                    v-for="col in props.cols"
                                    :key="col.name"
                                    :props="props"
                                >
                                    <template v-if="col.name === 'actions'">
                                        <!--
                                        

                                       
                                        -->
                                        <q-btn 
                                            :class="{
                                                'bg-sky-500 text-white': isActive(props.row.active),
                                                'bg-gray-500 text-white': !isActive(props.row.active),
                                            }"

                                            icon="settings"
                                            size="10px"
                                            @click=""
                                            :disable="!isActive(props.row.active)"
                                        >                                        
                                            <q-menu>
                                                <q-list style="min-width: 100px;">
                                                    <q-item>
                                                        <q-item-section>
                                                            <q-btn 
                                                                :class="{
                                                                    'bg-sky-500 text-white': isActive(props.row.active),
                                                                    'bg-gray-500 text-white': !isActive(props.row.active),
                                                                }"

                                                                icon="edit_square" 
                                                                size="10px"
                                                                :to="`/${companyName}/admin/edit/technical/${props.row.technical_id}`"
                                                                :disable="!isActive(props.row.active)"
                                                            >
                                                                <template v-slot:default>
                                                                    <span class="edit-btn">Editar</span>
                                                                </template>
                                                            </q-btn>    
                                                        </q-item-section>
                                                    </q-item>

                                                    <q-separator />

                                                    <q-item>
                                                        <q-item-section>
                                                             <q-btn 
                                                                :class="{
                                                                    'bg-red-500 text-white': isActive(props.row.active),
                                                                    'bg-green-500 text-white': !isActive(props.row.active),
                                                                    'bg-gray-500 text-white': !isActive(props.row.active),
                                                                }"
                                                                :icon="isActive(props.row.active) ? 'delete' : 'add'" 
                                                                size="10px"
                                                                @click="showDialogDisableTechnical(props.row.technical_id, props.row.active)"
                                                            >
                                                                <template v-slot:default>
                                                                    <span class="delete-btn">Desativar</span>
                                                                </template>
                                                            </q-btn>    
                                                        </q-item-section>
                                                    </q-item>

                                                    <q-separator />

                                                    <q-item>
                                                        <q-item-section>
                                                            <q-btn 
                                                                :class="{
                                                                    'bg-green-400 text-white': isActive(props.row.active),
                                                                    'bg-green-500 text-white': !isActive(props.row.active),
                                                                    'bg-gray-500 text-white': !isActive(props.row.active),
                                                                }"
                                                                icon="attach_money" 
                                                                size="10px"
                                                                @click="commissionManagement(
                                                                    props.row.company_name,
                                                                    props.row.technical_id,

                                                                )"
                                                            >
                                                                <template v-slot:default>
                                                                    <span class="attach_money-btn">Comissão</span>
                                                                </template>
                                                            </q-btn>    
                                                        </q-item-section>
                                                    </q-item>
                                                </q-list>
                                            </q-menu>

                                        </q-btn>
                                        
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

    <Commission-technical-management
        v-if="showCommissionManagement"
        :show-dialog="showCommissionManagement"
        :technical-name="selectedTechnical"
        :technical-id="selectedTechnicalId"
        @update:show-dialog="showCommissionManagement = $event"
    />
</template>

<script setup lang="ts">
    import { QTableColumn, LocalStorage, useQuasar } from 'quasar';
    import { isActive } from 'src/util/isActive/isActive';
    import { formatCPFCNPJ } from 'src/util/formatCPFCNPJ';
    import { onMounted, ref } from 'vue';
    import { getAllTechnicalsService, disableOrActiveTechnicelService } from '../technicalsService';
    import CommissionTechnicalManagement from 'src/components/Technical/CommissionTechnicalManagement.vue';
 
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

    let showCommissionManagement = ref<boolean>(false);
    let selectedTechnical = ref<string>('');
    let selectedTechnicalId = ref<string>('');

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

    const commissionManagement = (name: string, technicalId: string): void => {
        showCommissionManagement.value = !showCommissionManagement.value;
        selectedTechnical.value = name;
        selectedTechnicalId.value = technicalId;
    };
    
    onMounted(() => {
        index();
    });
</script>   

<style lang="scss">
    .delete-btn {
        font-size: .55rem;
    }

    @media (max-width: 1100px) {    
        .delete-btn, 
        .edit-btn,
        .attach_money-btn {
            display: none;
        }
    }
    
</style>