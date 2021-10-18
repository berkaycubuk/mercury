@extends('core::layouts.store')

@section('content')

@include('core::partials.breadcrumb')

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        @if (session('form_error'))
            <div class="alert alert-danger">
                {{ session('form_error') }}
            </div>
        @endif
        @if (session('form_success'))
            <div class="alert alert-success">
                {{ session('form_success') }}
            </div>
        @endif
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <form action="{{ route('store.checkout.store') }}" method="POST">
            <!-- row -->
            @csrf
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Billing address</h3>
                        </div>
                        <input type="hidden" name="items" value="{{ json_encode(get_cart_items()) }}" />
                        <input type="hidden" name="total_items" value="{{ get_cart_total_items() }}" />
                        <input type="hidden" name="total_price" value="{{ get_cart_total() }}" />
                        @auth
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input value="{{ Auth::user()->first_name }}" class="input" type="text" name="first_name" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input value="{{ Auth::user()->last_name }}" class="input" type="text" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_line_1 }}" class="input" type="text" name="address_line_1" placeholder="Addres Line 1" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_line_2 }}" class="input" type="text" name="address_line_2" placeholder="Address Line 2 (not required)">
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_city }}" class="input" type="text" name="address_city" placeholder="City" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_district }}" class="input" type="text" name="address_district" placeholder="District" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_country }}" class="input" type="text" name="address_country" placeholder="Country" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->address_postal_code }}" class="input" type="text" name="address_postal_code" placeholder="Postal Code" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->phone }}" class="input" type="tel" name="phone" placeholder="Telephone" required>
                        </div>
                        <div class="form-group">
                            <input value="{{ Auth::user()->email }}" class="input" type="email" name="email" placeholder="E-mail" required>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="input" type="text" name="first_name" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="input" type="text" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_line_1" placeholder="Addres" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_line_2" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_city" placeholder="City" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_district" placeholder="District" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_country" placeholder="Country" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address_postal_code" placeholder="Postal Code" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="tel" name="phone" placeholder="Telephone" required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <div class="input-checkbox">
                                <input type="checkbox" id="create-account">
                                <label for="create-account">
                                    <span></span>
                                    Create Account?
                                </label>
                                <div class="caption">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                    <input class="input" type="password" name="password" placeholder="Enter Your Password">
                                </div>
                            </div>
                        </div>
                        @endauth
                    </div>
                    <!-- /Billing Details -->

                    @if(false)
                    <!-- Shiping Details -->
                    <div class="shiping-details">
                        <div class="section-title">
                            <h3 class="title">Shiping address</h3>
                        </div>
                        <div class="input-checkbox">
                            <input type="checkbox" id="shiping-address">
                            <label for="shiping-address">
                                <span></span>
                                Ship to a diffrent address?
                            </label>
                            <div class="caption">
                                <div class="form-group">
                                    <input class="input" type="text" name="first-name" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="last-name" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="address" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="city" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="country" placeholder="Country">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="zip-code" placeholder="ZIP Code">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="tel" name="tel" placeholder="Telephone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Shiping Details -->
                    @endif

                    <!-- Order notes -->
                    <div class="order-notes">
                        <textarea class="input" name="notes" placeholder="Order Notes"></textarea>
                    </div>
                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            @foreach(get_cart_items() as $item)
                                <div class="order-col">
                                    <div>{{ $item->amount }}x {{ $item->title }}</div>
                                    <div>${{ $item->price * $item->amount }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total">${{ get_cart_total() }}</strong></div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1">
                            <label for="payment-1">
                                <span></span>
                                Direct Bank Transfer
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-2">
                            <label for="payment-2">
                                <span></span>
                                Cheque Payment
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-3">
                            <label for="payment-3">
                                <span></span>
                                Paypal System
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="input-checkbox">
                        <input type="checkbox" id="terms">
                        <label for="terms">
                            <span></span>
                            I've read and accept the <a href="#">terms & conditions</a>
                        </label>
                    </div>
                    <button class="primary-btn order-submit">Place order</button>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </form>
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
@endsection
