<template>
    <div :id="name" class="overlay fixed inset-0 w-full h-screen flex items-center justify-center">
        <a href="#" class="cancel"></a>

        <div class="modal relative rounded-lg bg-white p-4 shadow max-w-5xl m-4">
            <slot></slot>

            <footer class="flex mt-8">
                <slot name="footer"></slot>
            </footer>

            <a href="#" class="close text-gray-600 text-2xl no-underline hover:text-gray-800">&times;</a>
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
        background: rgba(0, 0, 0, .3);
        transition: opacity .3s;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }
    .modal {
        width: 500px;
    }
    .modal .close {
        position: absolute;
        top: 15px;
        right: 15px;
    }
    .overlay .cancel {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
