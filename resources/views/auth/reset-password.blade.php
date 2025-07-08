@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<livewire:reset-password  :email="request()->email" :token="request()->segment(2)" />
@endsection