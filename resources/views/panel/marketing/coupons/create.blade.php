@extends('panel::layouts.panel')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Yeni Kupon</h2>
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
                <form action="{{ route('panel.marketing.coupons.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="media-name">Kupon Kodu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="coupon-code" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon-description">Kupon Açıklaması</label>
                        <textarea class="form-control" id="coupon-description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kupon Türü</label>
                        <select class="form-control" name="type">
                            <option value="percent-cart">Yüzdelik indirim</option>
                            <option value="fixed-cart">Sabit indirim</option>
                        </select>
                        <small>Kuponun uygulanma şekli.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-discount">İndirim Miktarı</label>
                        <input type="number" class="form-control" id="coupon-discount" name="discount" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon-min-cart-price">Minimum sepet tutarı</label>
                        <input type="number" class="form-control" id="coupon-min-cart-price" name="min-cart-price">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-min-cart-items">Minimum ürün miktarı</label>
                        <input type="number" class="form-control" id="coupon-min-cart-items" name="min-cart-items">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-max-users">Maksimum kaç farklı kişi tarafından kullanılabileceği</label>
                        <input type="number" class="form-control" id="coupon-max-users" name="max-users">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon-max-user-apply">Bir kişi tarafından maksimum kaç kere kullanılabileceği</label>
                        <input type="number" class="form-control" id="coupon-max-user-apply" name="max-user-apply">
                        <small>Boş bırakırsanız, belli bir limit uygulanmaz.</small>
                    </div>
                    <div class="form-group">
                        <label class="control control-checkbox">
                            Ücretsiz kargo
                            <input type="checkbox" name="free-shipping" />
                            <div class="control-indicator"></div>
                        </label>
                        <small>Bu kuponun uygulandığı sepetin kargosunun ücretsiz olmasını sağlar.</small>
                    </div>
                    <div class="form-group">
                        <label for="expires-at">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="expires-at" name="expires-at" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.marketing.coupons.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
