@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!-- <h5 class="pl-3"><b>DASHBOARD</b></h5> -->
@endsection

@section('content')
<p class="pl-3">{{ Auth::user()->kode_perusahaan }}</p>

<div class="card">
    <img src={{asset('images/Keuangan_Kapal.png')}} alt="Welcome" />
</div>

@endsection

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@endsection

@section('js')
<script>
    console.log('Hi!');
</script>
@endsection