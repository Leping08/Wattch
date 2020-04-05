<template>
    <div>
        <div class="flex flex-wrap mb-6">
            <label for="name" class="block text-gray-600 text-sm font-bold mb-2">
                <span class="mdi mdi-account-outline"></span> Name on Card
            </label>

            <input id="name" type="text" class="input" name="name" v-model="name" placeholder="John Doe" required>
            <span class="text-red-600 italic pt-2">{{nameError}}</span>
        </div>

        <div class="flex flex-wrap mb-6">
            <label for="email" class="block text-gray-600 text-sm font-bold mb-2">
                <span class="mdi mdi-credit-card-outline"></span> Card Details
            </label>
            <!-- Stripe Elements Placeholder -->
            <div id="card-element" class="input bg-white"></div>
            <span class="text-red-600 italic pt-2">{{stripeError}}</span>
        </div>

        <input type="hidden" :value="payment_method_id" name="payment_method_id">

        <button @click.prevent="submitFormToCreateToken()" class="btn-teal">
            Save
        </button>
    </div>
</template>

<script>
    export default {
        name: "UpdatePaymentMethod.vue",
        props: ['stripekey', 'intent'],

        data() {
            return {
                stripeError: '',
                nameError: '',
                loading: false,
                payment_method_id: null,
                name: null
            }
        },
        mounted() {
            this.setUpStripe();
        },
        watch: {
            name: function () {
                if (this.name) {
                    this.nameError = null;
                }
            }
        },
        methods: {
            setUpStripe() {
                if (window.Stripe === undefined) {
                    console.log('Stripe V3 library not loaded!');
                } else {
                    const stripe = window.Stripe(this.stripekey);
                    this.stripe = stripe;

                    const elements = stripe.elements();
                    this.cardElement = elements.create('card');

                    this.cardElement.mount('#card-element');

                    this.listenForErrors();
                }
            },

            listenForErrors() {
                const vm = this;

                this.cardElement.addEventListener('change', (event) => {
                    vm.toggleError(event);
                });
            },

            toggleError (event) {
                if (event.error) {
                    this.stripeError = event.error.message;
                } else {
                    this.stripeError = '';
                }
            },

            submitFormToCreateToken() {
                if (!this.name) {
                    this.nameError = 'Please add card holder name';
                }

                if (this.stripeError === '') {
                    this.createToken()
                }
            },

            createToken() {
                const vm = this;

                this.stripe.handleCardSetup(this.intent.client_secret, this.cardElement, {
                        payment_method_data: {
                            billing_details: {
                                name: this.name
                            }
                        }
                    }).then((result) => {
                    if (result.error) {
                        this.stripeError = result.error.message;
                    } else {
                        this.payment_method_id = result.setupIntent.payment_method;
                        this.$nextTick(function () {
                            document.getElementById('payment_form').submit();
                        })
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
