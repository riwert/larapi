<template>
    <div>
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: ! pagination.prev_page_url}]">
                    <a class="page-link" href="#" @click.prevent="$emit('prev-page')">&laquo;</a>
                </li>
                <li class="page-item">
                    <span class="page-link">{{ pagination.current_page }} / {{ pagination.last_page }}</span>
                </li>                
                <li class="page-item" v-bind:class="[{disabled: ! pagination.next_page_url}]">
                    <a class="page-link" href="#" @click.prevent="$emit('next-page')">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['pagination']
}
</script>
