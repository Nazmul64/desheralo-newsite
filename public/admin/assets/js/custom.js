/* ── SIDEBAR ── */
function openSB(){document.getElementById('sidebar').classList.add('open');document.getElementById('sbOverlay').classList.add('show');document.body.style.overflow='hidden';}
function closeSB(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sbOverlay').classList.remove('show');document.body.style.overflow='';}

/* ── SIDEBAR DROPDOWN ── */
function toggleDD(el){
  var dd=el.nextElementSibling;
  var wasOpen=dd.classList.contains('open');
  document.querySelectorAll('.nav-dd.open').forEach(function(d){d.classList.remove('open');d.previousElementSibling.classList.remove('dd-open');});
  if(!wasOpen){dd.classList.add('open');el.classList.add('dd-open');}
}

/* ── AVATAR DROPDOWN ── */
function toggleAvDD(e){
  e.stopPropagation();
  document.getElementById('avDropdown').classList.toggle('show');
}
function closeAvDD(){
  document.getElementById('avDropdown').classList.remove('show');
}
document.addEventListener('click',function(e){
  var wrap=document.getElementById('avWrap');
  if(wrap && !wrap.contains(e.target)){
    var dd=document.getElementById('avDropdown');
    if(dd) dd.classList.remove('show');
  }
});
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeAvDD();});

/* ── BAR CHART ── */
// FIX: null-check — admanager/other pages তে এই canvas নেই
var userChartEl = document.getElementById('userChart');
if (userChartEl) {
  new Chart(userChartEl.getContext('2d'),{
    type:'bar',
    data:{
      labels:['Jan','Feb','March','April','May','June','July','Aug','Sep','Oct','Nov','Dec'],
      datasets:[
        {label:'Free User:5',data:[0,4,1.7,0,0,0,0,0,0,0,0,0],backgroundColor:'#3b82f6',borderRadius:5,barPercentage:.4,categoryPercentage:.7},
        {label:'Subscribed:1',data:[0,.4,1,0,0,0,0,0,0,0,0,0],backgroundColor:'#f97316',borderRadius:5,barPercentage:.4,categoryPercentage:.7}
      ]
    },
    options:{
      responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',align:'end',labels:{usePointStyle:true,pointStyle:'circle',font:{size:11},color:'#6b7280',padding:18,boxWidth:8}}},
      scales:{
        x:{grid:{display:false},ticks:{font:{size:10},color:'#9ca3af'},border:{display:false}},
        y:{min:0,max:4,ticks:{stepSize:.5,callback:function(v){return'$'+v.toFixed(2);},font:{size:10},color:'#9ca3af'},grid:{color:'#f3f4f6'},border:{display:false}}
      }
    }
  });
}

/* ── DONUT CHART ── */
// FIX: null-check — admanager/other pages তে এই canvas নেই
var catChartEl = document.getElementById('catChart');
if (catChartEl) {
  var cL=['Business','Sports','Lifestyle','Politics','Entertainment','Technology'];
  var cC=['#3b82f6','#10b981','#22c55e','#ef4444','#eab308','#6366f1'];
  new Chart(catChartEl.getContext('2d'),{
    type:'doughnut',
    data:{labels:cL,datasets:[{data:[28,18,15,12,14,13],backgroundColor:cC,borderWidth:3,borderColor:'#fff',hoverOffset:8}]},
    options:{
      responsive:true,maintainAspectRatio:false,
      cutout:'58%',rotation:-Math.PI,circumference:Math.PI,
      plugins:{legend:{display:false},tooltip:{callbacks:{label:function(c){return' '+c.label+': '+c.parsed+'%';}}}}
    }
  });
  var leg=document.getElementById('catLeg');
  if(leg){
    cL.forEach(function(l,i){var d=document.createElement('div');d.className='cl-item';d.innerHTML='<span class="cl-dot" style="background:'+cC[i]+'"></span>'+l;leg.appendChild(d);});
  }
}
