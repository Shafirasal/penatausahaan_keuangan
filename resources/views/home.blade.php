@extends('layouts.template')

@section('title')
    | Home
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="section-body">
    <h4>Selamat datang di Dashboard!</h4>

    <script>
      const token = localStorage.getItem('token');
      if (!token) {
          alert("Anda belum login.");
          window.location.href = '/login';
      }
    </script>
  </div>
</section>
@endsection
