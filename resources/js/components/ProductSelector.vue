<template>
    <div>
        <div class="p-4 align-middle flex justify-center">
            <div class="flex items-center">
                <!-- TODO:Turn this into its own vue component -->
                <span class="text-gray-600 italic mr-2">Monthly</span>
                <!-- On: "bg-indigo-600", Off: "bg-gray-200" -->
                <span @click="toggle = !toggle" role="checkbox" tabindex="0" aria-checked="true" :class="toggle ? 'bg-teal-500' : 'bg-gray-400'" class="relative inline-block flex-shrink-0 h-6 w-12 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 outline-none focus:outline-none focus:shadow-outline">
                    <!-- On: "translate-x-5", Off: "translate-x-0" -->
                    <span aria-hidden="true" :class="toggle ? 'translate-x-6' : 'translate-x-0'" class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out outline-none duration-200"></span>
                </span>
                <span class="text-gray-600 italic ml-2">Yearly</span>
            </div>
        </div>
        <div class="flex flex-wrap">
            <input type="hidden" name="plan_id" :value="selected_plan.id">
            <div v-for="(product, index) in products" class="p-2 lg:w-1/3 md:w-full sm:w-full w-full relative">
                <template v-for="plan in product.plans" v-if="time_frame === plan.time_frame">
                    <div class="text-center bg-white lg:p-8 p-4 card cursor-pointer" :class="activeClasses(plan)" @click="select(plan)">
                        <h2 class="text-lg mb-4 text-gray-600 italic">{{ product.name }}</h2>
                        <div class="flex" v-if="selected_plan.id === plan.id">
                            <div class="flex-1">

                            </div>
                            <div class="flex">
                                <div class="absolute right-0 top-0 p-4">
                                    <span class="mdi mdi-check-circle text-teal-500 text-2xl"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 italic">
                            <span class="text-xl text-gray-500">$</span>
                            <span class="text-3xl text-gray-700">{{ plan.price/100 }}</span>
                            <span v-if="time_frame === 'monthly'" class="text-sm text-gray-500">/mo</span>
                            <span v-if="time_frame === 'yearly'" class="text-sm text-gray-500">/year</span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['products', 'user'],
        data() {
            return {
                time_frame: 'monthly',
                selected_plan: null,
                toggle: false
            }
        },
        created() {
            this.selected_plan = this.user.subscription[0].plan; //Set the selected plan to the users subscribed plan
            this.time_frame = this.user.subscription[0].plan.time_frame; //Set the time frame based on the users plan time frame
            this.toggle = this.time_frame !== 'monthly'; //If the time frame is monthly set the toggle to false and true if its not
        },
        methods: {
            activeClasses: function (plan) {
                if (this.selected_plan.id === plan.id) {
                    return 'border-2 border-teal-500'
                } else {
                    return 'border border-gray-100'
                }
            },
            select: function (plan) {
                this.selected_plan = plan;
            }
        },
        watch: {
            toggle() {
                this.toggle ? this.time_frame = 'yearly' : this.time_frame = 'monthly';
            }
        }
    }
</script>