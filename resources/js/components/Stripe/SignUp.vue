<template>
    <div>
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
            Sign Up
        </button>
    </div>
</template>

<script>
    export default {
        name: "SignUp.vue",
        props: ['stripekey'],

        data() {
            return {
                stripeError: '',
                loading: false,
                payment_method_id: null,
                name: null
            }
        },
        mounted() {
            this.setUpStripe();
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
                if (this.stripeError === '') {
                    this.createToken()
                }
            },

            createToken() {
                const vm = this;

                this.stripe.createPaymentMethod({
                    type: 'card',
                    card: this.cardElement,
                    billing_details: {
                        name: this.name,
                    },
                }).then((result) => {
                    if (result.error) {
                        this.stripeError = result.error.message;
                    } else {
                        this.payment_method_id = result.paymentMethod.id;
                        this.$nextTick(function () {
                            document.getElementById('sign_up').submit();
                        })
                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>
