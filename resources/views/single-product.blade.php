{{--
@see 	    https://docs.woocommerce.com/document/template-structure/
@author 		WooThemes
@package 	WooCommerce/Templates
@version     1.6.4
--}}
@extends('layouts.app')
@section('content')
    <div class="shop-wrapper">
        @php(woocommerce_content())
    </div>
@endsection