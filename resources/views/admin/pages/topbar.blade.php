  <header class="topbar">
    <div class="tb-left">
      <button class="hmbgr" onclick="openSB()"><i class="fa fa-bars"></i></button>
      <button class="view-btn"><i class="fa fa-globe"></i> View Website</button>
    </div>

    <div class="tb-right">
      <!-- Language -->
      <div class="lang-sel">
        <span style="font-size:17px;">🇺🇸</span>
        <span style="font-size:13px;color:#4b5563;">English</span>
        <i class="fa fa-chevron-down chevron" style="font-size:10px;opacity:.6;margin-left:2px;"></i>
      </div>

      <!-- Notification -->
      <div class="notif-wrap">
        <button class="notif-btn">
          <i class="fa fa-bell"></i>
          <span class="n-badge">7</span>
        </button>
      </div>

      <!-- ★ AVATAR + DROPDOWN ★ -->
      <div class="av-wrap" id="avWrap">
        <button class="av-btn" onclick="toggleAvDD(event)" title="Account">
          <img src="https://picsum.photos/seed/adminav/38/38" alt="Admin">
        </button>

        <!-- Dropdown -->
        <div class="av-dropdown" id="avDropdown">
          <a href="#" class="av-dd-item" onclick="closeAvDD()">
            <i class="fa fa-rotate-right"></i>
            Clear cache
          </a>
          <a href="#" class="av-dd-item" onclick="closeAvDD()">
            <i class="fa fa-circle-user"></i>
            My Profile
          </a>
          <div class="av-dd-sep"></div>
          <a href="#" class="av-dd-item logout" onclick="closeAvDD()">
            <i class="fa fa-right-from-bracket"></i>
            Logout
          </a>
        </div>
      </div>
    </div>
  </header>
