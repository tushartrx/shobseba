<div class="col-xl-3 col-lg-4">
    <aside class="sidebar">
      <div class="padding-top-2x hidden-lg-up"></div>
        <!-- Order Summary Widget-->
        <section class="card widget widget-featured-posts widget-order-summary p-4">
            <h3 class="widget-title">{{__('Order Summary')}}</h3>
            @php
            $free_shipping = DB::table('shipping_services')->whereStatus(1)->whereIsCondition(1)->first()
            @endphp

            @if ($free_shipping)
                @if ($free_shipping->minimum_price >= $cart_total)
                    <p class="free-shippin-aa"><em>{{ __('Free Shipping After Order') }} {{PriceHelper::setCurrencyPrice($free_shipping->minimum_price)}}</em></p>
                @endif
            @endif

            <table class="table">
              <tr>
                <td>{{__('Cart subtotal')}}:</td>
                <td class="text-gray-dark">{{PriceHelper::setCurrencyPrice($cart_total)}}</td>
              </tr>

              @if($tax != 0)
              <tr>
                <td>{{__('Estimated tax')}}:</td>
                <td class="text-gray-dark">{{PriceHelper::setCurrencyPrice($tax)}}</td>
              </tr>
              @endif

              @if (DB::table('states')->count() > 0)
              <tr class="{{Auth::check() && Auth::user()->state_id ? '' : 'd-none'}} set__state_price_tr">
                <td>{{__('State tax')}}:</td>
                <td class="text-gray-dark set__state_price">{{PriceHelper::setCurrencyPrice(Auth::check() && Auth::user()->state_id ? ($cart_total*Auth::user()->state->price/100 ): 0)}}</td>
              </tr>
              @endif

              @if($discount)
              <tr>
                <td>{{__('Coupon discount')}}:</td>
                <td class="text-danger">- {{PriceHelper::setCurrencyPrice($discount ? $discount['discount'] : 0)}}</td>
              </tr>
              @endif
            
              @if($shipping)
              <tr class="d-none set__shipping_price_tr">
                <td>{{__('Shipping')}}:</td>
                <td class="text-gray-dark set__shipping_price">{{PriceHelper::setCurrencyPrice($shipping ? $shipping->price : 0)}}</td>
              </tr>
              @endif
              <tr>
                <td class="text-lg text-primary">{{__('Order total')}}</td>
                <td class="text-lg text-primary grand_total_set">{{PriceHelper::setCurrencyPrice($grand_total)}}</td>
              </tr>
            </table>
          </section>
      <!-- Items in Cart Widget-->
      <section class="card widget widget-featured-posts widget-featured-products p-4">
        <h3 class="widget-title">{{__('Items In Your Cart')}}</h3>
      
        @foreach ($cart as $key => $item)
     
        <div class="entry">
          <div class="entry-thumb"><a href="{{route('front.product',$item['slug'])}}"><img src="{{asset('assets/images/'.$item['photo'])}}" alt="Product"></a></div>
          <div class="entry-content">
            <h4 class="entry-title"><a href="{{route('front.product',$item['slug'])}}">
                {{ Str::limit($item['name'], 45) }}

            </a></h4>
            <span class="entry-meta">{{$item['qty']}} x {{PriceHelper::setCurrencyPrice($item['main_price'])}}</span>
            @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
            <span class="entry-meta"><b>{{$option_name}}</b> : {{PriceHelper::setCurrencySign()}}{{$item['attribute']['option_price'][$optionkey]}}</span>
            @endforeach
         </div>
        </div>
        @endforeach

      </section>


    </aside>
  </div>
