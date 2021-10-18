@extends('core::layouts.store')

@section('content')
<div class="container">  
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row text-center">
                        <h3 class="panel-heading">Payment Details</h3>
                    </div>                    
                </div>
                <div class="panel-body">
                    <form role="form" action="{{ route('store.payment.stripe.submit') }}" method="post" class="validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="payment-form">
                        @csrf
  
                        <input type="hidden" value="{{ $order->id }}" name="order_id" />

                        <div class="form-group">
                            <input class="input" type="text" placeholder="Name on Card" />
                        </div>
                        <div class="form-group">
                            <input autocomplete='off' class="input card-num" size="20" type="text" placeholder="Card Number">
                        </div>
                        <div class="form-row">
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <input autocomplete="off" class="input card-cvc" size="4" type="text" placeholder="CVC" />
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <input class="input card-expiry-month" size="2" type="text" placeholder="MM" />
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <input class="input card-expiry-year" size="4" type="text" placeholder="YYYY" />
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-md-12 hide error form-group'>
                                <div class='alert-danger alert'>Fix the errors before you begin.</div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xs-12">
                              <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now (${{ $order->total_price }})</button>
                            </div>
                        </div>
                          
                    </form>
                </div>
            </div>        
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".validation");
  $('form.validation').bind('submit', function(e) {
    var $form         = $(".validation"),
        inputVal = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputVal),
        $errorStatus = $form.find('div.error'),
        valid         = true;
        $errorStatus.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorStatus.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-num').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeHandleResponse);
    }
  
  });
  
  function stripeHandleResponse(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>
@endsection
