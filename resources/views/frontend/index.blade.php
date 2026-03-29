@extends('frontend.master')
@section('content')
<div class="main">

  <!-- ════ MOBILE ORDER 1: SLIDER ════ -->
  <!-- ════ MOBILE ORDER 2: LAST UPDATE / POPULAR POST ════ -->
  <div class="htrow">
    <div class="hero-wrap">
      <div class="hero" id="hslider">
        <img id="himg" src="https://picsum.photos/seed/h1/760/265" alt="">
        <div class="hcap" id="hcap">ঈদে টাঙ্গাইল মহাসড়কে ভয়াবহ যানজটের শঙ্কা</div>
        <button class="hbtn pv" onclick="hgo(-1)">&#10094;</button>
        <button class="hbtn nx" onclick="hgo(1)">&#10095;</button>
      </div>
    </div>
    <div class="tsid">
      <div class="tab-btns">
        <button class="tbtn on" onclick="swt(this,'lu')">Last Update</button>
        <button class="tbtn" onclick="swt(this,'pp')">Popular Post</button>
      </div>
      <div style="border:1px solid var(--bd);border-top:none;">
        <div class="tbody" id="lu">
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t1/60/45" alt=""><p>একশ'র বেশি হ্রদ যে উদ্যানে</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t2/60/45" alt=""><p>কালিহাতীতে ধর্ষকদের ফাঁসির দাবিতে মানব বন্ধন</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t3/60/45" alt=""><p>ডিমলায় গৃহবধূর রহস্যজনক মৃত্যু</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t4/60/45" alt=""><p>মুঠোফোন নিয়ে ছন্দে ছোট ভাইয়ের হাতে বড় ভাই খুন</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t5/60/45" alt=""><p>সৌদি মন্ত্রিসভায় আবারও রদবদল</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/t6/60/45" alt=""><p>কক্সবাজার ও কুমিল্লায় 'বন্দুকযুদ্ধে' নিহত ২</p></a>
        </div>
        <div class="tbody" id="pp" style="display:none;">
          <a class="ti" href="#"><img src="https://picsum.photos/seed/p1/60/45" alt=""><p>কেন সঞ্জয়ের বায়োপিক প্রত্যাখ্যান করেছেন আমির খান?</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/p2/60/45" alt=""><p>ডিমের ডজন ৬৫ টাকা</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/p3/60/45" alt=""><p>পদ্মা-মেঘনায় ইলিশ ধরা শুরু হচ্ছে</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/p4/60/45" alt=""><p>সতাই অবিশ্বাস্য 'সাঞ্জু'তে রণবীরের লুক</p></a>
          <a class="ti" href="#"><img src="https://picsum.photos/seed/p5/60/45" alt=""><p>বৃষ্টি সত্ত্বেও প্রচারণা চালিয়েছেন প্রার্থীরা</p></a>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ MOBILE ORDER 3: BREAKING NEWS ════ -->
  <!-- hidden on desktop via CSS, shown on mobile ≤768px -->
  <div class="mob-brk">
    <div class="mob-brk-hd"><span class="mob-brk-dot"></span><span>ব্রেকিং নিউজ</span></div>
    <div class="mob-brk-list">
      <a href="#"><img src="https://picsum.photos/seed/bk1/64/48" alt=""><span>র‍্যাবের মাদকবিরোধী অভিযানে এক মাসে নিহত ৩১</span></a>
      <a href="#"><img src="https://picsum.photos/seed/bk2/64/48" alt=""><span>মুঠোফোন নিয়ে ছন্দে ছোট ভাইয়ের হাতে বড় ভাই খুন</span></a>
      <a href="#"><img src="https://picsum.photos/seed/bk3/64/48" alt=""><span>কালিহাতীতে ধর্ষকদের ফাঁসির দাবিতে মানব বন্ধন</span></a>
      <a href="#"><img src="https://picsum.photos/seed/bk4/64/48" alt=""><span>সৌদি মন্ত্রিসভায় আবারও রদবদল</span></a>
      <a href="#"><img src="https://picsum.photos/seed/bk5/64/48" alt=""><span>কক্সবাজার ও কুমিল্লায় 'বন্দুকযুদ্ধে' নিহত ২</span></a>
      <a href="#"><img src="https://picsum.photos/seed/bk6/64/48" alt=""><span>ডিমলায় গৃহবধূর রহস্যজনক মৃত্যু</span></a>
    </div>
  </div>

  <!-- বিশেষ সংবাদ -->
  <div class="sh"><span class="sl">বিশেষ সংবাদ</span><a href="#" class="sma">| More News.. »</a></div>
  <div class="g3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px;">
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c1/360/155" alt=""><div class="ovc">কেন সঞ্জয়ের বায়োপিক প্রত্যাখ্যান করেছেন আমির খান?</div></a>
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c2/360/155" alt=""><div class="ovc">ডিমের ডজন ৬৫ টাকা</div></a>
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c3/360/155" alt=""><div class="ovc">পদ্মা-মেঘনায় ইলিশ ধরা শুরু হচ্ছে</div></a>
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c4/360/155" alt=""><div class="ovc">সতাই অবিশ্বাস্য 'সাঞ্জু'তে রণবীরের লুক</div></a>
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c5/360/155" alt=""><div class="ovc">বৃষ্টি সত্ত্বেও প্রচারণা চালিয়েছেন প্রার্থীরা</div></a>
    <a class="nc" href="#"><img src="https://picsum.photos/seed/c6/360/155" alt=""><div class="ovc">শাকিব অনুমতি দিলে ঈদে দেখা মিলবে অপুর</div></a>
  </div>

  <!-- সারাদেশ + আন্তর্জাতিক -->
  <div class="g2" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px;">
    <div>
      <div class="sh"><span class="sl">সারাদেশ</span><a href="#" class="sma">| More News.. »</a></div>
      <img src="https://picsum.photos/seed/sd1/440/200" alt="" class="limg">
      <div class="lt">কালিহাতীতে ধর্ষকদের ফাঁসির দাবিতে মানব বন্ধন</div>
      <p class="lp">মেহেদী হাসান॥ টাঙ্গাইলের কালিহাতীতে ৭ম শ্রেণী ছাত্রী ধর্ষণের ঘটনায় অভিযুক্ত আনেছর আলী ও শরীফুলের ফাঁসির দাবিতে মানব বন্ধন কর্মসূচি পালন করেছে এলাকাবাসী। <a href="#" class="rm">read more</a></p>
      <div class="sml" style="margin-top:8px;">
        <a href="#"><img src="https://picsum.photos/seed/sl1/68/51" alt=""><span>ডিমলায় গৃহবধূর রহস্যজনক মৃত্যু</span></a>
        <a href="#"><img src="https://picsum.photos/seed/sl2/68/51" alt=""><span>নীলফামারীতে সহকারী শিক্ষক নিয়োগ পরীক্ষায় ডিভাইসসহ আটক ১৪</span></a>
        <a href="#"><img src="https://picsum.photos/seed/sl3/68/51" alt=""><span>তিস্তা নদীর বিপদসীমার পরিমাপ পরিবর্তন</span></a>
        <a href="#"><img src="https://picsum.photos/seed/sl4/68/51" alt=""><span>ডিম বিক্রেতা থেকে মাদক ব্যবসায়ী ভোদল</span></a>
        <a href="#"><img src="https://picsum.photos/seed/sl5/68/51" alt=""><span>বেইলি রোডে ফখরদ্দীনকে ৫ লাখ টাকা জরিমানা</span></a>
      </div>
    </div>
    <div>
      <div class="sh"><span class="sl">আন্তর্জাতিক</span><a href="#" class="sma">| More News.. »</a></div>
      <img src="https://picsum.photos/seed/aj1/440/200" alt="" class="limg">
      <div class="lt">সৌদি মন্ত্রিসভায় আবারও রদবদল</div>
      <p class="lp">সৌদি আরবের মন্ত্রিসভায় আবারও বড় পরিবর্তন আনা হয়েছে। রাজকীয় ফরমানে বেশ কয়েকজন মন্ত্রীকে পদ থেকে সরিয়ে নতুন মন্ত্রী নিয়োগ দেওয়া হয়েছে। <a href="#" class="rm">read more</a></p>
      <div class="sml" style="margin-top:8px;">
        <a href="#"><img src="https://picsum.photos/seed/al1/68/51" alt=""><span>তিস্তা নদীর বিপদসীমার পরিমাপ পরিবর্তন</span></a>
        <a href="#"><img src="https://picsum.photos/seed/al2/68/51" alt=""><span>মার্কিন যুক্তরাষ্ট্রে নতুন বাণিজ্য চুক্তির আলোচনা</span></a>
        <a href="#"><img src="https://picsum.photos/seed/al3/68/51" alt=""><span>ইরানের পরমাণু কর্মসূচি নিয়ে উদ্বেগ বাড়ছে</span></a>
        <a href="#"><img src="https://picsum.photos/seed/al4/68/51" alt=""><span>জাতিসংঘে রোহিঙ্গা সংকট নিয়ে নতুন প্রস্তাব</span></a>
        <a href="#"><img src="https://picsum.photos/seed/al5/68/51" alt=""><span>ভারতে নির্বাচনী প্রচারণায় নতুন মাত্রা</span></a>
      </div>
    </div>
  </div>

  <!-- তথ্যপ্রযুক্তি -->
  <div class="sh"><span class="sl">তথ্যপ্রযুক্তি</span><a href="#" class="sma">| More News.. »</a></div>
  <div class="g3" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:9px;margin-bottom:22px;">
    <div>
      <a href="#" class="ov" style="display:block;margin-bottom:9px;"><img src="https://picsum.photos/seed/tp1/330/178" alt="" style="height:178px;"><div class="ovc">সারাদেশে কালবৈশাখী ঝড়ের সতর্কবার্তা</div></a>
      <a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/tp2/330/178" alt="" style="height:178px;"><div class="ovc">ময়মনসিংহে বন্দুকযুদ্ধে যুবক নিহত</div></a>
    </div>
    <div><a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/tp3/330/365" alt="" style="height:365px;"><div class="ovc">ডিমলায় সিপিবির স্মরণ সভা</div></a></div>
    <div>
      <a href="#" class="ov" style="display:block;margin-bottom:9px;"><img src="https://picsum.photos/seed/tp4/330/178" alt="" style="height:178px;"><div class="ovc">আজ শেখ জামালের জন্মদিন</div></a>
      <a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/tp5/330/178" alt="" style="height:178px;"><div class="ovc">ভারতে মুক্তি পেয়েছে বাংলাদেশের 'ভুবন মাঝি'</div></a>
    </div>
  </div>

  <!-- ক্রাইম + আইন + বিনোদন -->
  <div class="g3" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:22px;">
    <div>
      <div class="sh"><span class="sl">ক্রাইম রিপোর্ট</span><a href="#" class="sma">| More »</a></div>
      <div class="sml">
        <a href="#"><img src="https://picsum.photos/seed/cr1/68/51" alt=""><span>মুঠোফোন নিয়ে ছন্দে ছোট ভাইয়ের হাতে বড় ভাই খুন</span></a>
        <a href="#"><img src="https://picsum.photos/seed/cr2/68/51" alt=""><span>কক্সবাজার ও কুমিল্লায় 'বন্দুকযুদ্ধে' নিহত ২</span></a>
        <a href="#"><img src="https://picsum.photos/seed/cr3/68/51" alt=""><span>ডিম বিক্রেতা থেকে মাদক ব্যবসায়ী ভোদল</span></a>
        <a href="#"><img src="https://picsum.photos/seed/cr4/68/51" alt=""><span>ডিমের ডজন ৬৫ টাকা</span></a>
        <a href="#"><img src="https://picsum.photos/seed/cr5/68/51" alt=""><span>র‍্যাবের মাদকবিরোধী অভিযানে এক মাসে নিহত ৩১</span></a>
      </div>
    </div>
    <div>
      <div class="sh"><span class="sl">আইন-আদালত</span><a href="#" class="sma">| More »</a></div>
      <img src="https://picsum.photos/seed/aa1/340/200" alt="" style="height:200px;">
      <div class="lt" style="font-size:15px;">কালিহাতীতে ধর্ষকদের ফাঁসির দাবিতে মানব বন্ধন</div>
      <p class="lp">মেহেদী হাসান॥ টাঙ্গাইলের কালিহাতীতে ৭ম শ্রেণী ছাত্রী ধর্ষণের ঘটনায়... <a href="#" class="rm">read more</a></p>
    </div>
    <div>
      <div class="sh"><span class="sl">বিনোদন</span><a href="#" class="sma">| More »</a></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
        <a class="b2" href="#"><img src="https://picsum.photos/seed/bn1/165/115" alt=""><p>কেন সঞ্জয়ের বায়োপিক প্রত্যাখ্যান করেছেন আমির খান?</p></a>
        <a class="b2" href="#"><img src="https://picsum.photos/seed/bn2/165/115" alt=""><p>ডিমের ডজন ৬৫ টাকা</p></a>
        <a class="b2" href="#"><img src="https://picsum.photos/seed/bn3/165/115" alt=""><p>ফারিয়ার 'পটাকায়' অশ্লীলতা!</p></a>
        <a class="b2" href="#"><img src="https://picsum.photos/seed/bn4/165/115" alt=""><p>পদ্মা-মেঘনায় ইলিশ ধরা শুরু হচ্ছে</p></a>
      </div>
    </div>
  </div>

  <!-- ভ্রমণ + ফিচার + ধর্ম -->
  <div class="g3" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:22px;">
    <div>
      <div class="sh"><span class="sl">ভ্রমণ</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/vh1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">একশ'র বেশি হ্রদ যে উদ্যানে</div>
        <p class="lp">লেক বা হ্রদ প্রায় সব উদ্যানেই রয়েছে। তবে পোল্যান্ডের প্লোজোনিয়া জাতীয় উদ্যানে হ্রদ রয়েছে একশ'র বেশি... <a href="#" class="rm">read more</a></p>
      </a>
      <div class="sml" style="margin-top:8px;">
        <a href="#"><img src="https://picsum.photos/seed/vl1/68/51" alt=""><span>গরমে শিশুর আরাম</span></a>
        <a href="#"><img src="https://picsum.photos/seed/vl2/68/51" alt=""><span>গরমে আরামে ফ্যাশন</span></a>
        <a href="#"><img src="https://picsum.photos/seed/vl3/68/51" alt=""><span>সিগারেট তৈরির মূল উপাদান</span></a>
      </div>
    </div>
    <div>
      <div class="sh"><span class="sl">ফিচার</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/fc1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">কেন সঞ্জয়ের বায়োপিক প্রত্যাখ্যান করেছেন আমির খান?</div>
        <p class="lp">সঞ্জয় দত্তের জীবনী নিয়ে নির্মিত হচ্ছে সিনেমা 'সাঞ্জু'। বলিউড সুপার স্টার আমির খানের অভিনয় করার কথা ছিল... <a href="#" class="rm">read more</a></p>
      </a>
      <div class="sml" style="margin-top:8px;">
        <a href="#"><img src="https://picsum.photos/seed/fl1/68/51" alt=""><span>ছেলেদের চুল পড়ার চিকিৎসা</span></a>
        <a href="#"><img src="https://picsum.photos/seed/fl2/68/51" alt=""><span>সারাদেশে কালবৈশাখী ঝড়ের সতর্কবার্তা</span></a>
        <a href="#"><img src="https://picsum.photos/seed/fl3/68/51" alt=""><span>ময়মনসিংহে বন্দুকযুদ্ধে যুবক নিহত</span></a>
      </div>
    </div>
    <div>
      <div class="sh"><span class="sl">ধর্ম</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/dr1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">গুনাহ থেকে মুক্তির দোয়া</div>
        <p class="lp">তাওবা এবং ইগতিগফার আল্লাহর দরবারে এক অফুরন্ত রহস্যের নাম... <a href="#" class="rm">read more</a></p>
      </a>
      <div class="sml" style="margin-top:8px;">
        <a href="#"><img src="https://picsum.photos/seed/dl1/68/51" alt=""><span>পদ্মা-মেঘনায় ইলিশ ধরা শুরু হচ্ছে</span></a>
        <a href="#"><img src="https://picsum.photos/seed/dl3/68/51" alt=""><span>ক্ষমার রজনী শবেবরাত আজ</span></a>
        <a href="#"><img src="https://picsum.photos/seed/dl4/68/51" alt=""><span>বৃষ্টি সত্ত্বেও প্রচারণা চালিয়েছেন প্রার্থীরা</span></a>
      </div>
    </div>
  </div>

  <!-- Photo + Video -->
  <div class="g2" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px;">
    <div>
      <div class="pvl">Photo Gallery</div>
      <div class="galw" id="pgal">
        <div class="gimg on"><img src="https://picsum.photos/seed/pg1/560/220" alt="" style="height:220px;"><div class="gcap">ফাইল ছবি</div></div>
        <div class="gimg"><img src="https://picsum.photos/seed/pg2/560/220" alt="" style="height:220px;"><div class="gcap">ছবি ২</div></div>
        <div class="gimg"><img src="https://picsum.photos/seed/pg3/560/220" alt="" style="height:220px;"><div class="gcap">ছবি ৩</div></div>
        <button class="gbtn pv" onclick="gs('pgal',-1)">&#10094;</button>
        <button class="gbtn nx" onclick="gs('pgal',1)">&#10095;</button>
      </div>
    </div>
    <div>
      <div class="pvl">Video Gallery</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:9px;">
        <div><div class="yt-wrap"><img src="https://img.youtube.com/vi/M7lc1UVf-VE/mqdefault.jpg" alt=""><button class="yt-play" onclick="playYT(this,'M7lc1UVf-VE')"><i class="fa fa-play"></i></button></div><div class="vtt">তাঁতির বাড়ি ব্যাঙের বা | Jugnu Kids</div></div>
        <div><div class="yt-wrap"><img src="https://img.youtube.com/vi/tVlcKp3bWH8/mqdefault.jpg" alt=""><button class="yt-play" onclick="playYT(this,'tVlcKp3bWH8')"><i class="fa fa-play"></i></button></div><div class="vtt">Aam Pata Jora Jora | Bangla Nursery</div></div>
        <div><div class="yt-wrap"><img src="https://img.youtube.com/vi/d_1lBCB46Vk/mqdefault.jpg" alt=""><button class="yt-play" onclick="playYT(this,'d_1lBCB46Vk')"><i class="fa fa-play"></i></button></div><div class="vtt">খোকন খোকন... | খেয়াল খুশি</div></div>
        <div><div class="yt-wrap"><img src="https://img.youtube.com/vi/hT_nvWreIhg/mqdefault.jpg" alt=""><button class="yt-play" onclick="playYT(this,'hT_nvWreIhg')"><i class="fa fa-play"></i></button></div><div class="vtt">Bangla Nursery Rhymes Collection</div></div>
      </div>
    </div>
  </div>

  <!-- মতামত + লাইফস্টাইল + শিক্ষা -->
  <div class="g3" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:22px;">
    <div>
      <div class="sh"><span class="sl">মতামত</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/mt1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">ডিম বিক্রেতা থেকে মাদক ব্যবসায়ী ভোদল</div>
        <p class="lp">রাজশাহীর গোদাগাড়ীতে ১০০ গ্রাম হেরোইনসহ শীর্ষ মাদক ব্যবসায়ী ভোদলকে গ্রেফতার করেছে পুলিশ... <a href="#" class="rm">read more</a></p>
      </a>
    </div>
    <div>
      <div class="sh"><span class="sl">লাইফস্টাইল</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/ls1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">ডিমের ডজন ৬৫ টাকা</div>
        <p class="lp">প্রায় এক মাস ধরে রাজধানীর বিভিন্ন বাজারে কমছে ডিমের দাম। ডজন প্রতি দাম কমেছে ১৫ টাকা করে... <a href="#" class="rm">read more</a></p>
      </a>
    </div>
    <div>
      <div class="sh"><span class="sl">শিক্ষা</span><a href="#" class="sma">| More »</a></div>
      <a href="#" style="display:block;color:var(--tx);">
        <img src="https://picsum.photos/seed/sk1/340/195" alt="" style="height:195px;">
        <div class="lt" style="font-size:15px;">পাবলিক পরীক্ষায় নতুন নিয়ম আসছে</div>
        <p class="lp">শিক্ষা মন্ত্রণালয় পাবলিক পরীক্ষায় একাধিক নতুন নিয়ম চালু করতে যাচ্ছে... <a href="#" class="rm">read more</a></p>
      </a>
    </div>
  </div>

  <!-- সাহিত্য -->
  <div class="sh"><span class="sl">সাহিত্য</span><a href="#" class="sma">| More News.. »</a></div>
  <div class="g3" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:9px;margin-bottom:16px;">
    <div>
      <a href="#" class="ov" style="display:block;margin-bottom:9px;"><img src="https://picsum.photos/seed/sh1/330/152" alt="" style="height:152px;"><div class="ovc">বৃষ্টি সত্ত্বেও প্রচারণা চালিয়েছেন প্রার্থীরা</div></a>
      <a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/sh2/330/152" alt="" style="height:152px;"><div class="ovc">সারাদেশে কালবৈশাখী ঝড়ের সতর্কবার্তা</div></a>
    </div>
    <div><a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/sh3/330/313" alt="" style="height:313px;"><div class="ovc">তিস্তা নদীর বিপদসীমার পরিমাপ পরিবর্তন</div></a></div>
    <div>
      <a href="#" class="ov" style="display:block;margin-bottom:9px;"><img src="https://picsum.photos/seed/sh4/330/152" alt="" style="height:152px;"><div class="ovc">ময়মনসিংহে বন্দুকযুদ্ধে যুবক নিহত</div></a>
      <a href="#" class="ov" style="display:block;"><img src="https://picsum.photos/seed/sh5/330/152" alt="" style="height:152px;"><div class="ovc">আজ শেখ জামালের জন্মদিন</div></a>
    </div>
  </div>

</div>
@endsection
