<template>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Editar post</h4>
            <button @click="closeModalWithReset()" type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="editPost(postToEdit.id)" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title"><strong>Titulo</strong></label>
                    <input v-model="postToEdit.title" type="text" name="title" :class="[errors && errors.title ? 'form-control border border-danger' : 'form-control']" placeholder="Titulo del post">
                    <span class="text-danger" v-if="errors && errors.title">{{ errors.title[0] }}</span>
                </div>
                <div class="form-group">
                    <label for="content"><strong>Contenido</strong></label>
                    <textarea v-model="postToEdit.content" :class="[errors && errors.content ? 'form-control border border-danger' : 'form-control']" name="content" cols="30" rows="10" placeholder="Contenido del post"></textarea>
                    <span class="text-danger" v-if="errors && errors.content">{{ errors.content[0] }}</span>
                </div>

                <div><strong>Status</strong></div>
                <div class="form-check form-check-inline">
                    <input v-model="postToEdit.status" class="form-check-input" type="radio" name="exampleRadios" id="borrador" value="1">
                    <label class="form-check-label" for="borrador">
                        Borrador
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input v-model="postToEdit.status" class="form-check-input" type="radio" name="exampleRadios" id="publicado" value="2">
                    <label class="form-check-label" for="publicado">
                        Publicado
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input v-model="postToEdit.status" class="form-check-input" type="radio" name="exampleRadios" id="inactivo" value="3">
                    <label class="form-check-label" for="inactivo">
                        Inactivo
                    </label>
                </div>

               <div class="row mt-4">
                    <div class="form-group col-6">
                        <label for="image"><strong>Imagen del post</strong></label>
                        <input type="file" name="image" id="image" class="form-control-file" @change="selectFile" ref="fileInput" accept="image/*">
                        <span class="text-danger" v-if="errors && errors.image">{{ errors.image[0] }}</span>
                    </div>

                    <figure class="col-6">
                        <img v-if="thumbtail" :src="imagen" width="150" height="150">
                        <img v-else :src="postToEdit.image.url" width="150" height="150">
                    </figure>
                </div>  
                

                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" :disabled="form_submitting"
                        :value="form_submitting ? 'Guardando post...' : 'Guardar post'">
                    <button @click="closeModalWithReset()" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>      
</template>

<script>

    export default {
        props: ['post'],
        data(){
            return {
                postToEdit: {
                    id: this.post.id,
                    title: this.post.title,
                    content: this.post.content,
                    status: this.post.status,
                    image: this.post.image,
                    user_id: document.querySelector("meta[name='user_id']").getAttribute('content')
                },
                errors: {},
                thumbtail: '',
                form_submitting: false,
            }
        },
        methods: {
            async editPost(id){
                try {
                    this.form_submitting = true;
                    let fields = new FormData();
    
                    fields.append('title', this.postToEdit.title);
                    fields.append('content', this.postToEdit.content);
                    fields.append('status', this.postToEdit.status);
                    fields.append('user_id', this.postToEdit.user_id);
                    fields.append('_method', 'PUT');

                    if(this.thumbtail) fields.append('image', this.postToEdit.image)
                
                    await axios.post(`/api/posts/${id}`, fields, {
                        headers: { "Content-Type": "multipart/form-data" }
                    })

                    this.$swal({
                        icon: 'success',
                        title: 'El post se editó exitosamente!'
                    });

                    this.closeModalWithReset()
                } catch (error) {
                    if(error.response.status === 422){
                        this.errors = error.response.data.errors;
                    }
                    this.form_submitting = false;
                }
            },
            selectFile(e){
                const file = e.target.files[0]
                this.postToEdit.image = file;
                this.uploadImage(file);
            },
            uploadImage(file){
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.thumbtail = e.target.result;
                }
                reader.readAsDataURL(file)
            },
            resetData(){
                this.postToEdit = {
                    id: this.post.id,
                    title: this.post.title,
                    content: this.post.content,
                    status: this.post.status,
                    image: this.post.image,
                    user_id: document.querySelector("meta[name='user_id']").getAttribute('content')
                },
                this.errors = {};
                this.$refs.fileInput.value = '';
                this.thumbtail = '';
            },
            closeModalWithReset(){
                this.$emit('close-modal');
            }
        },
        computed: {
            imagen() {
                return this.thumbtail;
            }
        }
    }

</script>
