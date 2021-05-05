@extends('layouts.site')
@section('body_class', 'Cart')
@section('meta_title', __('Cart title'))
@section('meta_description',  __('Cart description'))

@section('content')

   <main class="main-container"><h1>Корзина</h1></main>

   <table>
       <tr>
           <td>Sku</td>
           <td>Name</td>
           <td>Image</td>
           <td>Quantity</td>
           <td>Price</td>
           <td>Max Quantity</td>
       </tr>

       @foreach($orderProducts as $sku => $product):

       <tr>
           <td>{{ $product["sku"] }}</td>
           <td>{{ $product["name"] }}</td>
           <td>{!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}</td>
           <td>{{ $product["quantity"] }}</td>
           <td>{{ $product["price"] }}</td>
           <td>{{ $product["max_quantity"] }}</td>
       </tr>

       @endforeach
   </table>




    {{ dd($areas) }}
@endsection
