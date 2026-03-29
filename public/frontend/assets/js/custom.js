
/* DATE */
(function u(){
  var b=['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  var d=['রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার'];
  var m=['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
  var t=function(n){return String(n).replace(/\d/g,function(x){return b[x];});};
  var n=new Date(),h=n.getHours(),mi=n.getMinutes();
  var ap=h>=12?'অপরাহ্ন':'পূর্বাহ্ন';
  if(h>12)h-=12;if(h===0)h=12;
  document.getElementById('dtxt').textContent=d[n.getDay()]+', '+t(n.getDate())+' '+m[n.getMonth()]+' '+t(n.getFullYear())+', '+t(h)+':'+t(String(mi).padStart(2,'0'))+' '+ap;
  setTimeout(u,60000);
})();

/* HERO */
var hs=[
  {i:'https://picsum.photos/seed/h1/760/265',c:'ঈদে টাঙ্গাইল মহাসড়কে ভয়াবহ যানজটের শঙ্কা'},
  {i:'https://picsum.photos/seed/h2/760/265',c:'পদ্মা-মেঘনায় ইলিশ ধরা শুরু হচ্ছে'},
  {i:'https://picsum.photos/seed/h3/760/265',c:'সারাদেশে কালবৈশাখী ঝড়ের সতর্কবার্তা'},
];
var hi=0;
function hgo(d){hi=(hi+d+hs.length)%hs.length;document.getElementById('himg').src=hs[hi].i;document.getElementById('hcap').textContent=hs[hi].c;}
setInterval(function(){hgo(1);},4500);

/* TAB */
function swt(btn,id){
  document.querySelectorAll('.tbtn').forEach(function(b){b.classList.remove('on');b.style.background='#eee';b.style.color='#555';});
  btn.classList.add('on');btn.style.background='var(--red)';btn.style.color='#fff';
  ['lu','pp'].forEach(function(x){document.getElementById(x).style.display='none';});
  document.getElementById(id).style.display='block';
}

/* YOUTUBE */
function playYT(btn,vid){btn.parentElement.innerHTML='<iframe src="https://www.youtube.com/embed/'+vid+'?autoplay=1&rel=0" allowfullscreen allow="autoplay; encrypted-media"></iframe>';}

/* GALLERY */
function gs(id,d){var imgs=document.querySelectorAll('#'+id+' .gimg');var c=Array.from(imgs).findIndex(function(i){return i.classList.contains('on');});imgs[c].classList.remove('on');imgs[(c+d+imgs.length)%imgs.length].classList.add('on');}

/* NAV */
var nm=document.getElementById('nm'),ov=document.getElementById('navOverlay'),hb=document.querySelector('.hmbgr');
function openNav(){nm.classList.add('open');ov.classList.add('show');requestAnimationFrame(function(){ov.classList.add('visible');});hb.classList.add('active');hb.innerHTML='<i class="fa fa-times"></i>';document.body.style.overflow='hidden';}
function closeNav(){nm.classList.remove('open');ov.classList.remove('visible');setTimeout(function(){ov.classList.remove('show');},300);hb.classList.remove('active');hb.innerHTML='<i class="fa fa-bars"></i>';document.body.style.overflow='';document.querySelectorAll('.nm>li.mop').forEach(function(l){l.classList.remove('mop');});}
function toggleNav(){nm.classList.contains('open')?closeNav():openNav();}
document.querySelectorAll('.nm>li>a').forEach(function(a){a.addEventListener('click',function(e){if(window.innerWidth<=768){var dd=this.parentElement.querySelector('.dd');if(dd){e.preventDefault();e.stopPropagation();var li=this.parentElement,isOpen=li.classList.contains('mop');document.querySelectorAll('.nm>li.mop').forEach(function(x){x.classList.remove('mop');});if(!isOpen)li.classList.add('mop');}else{closeNav();}}});});
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeNav();});
window.addEventListener('scroll',function(){document.getElementById('btop').style.display=scrollY>300?'block':'none';});
/* DATE */
(function u(){
  var b=['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  var d=['রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার'];
  var m=['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
  var t=function(n){return String(n).replace(/\d/g,function(x){return b[x];});};
  var n=new Date(),h=n.getHours(),mi=n.getMinutes();
  var ap=h>=12?'অপরাহ্ন':'পূর্বাহ্ন';
  if(h>12)h-=12;if(h===0)h=12;
  document.getElementById('dtxt').textContent=d[n.getDay()]+', '+t(n.getDate())+' '+m[n.getMonth()]+' '+t(n.getFullYear())+', '+t(h)+':'+t(String(mi).padStart(2,'0'))+' '+ap;
  setTimeout(u,60000);
})();

/* TAB */
function swt(btn,id){
  document.querySelectorAll('.tbtn').forEach(function(b){b.classList.remove('on');b.style.background='#eee';b.style.color='#555';});
  btn.classList.add('on');btn.style.background='var(--red)';btn.style.color='#fff';
  ['lu','pp'].forEach(function(x){document.getElementById(x).style.display='none';});
  document.getElementById(id).style.display='block';
}

/* NAV */
var nm=document.getElementById('nm'),ov=document.getElementById('navOverlay'),hb=document.querySelector('.hmbgr');
function openNav(){nm.classList.add('open');ov.classList.add('show');requestAnimationFrame(function(){ov.classList.add('visible');});hb.classList.add('active');hb.innerHTML='<i class="fa fa-times"></i>';document.body.style.overflow='hidden';}
function closeNav(){nm.classList.remove('open');ov.classList.remove('visible');setTimeout(function(){ov.classList.remove('show');},300);hb.classList.remove('active');hb.innerHTML='<i class="fa fa-bars"></i>';document.body.style.overflow='';document.querySelectorAll('.nm>li.mop').forEach(function(l){l.classList.remove('mop');});}
function toggleNav(){nm.classList.contains('open')?closeNav():openNav();}
document.querySelectorAll('.nm>li>a').forEach(function(a){a.addEventListener('click',function(e){if(window.innerWidth<=768){var dd=this.parentElement.querySelector('.dd');if(dd){e.preventDefault();e.stopPropagation();var li=this.parentElement,isOpen=li.classList.contains('mop');document.querySelectorAll('.nm>li.mop').forEach(function(x){x.classList.remove('mop');});if(!isOpen)li.classList.add('mop');}else{closeNav();}}});});
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeNav();});
window.addEventListener('scroll',function(){document.getElementById('btop').style.display=scrollY>300?'block':'none';});