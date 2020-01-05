<template>
    <div>
        <div>
            <span @click="isOpen = !isOpen" class="mdi mdi-menu text-gray-100 text-2xl p-4"></span>
        </div>
        <div v-if="isOpen">
            <div class="fixed w-full h-full top-0 left-0">
                <div class="flex">
                    <div class="md:w-1/3 w-1/2  bg-white h-screen opacity-100">
                        <slot name="nav"></slot>
                    </div>
                    <div class="md:w-2/3 w-1/2 bg-gray-900 opacity-50 cursor-pointer" @click="isOpen = !isOpen">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MobileNav",
        data() {
            return {
                isOpen: false
            }
        }
    }
</script>

<style scoped>
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>
