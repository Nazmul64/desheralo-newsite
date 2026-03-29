@extends('admin.master')
@section('content')

  <div class="content">

    <!-- TOP ROW -->
    <div class="top-row">
      <div class="hero-card">
        <div class="hero-txt">
          <div class="hero-big">16232</div>
          <div class="hero-sub">News Reader</div>
          <div class="hero-nums">
            <div><div class="hn-val blue">1</div><div class="hn-lbl">Subscriber User</div></div>
            <div><div class="hn-val orange">5</div><div class="hn-lbl">Free User</div></div>
          </div>
        </div>
        <div class="hero-illus">
          <div class="illus-box">
            <div class="ck t"><i class="fa fa-check" style="font-size:8px;"></i></div>
            <div class="brk-badge"><i class="fa fa-newspaper" style="font-size:11px;"></i> Breaking News</div>
            <div class="person-emoji">🧑‍💻</div>
            <div class="ck b"><i class="fa fa-check" style="font-size:8px;"></i></div>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="sc-bar blue"></div>
        <div class="sc-icon blue"><i class="fa fa-table-cells-large"></i></div>
        <div class="sc-num">8+</div><div class="sc-lbl">Feature Section</div>
      </div>
      <div class="stat-card">
        <div class="sc-bar red"></div>
        <div class="sc-icon red"><i class="fa fa-a"></i></div>
        <div class="sc-num">108+</div><div class="sc-lbl">Language</div>
      </div>
      <div class="stat-card">
        <div class="sc-bar green"></div>
        <div class="sc-icon green"><i class="fa fa-rectangle-ad"></i></div>
        <div class="sc-num">4+</div><div class="sc-lbl">Ads Space</div>
      </div>
      <div class="stat-card">
        <div class="sc-bar purple"></div>
        <div class="sc-icon purple"><i class="fa fa-grip"></i></div>
        <div class="sc-num">11+</div><div class="sc-lbl">Category</div>
      </div>
    </div>

    <!-- MID ROW -->
    <div class="mid-row">
      <div class="ns-col">
        <div class="ns-card">
          <div class="ns-ico orange"><i class="fa fa-newspaper"></i></div>
          <div><div class="ns-val">55</div><div class="ns-lbl">Published News</div></div>
        </div>
        <div class="ns-card">
          <div class="ns-ico teal"><i class="fa fa-file-lines"></i></div>
          <div><div class="ns-val">3</div><div class="ns-lbl">Draft News</div></div>
        </div>
        <div class="ns-card">
          <div class="ns-ico pink"><i class="fa fa-bolt"></i></div>
          <div><div class="ns-val">6</div><div class="ns-lbl">Breaking News</div></div>
        </div>
        <div class="ns-card">
          <div class="ns-ico violet"><i class="fa fa-pen-nib"></i></div>
          <div><div class="ns-val">0</div><div class="ns-lbl">Total Blogs</div></div>
        </div>
      </div>
      <div class="chart-card">
        <div class="cc-head">
          <span class="cc-title">User Statistic</span>
          <select class="yr-sel"><option>2026</option><option>2025</option><option>2024</option></select>
        </div>
        <div class="chart-h"><canvas id="userChart"></canvas></div>
      </div>
    </div>

    <!-- BOT ROW -->
    <div class="bot-row">
      <div class="panel">
        <div class="panel-hd">Most Viewed News</div>
        <div class="news-scroll">
          <div class="ni">
            <img class="ni-thumb" src="https://picsum.photos/seed/nw1/62/47" alt="">
            <div>
              <div class="ni-cat" style="color:#3b82f6;">Fashion</div>
              <div class="ni-title">Look of the Week: Black Essentials...</div>
              <div class="ni-meta"><span><i class="fa fa-eye"></i> 1195</span><span><i class="fa fa-comment"></i> 0</span></div>
            </div>
          </div>
          <div class="ni">
            <img class="ni-thumb" src="https://picsum.photos/seed/nw2/62/47" alt="">
            <div>
              <div class="ni-cat" style="color:#8b5cf6;">Politics</div>
              <div class="ni-title">The seven-member group takes oath...</div>
              <div class="ni-meta"><span><i class="fa fa-eye"></i> 976</span><span><i class="fa fa-comment"></i> 0</span></div>
            </div>
          </div>
          <div class="ni">
            <img class="ni-thumb" src="https://picsum.photos/seed/nw3/62/47" alt="">
            <div>
              <div class="ni-cat" style="color:#10b981;">Sports</div>
              <div class="ni-title">Champions League Final — Who Takes It?</div>
              <div class="ni-meta"><span><i class="fa fa-eye"></i> 842</span><span><i class="fa fa-comment"></i> 3</span></div>
            </div>
          </div>
          <div class="ni">
            <img class="ni-thumb" src="https://picsum.photos/seed/nw4/62/47" alt="">
            <div>
              <div class="ni-cat" style="color:#f97316;">Business</div>
              <div class="ni-title">Global markets react to new tariff policy</div>
              <div class="ni-meta"><span><i class="fa fa-eye"></i> 705</span><span><i class="fa fa-comment"></i> 1</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-hd">Latest Comments</div>
        <div class="no-comment">
          <i class="fa fa-comments"></i>
          <p>No comments yet</p>
        </div>
      </div>
      <div class="panel">
        <div class="panel-hd">Category Wise News</div>
        <div class="donut-h"><canvas id="catChart"></canvas></div>
        <div class="cat-leg" id="catLeg"></div>
      </div>
    </div>

  </div>

@endsection

