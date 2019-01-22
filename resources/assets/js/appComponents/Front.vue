<template>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <template v-if="list_news.length>0">
                    <div class="card-header">Новости</div>

                    <div class="card-body">
                        <div class="tool-view">
                            <span> <i @click="listview=true" class="fa fa-list fa-2x"></i> </span>
                            <span> <i @click="listview=false" class="fa fa-table fa-2x"></i> </span>
                        </div>
                        <div :class="listview ? 'row list-group':'row'">
                            <template v-for="news in list_news">
                                <div :class=" list_news ? 'list-group-item':'col-md-4 col-sm-4 col-xs-12 list-group-item'">
                                    <div>
                                        <a :href="getPath(news.slug)">{{ news.name_news }}</a>
                                    </div>
                                    <div v-html="news.body_news"> </div>
                                    <span class="countcomments"> Количество комментариев: {{ news.countcomments }}</span>
                                </div>
                            </template>
                        </div>

                    </div>

                </template>

                <template v-if="list_categs.length>0">
                    <div class="card-header">Категории</div>

                    <div class="card-body">
                        <div class="row list-group">
                            <template v-for="categ in list_categs">
                                <div class="list-group-item">
                                    <a :href="getPath(categ.slug)">{{ categ.name_categ }}</a>
                                    <span class="countcomments"> Количество комментариев: {{ categ.countcomments }}</span>
                                </div>
                            </template>
                        </div>


                    </div>
                </template>


            </div>
        </div>
    </div>
</template>


<script>

    export default {
        data: function() {
          return {
            listview:true,
            curr_id:0,
            slug:'',
            list_news: [{name_news:'',slug:'',body_news:'',countcomments:0},],
            list_categs: [{name_categ:'',slug:'',countcomments:0},]
          }
        },

        methods: {
            loadCategories: function () {
                axios.get('/api/get-categs/'+this.curr_id).then((response) => {
                    if (response.data) {
                        this.list_categs = response.data
                    }
                })
            },
            loadNews: function () {
                axios.get('/api/get-news/'+this.curr_id).then((response) => {
                    if (response.data) {
                        this.list_news = response.data
                    }
                })
            },
            getPath:function (itemslug) {
                return"/"+this.slug+"/"+itemslug;
            }
        },

        mounted: function () {
            this.curr_id = window.currid;
            this.slug = window.slug;
            this.loadNews();
            this.loadCategories();
        },

    }
</script>

<style scoped>
    .tool-view{
        text-align: right;
    }

    .tool-view i{
        cursor: pointer;
    }

    .countcomments {
        float: right;
    }
</style>