<template>
    <transition mode="fade">
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
    </transition>
</template>

<script>
export default {
    props: ['modal']
}
</script>
