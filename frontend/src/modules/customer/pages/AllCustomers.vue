<template>
    <q-page padding>
        <section class="text-xl">
            <div
                class="m-2"
            >
                <div class="flex justify-between">
                    <h2 class="text-gray-600 m-2">Clientes</h2>

                    <div class="mt-auto mb-auto">
                        <q-btn 
                            no-caps 
                            class="bg-sky-500 text-white" 
                            label="Cadastrar novo cliente"
                            :to="`/${LocalStorage.getItem('companie_name')}/register/customer`"
                        />
                    </div>
                </div>

                <div class="">
                    <q-table
                        borded
                        :rows="customers"
                        :columns="columns"
                        row-key="name"
                        class="rounded-xl"
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
                                    <span class="text-xs">Buscar por um cliente ...</span>
                                </template>
                            </q-input>
                        </template>

                        <template v-slot:body="props">
                            <q-tr
                                :props="props"
                            >
                                <q-td
                                    v-for="(col, i) in props.cols"
                                >   
                                    <template>
                                        <div 
                                            class="text-center"
                                            :class="{
                                                'text-gray-400': !props.row.active
                                            }"
                                        >
                                            {{ col.value }}

                                        </div>
                                    </template>

                                    <template v-if="col.name === 'actions'">
                                        <div class="text-center">
                                        </div>
                                    </template>
                                </q-td>
                            </q-tr>
                        </template>

                        <template v-slot:no-data>
                            <div class="ml-auto mr-auto">
                                <q-icon name="warning" size="30px"/>
                                <span class="mt-auto mb-auto ml-2 text-xs">Sem clientes cadastrados</span>

                            </div>
                        </template>
                    </q-table>
                </div>
            </div>
        </section>
    </q-page>
</template>

<script setup lang="ts">
    import { QTableColumn, LocalStorage } from 'quasar';
    import { ref } from 'vue';

    let searchInput = ref<string>('');

    const customers = [];

    const columns: QTableColumn[] = [

    ];
</script>