<template>
    <div class="flex xl:flex-no-wrap lg:flex-no-wrap md:flex-no-wrap sm:flex-wrap flex-wrap xl:w-10/12 lg:w-4/5 md:w-full sm:w-full w-full mx-auto">

        <input type="hidden" id="product_id" name="product_id" :value="selected_product.id">
        <div v-for="(product, index) in products" @click="selected_product = product" :class="activeClasses(product.id)" class="xl:w-1/3 lg:w-1/3 md:w-full sm:w-full w-full card bg-white text-center xl:p-10 lg:p-8 md:p-8 sm:p-4 p-4 lg:m-4 md:m-2 sm:m-2 m-2 cursor-pointer hover:border-teal-500">
            <div class="flex" v-if="selected_product.id === product.id">
                <div class="flex-1">

                </div>
                <div class="flex">
                    <div class="absolute -mt-6">
                        <span class="mdi mdi-check-circle text-teal-500 text-2xl"></span>
                    </div>
                </div>
            </div>
            <div class="text-2xl italic text-gray-700 mb-6">
                {{ product.name }}
            </div>
            <div class="mb-6">
                <img alt="" class="h-32 mx-auto" :src="product.icon">
            </div>
            <div class="mb-6">
                <span class="text-xl text-gray-500">$</span>
                <span class="text-2xl text-gray-700">{{ product.price / 100 }}</span>
                <span class="text-sm text-gray-500">/mo</span>
            </div>
            <div class="border-t border-solid text-sm pb-10">
                <div v-for="(feature, index) in product.features" class="text-center border-b py-4 text-gray-700">
                    {{ feature }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SignUpProductSelector.vue",
        props: ['products'],
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
        mounted() {
            this.selected_product = this.products[1]
        }
    }
</script>

<style scoped>

</style>
