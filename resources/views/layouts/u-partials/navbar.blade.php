 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item" style="margin-left: 15px;">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" href="#" title="Notifications">
        <i class="fas fa-bell"></i>
      </a>
    </li>

    <li class="nav-item" style="margin-right: 15px;">
      <a href="#" class="nav-link" data-toggle="modal" data-target="#contactModal" title="Customer Service">
        <i class="fas fa-headset"></i>
      </a>
    </li>
  </ul>
</nav>

  <!-- Modern Contact Modal (Subtle colors) -->
  <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content shadow-sm border-0 rounded-lg">
        <div class="modal-header bg-light text-dark border-0">
          <h5 class="modal-title" id="contactModalLabel">
            <i class="fas fa-headset mr-2"></i> Contact Support
          </h5>
          <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="media mb-4">
            <i class="fas fa-user-circle fa-3x text-secondary mr-3"></i>
            <div class="media-body">
              <h6 class="mt-0 mb-1 font-weight-bold text-dark">Muhammad Faris Irfan Bin Haneefa</h6>
              <small class="text-muted">Lead Contact Person</small>
            </div>
          </div>

          <div class="d-flex align-items-center mb-3">
            <i class="fas fa-envelope fa-lg text-danger mr-3"></i>
            <span class="text-dark">frshaneefa@enetech.com.my</span>
          </div>
          <div class="d-flex align-items-center">
            <i class="fas fa-phone fa-lg text-success mr-3"></i>
            <span class="text-dark">+60 11 3788 2324</span>
          </div>
        </div>
      </div>
    </div>
  </div>

<style>
  .modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .modal-header {
    border-bottom: none;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .modal-body {
    font-size: 15px;
  }

</style>