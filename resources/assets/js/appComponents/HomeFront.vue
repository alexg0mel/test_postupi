<template>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Категории</div>

                <div class="card-body">
                        <div class="row list-group">
                            <template v-for="categ in listCateg">
                                <div class="list-group-item">
                                    <a :href="categ.slug">{{ categ.name_categ }}</a>
                                    <span class="countnews"> Количество новостей: {{ categ.countnews }}</span>
                                </div>
                            </template>
                        </div>


                </div>
            </div>
        </div>
    </div>



</template>


<script>

    export default {
        data: function() {
          return {
            listCateg:{
                countnews:0,
                name_categ:'',
                slug:''
            },

          }
        },

        methods: {
            loadCategory: function () {
                axios.get('/api/get-root-categ').then((response) => {
                    if (response.data) {
                        this.listCateg = response.data
                    }
                })
            }
        },

        mounted: function () {
            this.loadCategory()
        },

    }
</script>

<style scoped>
    .countnews {
        float: right;
    }
</style>