<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>আজকের দিনকাল - সবার কথা বলে</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('frontend')}}/assets/css/style.css">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar-wrap">
  <div class="topbar inner">
    <div class="dt" id="dtxt">শনিবার, ২৮ মার্চ ২০২৬</div>
    <div class="soc">
      <a href="#"><i class="fa fa-search"></i></a><span class="sp">|</span>
      <a href="#"><i class="fab fa-facebook-f"></i></a><span class="sp">|</span>
      <a href="#"><i class="fab fa-twitter"></i></a><span class="sp">|</span>
      <a href="#"><i class="fab fa-linkedin-in"></i></a><span class="sp">|</span>
      <a href="#"><i class="fab fa-youtube"></i></a><span class="sp">|</span>
      <a href="#"><i class="fab fa-google-plus-g"></i></a>
    </div>
  </div>
</div>

<!-- HEADER -->
<div class="hdr-wrap">
  <div class="hdr inner">
    <a class="logo-a" href="#">
      <div class="logo-row">
        <span class="laj">আজকের</span><span class="lsq"></span><span class="ldi">দিনকাল</span>
      </div>
      <span class="ltag">ajkerdinkal.com • সবার কথা বলে</span>
    </a>
    <div class="srch">
      <input type="text" placeholder="সংবাদ খুঁজুন...">
      <button><i class="fa fa-search"></i></button>
    </div>
  </div>
</div>

<!-- MOBILE SEARCH -->
<div class="mob-srch">
  <div class="inner">
    <form onsubmit="return false;">
      <input type="text" placeholder="সংবাদ খুঁজুন...">
      <button><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>

<!-- OVERLAY -->
<div class="nav-overlay" id="navOverlay" onclick="closeNav()"></div>

<!-- NAV -->
<div class="nav-wrap">
  <div class="nav-c inner">
    <button class="hmbgr" onclick="toggleNav()"><i class="fa fa-bars"></i></button>
    <a href="#" class="nav-mob-logo">
      <span class="nml-aj">আজকের</span><span class="nml-sq"></span><span class="nml-di">দিনকাল</span>
    </a>
    <ul class="nm" id="nm">
      <li class="mob-close-li"><button onclick="toggleNav()"><i class="fa fa-times"></i> মেনু বন্ধ করুন</button></li>
      <li><a href="#" class="act">প্রচ্ছদ</a></li>
      <li><a href="#">জাতীয়</a></li>
      <li><a href="#">রাজনীতি</a></li>
      <li><a href="#">অর্থনীতি</a></li>
      <li>
        <a href="#">সারাদেশ <span class="marr">▾</span></a>
        <ul class="dd">
          <li><a href="#">ঢাকা</a></li><li><a href="#">চট্টগ্রাম</a></li>
          <li><a href="#">রাজশাহী</a></li><li><a href="#">খুলনা</a></li>
          <li><a href="#">বরিশাল</a></li><li><a href="#">সিলেট</a></li>
        </ul>
      </li>
      <li><a href="#">আন্তর্জাতিক</a></li>
      <li><a href="#">খেলাধুলা</a></li>
      <li><a href="#">বিনোদন</a></li>
      <li><a href="#">তথ্যপ্রযুক্তি</a></li>
      <li><a href="#">সাহিত্য</a></li>
      <li><a href="#">সম্পাদকীয়</a></li>
      <li>
        <a href="#">অন্যান্য <span class="marr">▾</span></a>
        <ul class="dd">
          <li><a href="#">ভ্রমণ</a></li><li><a href="#">ধর্ম</a></li>
          <li><a href="#">লাইফস্টাইল</a></li><li><a href="#">শিক্ষা</a></li>
          <li><a href="#">স্বাস্থ্য</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
