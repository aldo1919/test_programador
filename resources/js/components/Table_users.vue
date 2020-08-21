<template>
    <v-container class="mt-10">
        <v-card>
            <v-card-title>
            Nutrition
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="users"
                    :items-per-page="30"
                    class="elevation-1"
                    :search="search"
                    hide-default-footer
                >
                <template v-slot:[`item.estado`]="{ item }" >
                    <v-switch @change="cambiar_estado(item)" :input-value="(item.estado==1) ? true : false " :label="(item.estado==1) ? 'Activo' : 'Inactivo' "></v-switch>
                </template>
            </v-data-table>
            <div class="text-center pt-2">
                <v-pagination :circle="circle_pagination" @input="cambiar_pagina" :value="page" class="mx-12" v-model="page" :length="pageCount"></v-pagination>
                <!-- <v-text-field
                    :value="itemsPerPage"
                    label="Items per page"
                    type="number"
                    min="-1"
                    max="15"
                    @input="itemsPerPage = parseInt($event, 10)"
                ></v-text-field> -->
            </div>
        </v-card>
    </v-container>
</template>
<script>
  export default {
    data () {
        return {
            page:1,
            pageCount: 43,
            itemsPerPage:'',
            circle_pagination:true,
            search:'',
            headers: [
                {
                text: 'Nombre',
                align: 'center',
                value: 'name',
                },
                { text: 'Email',align: 'center', value: 'email' },
                { text: 'Estado', align: 'center',value: 'estado' },
            ],
            users: [],
        }
    },mounted() {
        this.get_users();
    },
    methods: {
        cambiar_pagina(page){
            let me = this;
            me.get_users(page);
        },
        cambiar_estado(item){
            console.log(this);
            let me = this;
            let data = { 'id': item.id , 'estado' : item.estado};
            axios.post('change_state',data).then(function(response){
                let dato = me.users.findIndex(u => u.id == item.id);
                me.users[dato].estado=response.data;
            });
        },
        get_users(page=1){
            let me = this;
            axios.get('get_users?page='+page).then(function(response){
                me.users = response.data.data;   
                me.pageCount = response.data.last_page;
            });
        },
        getColor (calories) {
            if (calories > 400) return 'red'
            else if (calories > 200) return 'orange'
            else return 'green'
        },
    },
    }
</script>