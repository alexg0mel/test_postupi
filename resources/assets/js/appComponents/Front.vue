<template>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <template v-if="list_news.length>0 && !isnews">
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

                <template v-if="list_categs.length>0 && !isnews">
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
                <template v-if="isnews">
                    <div class="card-header"> <h2> {{ news.name_news }} </h2></div>
                    <div class="card-body" v-html="news.body_news"></div>
                    <div class="card-header">Комментарии</div>
                    <div class="card-body">
                        <template v-for="comment in list_comments">
                            <div class="comment list-group-item">
                                <p class="font-weight-bold"> {{ comment.author }} </p>
                                <p class="body_comment"> {{ comment.body_comment }} </p>
                            </div>
                        </template>
                    </div>
                    <div class="card-header">Написать комментарий</div>
                    <div class="col-md-11">
                        <form v-on:submit.prevent="onSubmit">
                            <div class="form-group">
                                <label for="author">Name</label>
                                <input v-model="dataform.author" type="text" class="form-control" id="author" aria-describedby="authorHelp" placeholder="Enter name" required>
                                <small id="authorHelp" class="form-text text-muted">Здесь надо ввести автора комментария.</small>
                            </div>
                            <div class="form-group">
                                <label for="comment">Комментарий</label>
                                <input v-model="dataform.body_comment" type="text" class="form-control" id="comment" aria-describedby="commentHelp" placeholder="Enter comment" required>
                                <small id="commentHelp" class="form-text text-muted">Понравилась новость?  Поделитесь своими впечатлениями</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                        <div v-show="success" class="text-success"> Ваш комментарий был получен.</div>

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
            isnews:false,
            slug:'',
            list_news: [{name_news:'',slug:'',body_news:'',countcomments:0},],
            list_categs: [{name_categ:'',slug:'',countcomments:0},],
            news: {name_news:'',body_news:''},
            list_comments:[{author:'', body_comment:''}],
            dataform:{author:'',body_comment:''},
            success:false
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
            loadCurrentNews: function () {
                axios.get('/api/get-curr-news/'+this.curr_id).then((response) => {
                    if (response.data) {
                        this.news = response.data
                    }
                })
            },
            loadComments: function () {
                axios.get('/api/get-comments/'+this.curr_id).then((response) => {
                    if (response.data) {
                        this.list_comments = response.data
                    }
                })
            },
            getPath:function (itemslug) {
                return"/"+this.slug+"/"+itemslug;
            },
            onSubmit:function () {
                axios.post('/api/comment/'+this.curr_id,this.dataform).then((response) => {
                    if (response.data) {
                        this.success = true;
                        setTimeout(()=>{
                            this.success=false
                        }, 2000);
                    }
                })
            }
        },

        mounted: function () {
            this.curr_id = window.currid;
            this.slug = window.slug;
            this.isnews = window.isnews==='true';
            if (this.isnews) {
                this.loadCurrentNews();
                this.loadComments();
            } else {
                this.loadNews();
                this.loadCategories();
            }
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