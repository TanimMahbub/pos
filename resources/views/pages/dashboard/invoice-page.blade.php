@extends('layout.sidenav-layout')
@section('title', 'Invoice')
@section('content')
    @include('components.invoice.invoice-list')
    @include('components.invoice.invoice-delete')
    @include('components.invoice.invoice-details')
@endsection
