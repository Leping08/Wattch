@extends('pages.auth.settings.layout')

@section('heading')
    Billing Settings
@endsection

@section('settings_content')
    <script src="https://js.stripe.com/v3/" type="application/javascript"></script>

    <div class="flex">
        <div class="flex-1">
            <div class="">
                <div class="card bg-white">
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Card on file</span>
                        </div>
                        <div>
                            <span class="mdi mdi-credit-card-outline text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <div>
                        @forelse($paymentMethods as $paymentMethod)
                            <div class="flex items-center
                             p-4">
                                <div>
                                    @if($paymentMethod->card->brand === 'amex')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/amex.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'diners')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/diners.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'discover')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/discover.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'jcb')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/jcb.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'mastercard')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/mastercard.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'unionpay')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/unionpay.svg') }}">
                                    @elseif($paymentMethod->card->brand === 'visa')
                                        <img class="h-6 mr-2" src="{{ asset('img/card_logos/visa.svg') }}">
                                    @else
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <span class="text-gray-700">
                                        <span class="">
                                            @if($paymentMethod->card->brand === 'unknown')
                                                {{ \Illuminate\Support\Str::title($paymentMethod->card->brand) }}
                                            @endif
                                                •••• {{ $paymentMethod->card->last4 }}</span>
                                        <span class="ml-6">{{ $paymentMethod->card->exp_month }} / {{ $paymentMethod->card->exp_year }}</span>
                                    </span>
                                </div>
                                <div class="pl-2">
                                    <a href="#change-card" class="bg-transparent hover:shadow p-1 rounded-full text-2xl focus:outline-none"><span class="mdi mdi-pencil-outline text-gray-600"></span></a>
                                </div>
                            </div>
                            @empty

                            @endforelse
                    </div>
                </div>
            </div>

                <div class="card bg-white mt-4">
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Invoices</span>
                        </div>
                        <div>
                            <span class="mdi mdi-account-cash-outline text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <div class="">
                        <div class="py-2 px-4">
                            <table class="table-auto w-full text-left">
                                <thead>
                                <tr class="text-gray-700">
                                    <th class="py-4">Date</th>
                                    <th class="py-4">Payment</th>
                                    <th class="py-4">Status</th>
                                    <th class="py-4">Invoice</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoices as $invoice)
                                    <tr class="border-t text-gray-700">
                                        <td class="py-4">{{ $invoice->date()->toFormattedDateString() }}</td>
                                        <td class="py-4">{{ $invoice->total() }}</td>
                                        <td class="py-4">{{ $invoice->status }}</td>
                                        <td class="py-4"><a href="{{ route('settings.billing.download_invoice.show', ['invoiceId' => $invoice->id]) }}" class="text-teal-600 font-bold">Download</a></td>
                                    </tr>
                                @empty

                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex mx-8 h-96">
                <img alt="" class="h-full" src="{{ asset('/img/icons/undraw_pay_online_b1hk.svg') }}">
            </div>
        </div>

        <modal name="change-card">
            <div class="p-4">
                <div class="pb-2">
                    <span class="card-heading">Change card on file</span>
                </div>
                <form method="POST" id="payment_form" class="mt-4" action="{{ route('settings.billing.store') }}">
                    @csrf
                    <update-payment-method stripekey="{{ $stripePubKey }}" :intent="{{ json_encode(auth()->user()->createSetupIntent()) }}"></update-payment-method>
                </form>
            </div>
        </modal>
@endsection
