<template>
    <div class="d-flex">
        <aside-component></aside-component>
        <posts-list-component class="content float-right"></posts-list-component>
    </div>
</template>


<script>
    import asideComponent from './AsideComponent.vue';
    import postsListComponent from './PostsListsComponent.vue';

    export default {
        components: {
            asideComponent,
            postsListComponent
        },
    }
</script>

<style scoped>
    .content {
        width: 100%;
    }
</style>