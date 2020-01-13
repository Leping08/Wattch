<template>
    <div :id="name" class="overlay fixed inset-0 w-full h-screen flex items-center justify-center">
        <a href="#" class="cancel"></a>

        <div class="w-full md:w-1/2 lg:w-1/3 relative rounded-lg bg-white p-4 m-4">

            <slot></slot>

            <a href="#" class="absolute top-0 right-0 m-2 text-gray-600 text-lg no-underline hover:text-gray-800"><span class="mdi mdi-close"></span></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['name']
    }
</script>

<style>
    .overlay {
        visibility: hidden;
        background: rgba(0, 0, 0, .4);
        transition: opacity .3s;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }
    .modal {
        width: 500px;
    }
    .overlay .cancel {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
