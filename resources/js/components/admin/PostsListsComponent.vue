<template>
    <div>
        <div>
            <a @click="openCreateModal()" class="btn btn-primary btn-lg m-4">Crear nuevo post</a>
        </div>
        
        <div class="modal fade" :class="{showModal: showModal}">
            <div class="modal-dialog modal-xl modal-dialog-centered">    

                <form-create-component v-if="formCreateModal" @close-modal="closeModal()"></form-create-component>
                <form-edit-component v-if="formEditModal" @close-modal="closeModal()" :post="post"></form-edit-component>

            </div>
        </div>

        <div class="card">
            <div class="card-header font-weight-bold text-center">
                Mis posts
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Titulo</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Fecha</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="post in posts.data" :key="post.id">
                            <td>
                                <img :src="post.image.url" :alt="post.title" class="img-thumbnail">
                            </td>
                            <td class="td-post">{{ post.title }}</td>
                            <td class="td-post">{{ post.extract }}</td>
                            <td class="td-post">{{ status(post.status) }}</td>
                            <td class="td-post">{{ getPostDate(post.updated_at) }}</td>
                            <td width="10px" class="td-post">
                                <a @click="openEditModal(post)" class="btn btn-success btn-sm">Editar</a>
                            </td>
                            <td width="10px" class="td-post">
                                <a @click="deletePost(post.id)" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination class="paginate" :data="posts" @pagination-change-page="list"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination';
    import formCreateComponent from './FormCreateComponent.vue';
    import formEditComponent from './FormEditComponent.vue';

    export default {   
        components: {
            formCreateComponent,
            formEditComponent,
            pagination
        },
        mounted() {
            this.list()
        },
        data(){
            return {
                post: {
                    id: '',
                    title: '',
                    content: '',
                    status: 1,
                    image: null,
                    user_id: document.querySelector("meta[name='user_id']").getAttribute('content'),
                },
                posts: {},                
                formCreateModal: false,
                formEditModal: false,
                showModal: false,
                colorStatus: ''
            }
        },
        methods: {
            async list(page = 1){
                try {
                    const res = await axios.get(`/api/myPosts/${this.post.user_id}?page=${page}`)
                    this.posts = res.data
                } catch (error) {
                    console.log(error.message);
                }
            },
            async deletePost(id){
                try {
                    const swal = await this.$swal({
                        title: 'Estas seguro?',
                        text: "Eliminaras este post permanentemente",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, estoy seguro',
                        cancelButtonText: 'Cancelar'
                    })

                    if(swal.isConfirmed){
                        await axios.delete(`/api/posts/${id}`);

                        this.$swal({
                            icon: 'success',
                            title: 'El post se eliminó exitosamente!'
                        })

                        this.list();
                    }
                } catch (error) {
                    console.log(error.message);
                }
            },
            openCreateModal(){
                this.showModal = true;
                this.formEditModal = false;
                this.formCreateModal = true;
            },
            openEditModal(data={}){
                this.post = data;
                this.showModal = true;
                this.formCreateModal = false;
                this.formEditModal = true;
            },
            closeModal(){
                this.showModal = false;
                this.formCreateModal = false;
                this.formEditModal = false;
                this.list()
            },
            status(num){
                if (num == 1) {
                    return 'Borrador'
                } else if(num == 2) {
                    return 'Publicado'
                } else {
                    return 'Inactivo'
                }
            },
            getPostDate(date){
                const newDate = new Date(date);
                return `${newDate.getDate()}/${newDate.getMonth()}/${newDate.getFullYear()}`;
            }
        }
    }
</script>

<style scoped>
    .paginate {
        margin-top: 2rem;
    }    
    .img-thumbnail {
        width: 5rem;
    }
    .td-post {
        padding-top: 30px;
    }
    .showModal {
        display: list-item;
        opacity: 1;
        background: rgb(71, 65, 65);
    }
</style>