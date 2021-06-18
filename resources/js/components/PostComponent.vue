<template>
    <div class="card post-card m-2 p-2">
        <img class="card-img-top img-post" :src="post.image.url" :alt="post.title">
        <div class="card-body">
            <span class="text-secondary pb-4">{{ getPostDate(post.updated_at) }}</span>
            <h4 class="card-title">{{ post.title }}</h4>
            <p class="card-text">{{ post.extract }}</p>
            
        </div>
        <div class="card-footer">
            <a class="btn btn-primary" @click="openModal">Mas información</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post'],
        methods: {
            openModal(){
                this.$emit('open-modal')
            },
            getPostDate(date){
                const newDate = new Date(date);
                return `${newDate.getDate()}/${newDate.getMonth()}/${newDate.getFullYear()}`;
            }
        }
    }
</script>
<style scoped>
    .post-card {
        max-width: 30rem;
    }
    .card-footer {
        background-color: #fff !important;
        border-top: 0;
    }
    .card-body {
         padding-top: 5px !important;
    }
    .card-title {
        margin-top: 10px;
    }
    .img-post {
        height: 20rem;
        object-fit: cover;
        object-position: center;
    }
</style>