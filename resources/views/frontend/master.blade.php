@include('frontend/pages.header')
<!-- TICKER -->
<div class="ticker-wrap">
  <div class="ticker inner" style="padding-left:0;padding-right:0;">
    <div class="tlbl">শিরোনাম</div>
    <div class="ttrack">
      <div class="tscroll">০ একশ'র বেশি হ্রদ যে উদ্যানে &nbsp;&nbsp;&nbsp; ০ কালিহাতীতে ধর্ষকদের ফাঁসির দাবিতে মানব বন্ধন &nbsp;&nbsp;&nbsp; ০ ডিমলায় গৃহবধূর রহস্যজনক মৃত্যু &nbsp;&nbsp;&nbsp; ০ মুঠোফোন নিয়ে ছন্দে ছোট ভাইয়ের হাতে বড় ভাই খুন &nbsp;&nbsp;&nbsp; ০ সৌদি মন্ত্রিসভায় আবারও রদবদল &nbsp;&nbsp;&nbsp; ০ কক্সবাজার ও কুমিল্লায় বন্দুকযুদ্ধে নিহত ২</div>
    </div>
  </div>
</div>

<!-- SITE BODY -->
<div class="site-body">
<div class="page">

<!-- MAIN -->
@yield('content')
<!-- /main -->

<!-- SIDEBAR -->
@include('frontend/pages/sidebar')
<!-- /side -->

</div><!-- /page -->
@include('frontend/pages/footer')
