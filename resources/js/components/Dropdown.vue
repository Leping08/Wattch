<template>
    <div class="dropdown relative">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click.prevent="isOpen = !isOpen"
        >
            <slot name="trigger"></slot>
        </div>

        <transition name="pop-out-quick">
            <div v-show="isOpen"
                 class="bg-white absolute bg-card py-2 rounded-lg shadow mt-2 z-10"
                 :class="align === 'left' ? 'left-0' : 'right-0'"
                 :style="{ width }"
            >
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            width: { default: 'auto' },
            align: { default: 'left' }
        },
        data() {
            return { isOpen: false }
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if (! event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            }
        }
    }
</script>

<style>
    .pop-out-quick-enter-active,
    .pop-out-quick-leave-active {
        transition: all 0.4s;
    }
    .pop-out-quick-enter,
    .pop-out-quick-leave-active {
        opacity: 0;
        transform: translateY(-7px);
    }
</style>
