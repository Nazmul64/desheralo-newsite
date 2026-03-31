<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <span class="sb-logo-mark">//·</span>
    <span class="sb-logo-text">MAAN</span>
  </div>
  <nav class="sb-nav">

    <a class="nav-row active" href="#">
      <div class="nav-left"><span class="nav-ico ic-db"><i class="fa fa-gauge"></i></span> Dashboard</div>
    </a>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-um"><i class="fa fa-users"></i></span> User Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">All Users</a>
      <a href="#">Subscriber Users</a>
      <a href="#">Free Users</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-nm"><i class="fa fa-newspaper"></i></span> News Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="{{ route('newscategories.index') }}">News Category</a>
      <a href="{{ route('newssubcategories.index') }}">News Sub-Category</a>
      <a href="{{ route('speciality.index') }}">News Speciality</a>
      <a href="#">All News</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-md"><i class="fa fa-photo-film"></i></span> Media</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">Photo Gallery</a>
      <a href="#">Video Gallery</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-bl"><i class="fa fa-blog"></i></span> Blog Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">Blog Category</a>
      <a href="#">Blog Sub-Category</a>
      <a href="#">Blog List</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-nr"><i class="fa fa-id-badge"></i></span> News Reporters</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">All Reporters</a>
      <a href="#">Add Reporter</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-cm"><i class="fa fa-address-book"></i></span> Contact Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">Contact Messages</a>
      <a href="#">Subscribers</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-cs"><i class="fa fa-layer-group"></i></span> CMS Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">Header</a>
      <a href="#">Footer</a>
      <a href="#">Manage Page</a>
      <a href="#">SEO Report</a>
      <a href="#">Social Share</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-am"><i class="fa fa-bullhorn"></i></span> Ads Manage</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">All Ads</a>
      <a href="#">Add New Ad</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-rp"><i class="fa fa-shield-halved"></i></span> Roles &amp; Permissions</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">All Roles</a>
      <a href="#">Permissions</a>
    </div>

    <div class="nav-row" onclick="toggleDD(this)">
      <div class="nav-left"><span class="nav-ico ic-st"><i class="fa fa-gear"></i></span> Settings</div>
      <i class="fa fa-chevron-right nav-arrow"></i>
    </div>
    <div class="nav-dd">
      <a href="#">Site Settings</a>
      <a href="#">Company Info</a>
      <a href="#">Theme Settings</a>
      <a href="#">Theme Color</a>
      <a href="#" style="justify-content:space-between;padding-right:16px;">
        Notifications <span class="new-badge">New</span>
      </a>
      <a href="#">System Settings</a>
      <a href="#">Login Page Settings</a>
    </div>

  </nav>
</aside>
