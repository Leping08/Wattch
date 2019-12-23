<template>
    <div>
        <div class="card bg-gray-100 hover:shadow m-4 p-4">
            <div class="">
                <span class="text-blue-500">$response</span><span class="text-gray-600">-></span><span class="text-teal-700">{{ selected_assertion_type.method }}</span><span class="text-gray-600">(</span><span class="text-gray-700">{{ parameters }}</span><span class="text-gray-600">)</span>
            </div>
            <div class="mt-4">
                <span class="text-gray-700">{{ selected_assertion_type.description }}</span>
            </div>
        </div>

        <div class="flex m-4">
            <div class="inline-block relative w-64">
                <select v-model="selected_type_id" id="assertion_type" name="assertion_type_id" class="block appearance-none w-full bg-white input px-4 py-2 pr-8 text-gray-600">
                    <template v-for="type in types">
                        <option :value="type.id">{{type.method}}</option>
                    </template>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
            <div class="pl-4 flex-1">
                <input v-model="parameters" class="input flex-1" id="" type="text" name="parameters" :placeholder="selected_assertion_type.example">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddAssertion.vue",
        props: ['types'],
        data() {
            return {
                selected_type_id: null,
                selected_assertion_type: [],
                parameters: ''
            }
        },
        created() {
            this.selected_type_id = 1;
        },
        watch: {
            selected_type_id: function () {
                for (let x of this.types) {
                    if(x.id === this.selected_type_id) {
                        this.selected_assertion_type = x;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
