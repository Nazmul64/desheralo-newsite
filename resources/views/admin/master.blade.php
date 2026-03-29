 @include('admin/pages/header')
<!-- ═══════ SIDEBAR ═══════ -->
 @include('admin/pages/sidebar')
<!-- ═══════ MAIN ═══════ -->
<div class="main">

  <!-- TOPBAR -->
@include('admin/pages/topbar')
  <!-- CONTENT -->
@yield('content')
</div>
@include('admin/pages/footer')
