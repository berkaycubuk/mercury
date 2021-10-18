@extends('panel::layouts.panel')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Kupon Düzenle</h2>
            </div>
            <div class="card-body">
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
                            {{ $error  }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('panel.marketing.coupons.update') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $coupon->id }}" name="id" />
                    <div class="form-group">
                        <label for="media-name">Kupon Kodu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="coupon-code" name="code" value="{{ $coupon->code }}" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon-description">Kupon Açıklaması</label>
                        <textarea class="form-control" id="coupon-description" name="description">{{ $coupon->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Kupon Türü</label>
                        <select class="form-control" name="type">
                            @if($coupon->discount_type == 'percent-cart')
                            <option value="percent-cart" selected>Yüzdelik indirim</option>
                            @else
                            <option value="percent-cart">Yüzdelik indirim</option>
                            @endif
                            @if($coupon->discount_type == 'fixed-cart')
                            <option value="fixed-cart" selected>Sabit indirim</option>
                            @else
                            <option value="fixed-cart">Sabit indirim</option>
                            @endif
                        </select>
                        <small>Kuponun uygulanma şekli.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-discount">İndirim Miktarı</label>
                        <input type="number" class="form-control" id="coupon-discount" value="{{ $coupon->discount }}" name="discount" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon-min-cart-price">Minimum sepet tutarı</label>
                        <input type="number" class="form-control" id="coupon-min-cart-price" value="{{ isset($coupon->meta['min_cart_price']) ? $coupon->meta['min_cart_price'] : '' }}" name="min-cart-price">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-min-cart-items">Minimum ürün miktarı</label>
                        <input type="number" class="form-control" id="coupon-min-cart-items" value="{{ isset($coupon->meta['min_cart_items']) ? $coupon->meta['min_cart_items'] : '' }}" name="min-cart-items">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-max-users">Maksimum kaç farklı kişi tarafından kullanılabileceği</label>
                        <input type="number" class="form-control" id="coupon-max-users" value="{{ isset($coupon->meta['max_users']) ? $coupon->meta['max_users'] : '' }}" name="max-users">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-max-user-apply">Bir kişi tarafından maksimum kaç kere kullanılabileceği</label>
                        <input type="number" class="form-control" id="coupon-max-user-apply" value="{{ isset($coupon->meta['max_user_apply']) ? $coupon->meta['max_user_apply'] : '' }}" name="max-user-apply">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label class="control control-checkbox">
                            Ücretsiz kargo
                            @if($coupon->free_shipping)
                            <input type="checkbox" name="free-shipping" checked />
                            @else
                            <input type="checkbox" name="free-shipping" />
                            @endif
                            <div class="control-indicator"></div>
                        </label>
                        <small>Bu kuponun uygulandığı sepetin kargosunun ücretsiz olmasını sağlar.</small>
                    </div>
                    <div class="form-group">
                        <label for="expires-at">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="expires-at" name="expires-at" value="{{ $coupon->expires_at->format('Y-m-d') }}" required>
                        <small>Kuponun geçersiz olacağı tarih.</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.marketing.coupons.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
