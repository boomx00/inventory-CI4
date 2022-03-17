<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <!-- Begin page content -->
      <main class="flex-shrink-0">
          <div class="container">
              <h1 class="mt-5">Edit Data</h1>
              Silahkan Daftarkan Identitas Anda
              <hr />
              <?php if (!empty(session()->getFlashdata('error'))) : ?>
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <h4>Periksa Entrian Form</h4>
                      </hr />
                      <?php echo session()->getFlashdata('error'); ?>
                  </div>
              <?php endif; ?>
              <?php if (!empty(session()->getFlashdata('message'))) : ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?php echo session()->getFlashdata('message'); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              <?php endif; ?>
              <form method="post" action="<?= base_url('/users/update/'.$users->id); ?>">
                  <?= csrf_field(); ?>
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?= $users->username; ?>">
                  </div>
                  <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="<?= $users->name ?>">
                  </div>
                  <div class="mb-3">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="#" class="btn btn-info btn-sm" id="click" data-id="<?=$users->id?>">Edit</a>
  </button>

                  </div>
              </form>
              <hr/>

          </div>


          <!-- Modal -->
          <form action="<?= base_url('/users/updatepassword/')?>">
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <?php if (!empty(session()->getFlashdata('errorr'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <h4>Periksa Entrian Form</h4>
                          </hr />
                          <?php echo session()->getFlashdata('errorr'); ?>
                      </div>
                  <?php endif; ?>
                <input type="hidden" class="form-control theid" id="theid" name="theid">
                  <label for="opassword" class="form-label">Original Password</label>
                  <input type="text" class="form-control" id="opassword" name="opassword">

                  <label for="opassword" class="form-label">New Password</label>
                  <input type="text" class="form-control" id="npassword" name="npassword">

                  <label for="opassword" class="form-label">Confirm New Password</label>
                  <input type="text" class="form-control" id="password_conf" name="password_conf">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </form>

          <script>
          $(document).ready(function(){

    $("#click").on("click", function(){
      const id = $(this).data('id');
       $('.theid').val(id);
    $('#exampleModal').modal('show');
    });
  });
</script>

  <?= $this->endSection('content') ?>
