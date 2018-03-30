<template>
    <section id="articles">
        <h2 class="mt-2">Articles <button class="btn btn-primary" type="submit" @click.prevent="addArticle()">Add</button></h2>

        <alert />

        <pagination
            :pagination="pagination"
            v-on:prev-page="fetchArticles(pagination.prev_page_url)"
            v-on:next-page="fetchArticles(pagination.next_page_url)"
        />
        <div id="article=list">
            <div class="card card-body mb-2" v-for="article in articles" :key="article.id">
                <h3><a :href="'api/articles/' + article.id" :title="'Show ' + article.title">{{ article.title }}</a></h3>
                <p>{{ article.body }}</p>
                <div class="controls">
                    <button @click="editArticle(article)" class="btn btn-info mr-2">
                        Edit
                    </button>
                    <button @click="deleteArticle(article.id)" class="btn btn-danger">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <pagination
            :pagination="pagination"
            v-on:prev-page="fetchArticles(pagination.prev_page_url)"
            v-on:next-page="fetchArticles(pagination.next_page_url)"
        ></pagination>

        <div class="modal show fade d-block" v-if="modal.show">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="saveArticle()">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ modal.title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="clearStage()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Title" v-model="article.title">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" placeholder="Body" v-model="article.body"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">{{ modal.saveBtnText }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="clearStage()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="modal.show"></div>

    </section>
</template>

<script>
export default {

    data() {
        return {
            articles: [],
            article: {
                id: '',
                title: '',
                body: ''
            },            
            pagination: {},
            edit: false,
            modal: {
                show: false,
                title: '',
                saveBtnText: ''
            }
        }
    },

    created() {
        this.fetchArticles();
    },

    methods: {
        fetchArticles(page_url) {
            let vm = this;
            page_url = page_url || 'api/articles';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.articles = res.data;
                vm.makePagination(res.meta, res.links);
            })
            .catch(error => console.log(error));
        },

        makePagination(meta, links) {
            let pagination = {
                path: meta.path,
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        },

        deleteArticle(id) {
            if (confirm('Are you sure?')) {
                fetch(`api/articles/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    let current_link = this.pagination.path + '?page=' + this.pagination.current_page;
                    this.fetchArticles(current_link);
                    this.$alert.show('Article has been deleted.', 'success', 'notice');
                })
                .catch(error => console.log(error));
            }
        },

        saveArticle() {
            
            if (! this.edit) {
                // Add
                fetch('api/articles', {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'aplication/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.clearStage();
                    let current_link = this.pagination.path + '?page=' + this.pagination.current_page;
                    this.fetchArticles(current_link);
                    this.$alert.show('Article has been added.', 'success', 'notice');
                });
            } else {
                // Update
                fetch(`api/articles/${this.article.id}`, {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'aplication/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.clearStage();
                    let current_link = this.pagination.path + '?page=' + this.pagination.current_page;
                    this.fetchArticles(current_link);
                    this.$alert.show('Article has been updated.', 'success', 'notice');
                });
            }

        },

        addArticle() {
            this.clearStage();
            this.modal.show = true;
            this.modal.title = 'Add Article';
            this.modal.saveBtnText = 'Add';
        },

        editArticle(article) {
            this.edit = true;
            this.modal.show = true;
            this.modal.title = 'Update Article';
            this.modal.saveBtnText = 'Update';
            this.article = article;
        },

        clearStage() {
            this.edit = false;
            this.modal = {
                show: false,
                title: '',
                saveBtnText: ''
            };
            this.article = {};
        }
    }
}
</script>
