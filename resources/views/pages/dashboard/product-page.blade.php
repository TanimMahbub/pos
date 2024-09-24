@extends('layout.sidenav-layout')
@section('title', 'All Products')
@section('content')
    @include('components.product.product-list')
    @include('components.product.product-delete')
    @include('components.product.product-create')
    @include('components.product.product-update')
@endsection
