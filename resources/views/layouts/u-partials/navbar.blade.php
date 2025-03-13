  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" data-toggle="modal" data-target="#contactModal">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>

  <!-- Updated Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white text-center">
        <h5 class="modal-title w-100" id="contactModalLabel">Contact Information</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center mb-3">
          <i class="fas fa-user-circle fa-3x text-primary mr-3"></i>
          <div>
            <h6 class="mb-0">MUHAMMAD FARIS IRFAN BIN HANEEFA</h6>
            <small>Lead Contact Person</small>
          </div>
        </div>
        <div class="d-flex align-items-center mb-2">
          <i class="fas fa-envelope fa-lg text-danger mr-3"></i>
          <p class="mb-0">frshaneefa@enetech.my</p>
        </div>
        <div class="d-flex align-items-center mb-2">
          <i class="fas fa-envelope fa-lg text-danger mr-3"></i>
          <p class="mb-0">frshaneefa@gmail.com</p>
        </div>
        <div class="d-flex align-items-center mb-2">
          <i class="fas fa-phone fa-lg text-success mr-3"></i>
          <p class="mb-0">+601137882324</p>
        </div>
      </div>
    </div>
  </div>
</div>
