<template>
    <transition
        appear
        enter-active-class="transform duration-500 ease-in-out"
        enter-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100"
        leave-active-class="transform duration-500 ease-in-out"
        leave-class="opacity-100"
        leave-to-class="opacity-0 -translate-y-4"
    >
        <!--TODO: Make these stack-->
        <div v-if="isOpen" class="fixed inset-0 flex pointer-events-none p-6 items-start justify-end z-30 block">
            <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto">
                <div class="rounded-lg shadow-xs overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start items-center">
                            <div class="flex-shrink-0">
                                <template v-if="status === 'success'">
                                    <span class="mdi mdi-check-circle-outline text-green-400 text-2xl"></span>
                                </template>
                                <template v-if="status === 'warning'">
                                    <span class="mdi mdi-alert-octagon-outline text-orange-400 text-2xl"></span>
                                </template>
                                <template v-if="status === 'error'">
                                    <span class="mdi mdi-alert-outline text-red-400 text-2xl"></span>
                                </template>
                                <template v-if="status === 'info'">
                                    <span class="mdi mdi-alert-circle-outline text-blue-400 text-2xl"></span>
                                </template>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm leading-5 font-medium text-gray-600">
                                    {{ message }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="isOpen = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "Alert.vue",
        props: {
            status: {
                required: true,
                type: String
            },
            message: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                isOpen: true,
                icon: null
            }
        },
        created() {
            // setTimeout(() => {
            //     this.isOpen = false;
            // }, 7000)
        }
    }
</script>

<style scoped>

</style>