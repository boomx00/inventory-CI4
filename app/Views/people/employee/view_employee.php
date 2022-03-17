<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<div class="container mb-3 mt-3" style="padding-top:5%;">
  <div class="card">
      <div class="card-header">
          <h3>Data Employees</h3>
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
          <a  class="btn btn-primary" id="create">Tambah</a>
          <hr />
          <table class="table table-bordered table-paginate" id="mydatatable" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Phone Number 1 </th>
                  <th>Phone Number 2 </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
              <?php
              $no = 1;
              foreach ($employee as $row) {
              ?>
                  <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $row->firstname; ?></td>
                      <td><?= $row->city; ?></td>
                      <td><?= $row->address; ?></td>
                      <td><?= $row->phoneone; ?></td>
                      <td><?= $row->phonetwo; ?></td>
                      <td>
                        <a href="#" class="btn btn-info btn-sm click" data-id="<?= $row->id ?>" data-fname="<?= $row->firstname;?>"  data-city="<?= $row->city?>" data-address="<?= $row->address?>" data-phoneone="<?= $row->phoneone?>" data-phonetwo="<?= $row->phonetwo?>">Edit</a>
                          <a title="Delete" href="<?= base_url("employee/delete/$row->id") ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?')">Delete</a>
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
<form name="formm" action="<?= base_url('/employee/updatedata/')?>" onsubmit="return validateForm()" required>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-top:10%">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Employee Data</h5>
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
      <input type="hidden" class="form-control id" id="id" name="id">

        <label for="fName" class="form-label">Name</label>
        <input type="text" class="form-control fName" id="fName" name="fName">

        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city">

        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address">

        <label for="phoneone" class="form-label">Phone Number 1</label>
        <input type="text" class="form-control" id="phoneone" name="phoneone">

        <label for="phonetwo" class="form-label">Phone Number 2</label>
        <input type="text" class="form-control" id="phonetwo" name="phonetwo">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary setupdate">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>

<form name="formm" action="<?= base_url('/employee/create/')?>" onsubmit="return validateForm()" required>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-top:10%">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Employee Data</h5>
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
      <input type="hidden" class="form-control id" id="id" name="id">

        <label for="fName" class="form-label"> Name</label>
        <input type="text" class="form-control fName" id="fName" name="fName">

        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city">

        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address">

        <label for="phoneone" class="form-label">Phone Number 1</label>
        <input type="text" class="form-control" id="phoneone" name="phoneone">

        <label for="phonetwo" class="form-label">Phone Number 2</label>
        <input type="text" class="form-control" id="phonetwo" name="phonetwo">
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
  $('#mydatatable').DataTable();
</script>
<script>
$(document).ready(function(){

$(".click").on("click", function(){


  const id = $(this).data('id');
  const fName = $(this).data('fname');
  const lName = $(this).data('lname');
  const city = $(this).data('city');
  const address = $(this).data('address');
  const phoneone = $(this).data('phoneone');
  const phonetwo = $(this).data('phonetwo');


  $('#id').val(id);
  $('#fName').val(fName);
  $('#lName').val(lName);
  $('#city').val(city);
  $('#address').val(address);
  $('#phoneone').val(phoneone);
  $('#phonetwo').val(phonetwo);

  $('#editModal').modal('show');
});

$(".setupdate").on("click",function(){
  var fname = document.forms["formm"]['fName'].value;
  var phoneone = document.forms["formm"]['phoneone'].value;
  if(fname == '' || phoneone == ''){
    alert ('First Name and Phone Numbers cannot be empty');
    return false;
  }
})

$("#create").on("click",function(){
  $('#createModal').modal('show');
})
});
</script>
<?= $this->endSection('content') ?>
