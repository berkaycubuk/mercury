@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li class="active">Ödeme</li>
    </ul>
</div>

<form class="checkout container" id="credit-card-form" action="{{ route('store.checkout.process-payment') }}" method="POST">
    <div class="checkout-content form">
        @csrf
        <input type="hidden" name="order-id" value="{{ $order->id }}" />
        <h3>Kart Bilgileri</h3><br />
        <div class="form-group">
            <label>Kart Üzerindeki İsim</label>
            <input value="{{ old('card-full-name') }}" type="text" name="card-full-name" pattern="[a-zA-Z]{3,50}" class="form-control @error('card-full-name') error @enderror" placeholder="Kart Üzerindeki İsim" required />
            @error('card-full-name')
                <div class="form-input-error">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Kart Numarası</label>
            <input value="{{ old('card-number') }}" type="text" name="card-number" pattern="[0-9]{16}" maxlength="16" class="form-control @error('card-number') error @enderror" placeholder="Kart Numarası" required />
            @error('card-number')
                <div class="form-input-error">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Ay</label>
                <select value="{{ old('card-month') }}" name="card-month" class="form-control @error('card-month') error @enderror" required >
                    <option value="null" selected disabled>Ay</option>
                    @foreach(range(1,12) as $number)
                        @if($number < 10)
                            @if(old('card-month') && old('card-month') == $number)
                                <option value="{{ $number }}" selected>0{{ $number }}</option>
                            @else
                                <option value="{{ $number }}">0{{ $number }}</option>
                            @endif
                        @else
                            @if(old('card-month') && old('card-month') == $number)
                                <option value="{{ $number }}" selected>{{ $number }}</option>
                            @else
                                <option value="{{ $number }}">{{ $number }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
                @error('card-month')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Yıl</label>
                <select value="{{ old('card-year') }}" name="card-year" class="form-control @error('card-year') error @enderror" required >
                    <option value="null" selected disabled>Yıl</option>
                    @foreach(range(date('y'), date('y') + 20) as $number)
                        @if(old('card-year') && old('card-year') == $number)
                            <option value="{{ $number }}" selected>{{ $number }}</option>
                        @else
                            <option value="{{ $number }}">{{ $number }}</option>
                        @endif
                    @endforeach
                </select>
                @error('card-year')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="card-cvv">CVV</label>
                <input value="{{ old('card-cvv') }}" id="card-cvv" type="text" name="card-cvv" pattern="[0-9]{3,4}" maxlength="4" class="form-control @error('card-cvv') error @enderror" placeholder="CVV" required />
                @error('card-cvv')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <!-- <div class="form-group">
            <label class="input-checkbox">3D Secure kullanmak istiyorum.
                <input type="checkbox" name="shipping-not-same-with-billing">
                <span class="input-checkbox-checkmark"></span>
            </label>
        </div> -->
    </div>
    <div class="checkout-sidebar">
        <h2>Sepet Özeti</h2>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Ara toplam</div>
            <div id="cart-total-without-tax" class="cart-summary-price-amount">{{ format_money($cart->total_price - $cart->tax) }}</div>
        </div>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">KDV</div>
            <div id="cart-tax" class="cart-summary-price-amount">{{ format_money($cart->tax) }}</div>
        </div>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Kargo</div>
            <div id="cart-shipping-price" class="cart-summary-price-amount">{{ format_money($order->meta['shipping_cost']) }}</div>
        </div>
        <hr />
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Toplam</div>
            <div id="cart-total" class="cart-summary-price-amount">{{ format_money($cart->total_price + $order->meta['shipping_cost']) }}</div>
        </div><br />
        <div>
            <label class="input-checkbox">
                <input type="checkbox" name="accept-presell-policy" {{ old('accept-presell-policy') ? 'checked' : '' }}>
                <span class="input-checkbox-checkmark @error('accept-presell-policy') error @enderror"></span>
            </label>
            <a style="cursor: pointer; display: initial; color: var(--color-primary);" onclick="onbilgiModal.open()">Ön Bilgilendirme Formunu</a> okudum, onaylıyorum.
            @error('accept-presell-policy')
                <div class="form-input-error">
                    {{ $message }}
                </div>
            @enderror
            <br/>
            <br/>
        </div>
        <div>
            <label class="input-checkbox">
                <input type="checkbox" name="accept-selling-policy" {{ old('accept-selling-policy') ? 'checked' : '' }}>
                <span class="input-checkbox-checkmark @error('accept-selling-policy') error @enderror"></span>
            </label>
            <a style="cursor: pointer; display: initial; color: var(--color-primary);" onclick="mesafeliModal.open()">Mesafeli Satış Sözleşmesini</a> okudum, onaylıyorum.
            @error('accept-selling-policy')
                <div class="form-input-error">
                    {{ $message }}
                </div>
            @enderror
            <br/>
            <br/>
        </div>
        @guest
            <br />
            <br />
            <label class="input-checkbox">Fırsatlar ve İndirimler hakkında e-posta ve sms almak istiyorum.
                <input type="checkbox" name="accept-receive-notifications">
                <span class="input-checkbox-checkmark"></span>
            </label>
        @endguest
        <button class="btn btn-primary">Tamamla</button>
    </div>
</form>

<div class="modal" id="onbilgi-modal">
    <div class="modal-content large">
        <div class="modal-content-top">
            <div class="close-btn" onclick="onbilgiModal.close()"></div>
        </div>
        <h2>Ön Bilgilendirme Formu</h2>
        <div class="modal-scroll-content">
            {!! $onbilgi !!}
        </div>
    </div>
</div>

<div class="modal" id="mesafeli-modal">
    <div class="modal-content large">
        <div class="modal-content-top">
            <div class="close-btn" onclick="mesafeliModal.close()"></div>
        </div>
        <h2>Mesafeli Satış Sözleşmesi</h2>
        <div class="modal-scroll-content">
            {!! $mesafeli !!}
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        onbilgiModal = new Modal('#onbilgi-modal');
        mesafeliModal = new Modal('#mesafeli-modal');
    </script>

@endsection
