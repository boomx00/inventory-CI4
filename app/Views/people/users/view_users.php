<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<div class="container mb-3 mt-3" style="padding-top:5%;">
  <div class="card">
      <div class="card-header">
          <h3>Data User</h3>
      </div>
      <div class="card-body">
          <?php if (!empty(session()->getFlashdata('message'))) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo session()->getFlashdata('message'); ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <?php endif; ?>
          <a href="<?= base_url('/register'); ?>" class="btn btn-primary">Tambah</a>
          <hr />
          <table class="table table-bordered table-paginate" id="mydatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($user as $row) {
              ?>
                  <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $row->name; ?></td>
                      <td><?= $row->username; ?></td>
                      <td><?= $row->password; ?></td>
                      <td>
                          <a title="Edit" href="<?= base_url("users/edit/$row->id"); ?>" class="btn btn-info">Edit</a>
                          <a title="Delete" href="<?= base_url("users/delete/$row->id") ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?')">Delete</a>
                      </td>
                  </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
      </div>
  </div>
</div>
<script>
  $('#mydatatable').DataTable();
</script>
<?= $this->endSection('content') ?>
