<template>

    <div class="container">
        <div>
            <post-modal-component 
                :class="{showModal: showModal}"
                @close-modal="closeModal()"
                :post="postToShow"
            >
            </post-modal-component>

            <div class="row">
                <div class="col-md-6" v-for="post in posts.data" :key="post.id">
                    <post-component :post="post" @open-modal="openModal(post)"></post-component>
                </div>
            </div>
            
            <pagination class="paginate" :data="posts" @pagination-change-page="list"></pagination>
        </div>
        <div>
            Bienvenido a nuestro blog!
        </div>
    </div>

    
</template>

<script>
    import postComponent from './PostComponent.vue';
    import postModalComponent from './PostModalComponent.vue';

    export default {
        components: {
            postComponent,
            postModalComponent
        },
        mounted() {
            this.list()
        },
        data(){
            return {
                posts: {},
                postToShow: {
                    title: '',
                    content: '',
                    imageUrl: '',
                    updated_at: ''
                },
                showModal: false
            }
        },
        methods: {
            async list(page = 1){
                try {
                    const res = await axios.get('/api/posts?page=' + page)
                    this.posts = res.data
                } catch (error) {
                    console.log(error.message);
                }
                
            },
            openModal(post = {}){
                this.postToShow.title = post.title;
                this.postToShow.content = post.content;
                this.postToShow.imageUrl = post.image.url;
                this.postToShow.updated_at = post.updated_at;
                this.showModal = true;
            },
            closeModal(){
                this.postToShow = {
                    title: '',
                    content: '',
                    imageUrl: '',
                    updated_at: ''
                },
                this.showModal = false;
            }
        }
    }
</script>
<style scoped>
    .paginate {
        margin-top: 2rem;
    }
    .showModal {
        display: list-item;
        opacity: 1;
        background: rgb(71, 65, 65);
    }
</style>