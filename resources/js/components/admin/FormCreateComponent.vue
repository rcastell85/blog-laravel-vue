<template>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Crear nuevo post</h4>
            <button @click="closeModalWithReset()" type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="savePost()" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title"><strong>Titulo</strong></label>
                    <input v-model="post.title" type="text" name="title" :class="[errors && errors.title ? 'form-control border border-danger' : 'form-control']" placeholder="Titulo del post">
                    <span class="text-danger" v-if="errors && errors.title">{{ errors.title[0] }}</span>
                </div>
                <div class="form-group">
                    <label for="content"><strong>Contenido</strong></label>
                    <textarea v-model="post.content" :class="[errors && errors.content ? 'form-control border border-danger' : 'form-control']" name="content" cols="30" rows="10" placeholder="Contenido del post"></textarea>
                    <span class="text-danger" v-if="errors && errors.content">{{ errors.content[0] }}</span>
                </div>

                <div><strong>Status</strong></div>
                <div class="form-check form-check-inline">
                    <input v-model="post.status" class="form-check-input" type="radio" name="exampleRadios" id="borrador" value="1" checked>
                    <label class="form-check-label" for="borrador">
                        Borrador
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input v-model="post.status" class="form-check-input" type="radio" name="exampleRadios" id="publicado" value="2">
                    <label class="form-check-label" for="publicado">
                        Publicado
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input v-model="post.status" class="form-check-input" type="radio" name="exampleRadios" id="inactivo" value="3">
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
                        <img :src="imagen" width="150" height="150" v-if="thumbtail">
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
        data(){
            return {
                post: {
                    title: '',
                    content: '',
                    status: 1,
                    image: null,
                    user_id: document.querySelector("meta[name='user_id']").getAttribute('content')
                },
                errors: {},
                thumbtail: '',
                form_submitting: false,
            }
        },
        methods: {
            async savePost(){
                try {  
                    this.form_submitting = true;
                    let fields = new FormData();

                    for(let key in this.post){
                        fields.append(key, this.post[key])
                    }
       
                    await axios.post(`/api/posts`, fields)
                    
                    this.form_submitting = false;
                    this.$swal({
                        icon: 'success',
                        title: 'El post se creó exitosamente!'
                    });
                    this.resetData()
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
                this.post.image = file;
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
                this.post = {
                    title: '',
                    content: '',
                    status: 1,
                    image: null,
                    user_id: document.querySelector("meta[name='user_id']").getAttribute('content')
                };
                this.errors = {};
                this.$refs.fileInput.value = '';
                this.thumbtail = '';
            },
            closeModalWithReset(){
                this.resetData();
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
