<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"></a>
  @auth
  {{ Auth::user()->email }}
  @endauth
  <div class="menu">    
    <a href="">
      <i class="fa fa-calendar-check-o"></i>
    </a>
    <a href="">
      <i class="fa fa-user"></i>
    </a>
  </div>
</nav>