<template>
    <div>
        <div class="flex mb-4">
            <input type="hidden" id="product_id" name="product_id" :value="selected_product.id">

            <div v-for="(product, index) in products" class="mb-4 lg:mb-0 lg:w-1/3 lg:px-2">
                <div class="text-center bg-white p-8 card" :class="activeClasses(product.id)" @click="selected_product = product">
                    <div class="flex" v-if="selected_product.id === product.id">
                        <div class="flex-1">

                        </div>
                        <div class="flex">
                            <div class="absolute -mt-6">
                                <span class="mdi mdi-check-circle text-teal-500 text-2xl"></span>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-lg mb-4 text-gray-600 italic">{{ product.name }}</h2>
                    <div class="mb-4 italic">
                        <span class="text-xl text-gray-500">$</span>
                        <span class="text-3xl text-gray-700">{{ product.price/100 }}</span>
                        <span class="text-sm text-gray-500">/mo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductSelector.vue",
        props: ['products', 'current'],
        data() {
            return {
                selected_product: null
            }
        },
        methods: {
            activeClasses: function (productId) {
                if (this.selected_product.id === productId) {
                    return 'border-2 border-teal-500'
                } else {
                    return 'border border-gray-100'
                }
            }
        },
        created() {
            this.selected_product = this.current;
        }
    }
</script>

<style scoped>

</style>
