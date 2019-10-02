<template>
    <div :id="name" class="overlay text-left absolute inset-0 flex justify-center opacity-0 items-center">
        <a href="#" class="cancel"></a>

        <div class="modal relative rounded-lg bg-white p-4 shadow max-w-5xl">
            <slot></slot>

            <footer class="flex mt-8">
                <slot name="footer"></slot>
            </footer>

            <a href="#" class="close">&times;</a>
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
        color: grey;
        text-decoration: none;
    }
    .overlay .cancel {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
