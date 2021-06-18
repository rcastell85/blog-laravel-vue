<template>

    <div class="modal fade">
        <div class="modal-dialog modal-xl modal-dialog-centered">    
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title-content">
                        <h3 class="modal-title text-center"><strong class="text-secondary">{{ post.title }}</strong></h3>
                    </div>
                    
                    <button @click="closeModal()" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body justify-content-center">
                    <div class="date-content">
                        <span class="text-secondary date">{{ getPostDate(post.updated_at) }}</span>
                    </div>
                    
                    <div class="img-container">
                        <img :src="post.imageUrl" :alt="post.title" class="img-modal">
                    </div>
                    <div class="content-container">
                        <p class="content-post text-secondary">
                            {{ post.content }}
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button @click="closeModal()" type="button" class="btn btn-danger btn-close" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
    export default {
        props: ['post'],
        methods: {
            closeModal(){
                this.$emit('close-modal')
            },
            getPostDate(date){
                const newDate = new Date(date);
                return `${newDate.getDate()}/${newDate.getMonth()}/${newDate.getFullYear()}`;
            }
        }
    }
</script>
<style scoped>
    .modal {
        overflow: scroll;
    }
    .title-content {
        width: 100%;;
    }
    .img-container {
        width: 100%;
        margin: 10px 0;
        text-align: center;
    }
    .img-modal {
        width: 60rem;
        height: 20rem;
        object-fit: cover;
        object-position: center;
        border-radius: 5px;
    }
    .content-container {
        width: 100%;
        margin: 3rem 0;
        text-align: center;
    }
    .content-post {
        padding: 0 6rem;
    }
    .btn-close {
        margin-right: 5 rem;
    }
    .date-content {
        display: flex;
        justify-content: flex-end;
    }
    .date {
        padding-right: 5rem;
    }
</style>
