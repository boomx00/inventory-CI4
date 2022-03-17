<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
<?php $id = "aa" ;?>

  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="stockCreateContainer">
            <h1 class="mt-5">Create New Sales</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url(); ?>/stock/process">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6"><div class="mb-3">
            <label for="code" class="form-label">Order ID</label>
            <input type="text" class="form-control" id="orderid" name="orderid" value="<?= $order->order_id ?>">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Customer</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
      </div>
        <div class="col-sm-6">
          <div class="mb-3">
              <label for="price" class="form-label">Date</label>
              <input type="text" class="form-control" id="price" name="price">
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-sm-12" >
          <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Code</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
<div class="container">
  <div class="row">
    <div class="col text-center">
      <button type="button" class="btn btn-outline-secondary" id="addProduct" data-id="xx">Secondary</button>
    </div>
  </div>
</div>
        </div>
      </div>
      <div class="mb-3">
          <button type="submit" class="btn btn-primary">Create</button>
</button>
      </div>
            </form>
            <hr />

        </div>
    </main>

    <form name="formm" action="<?= base_url('/sales/temp/')?>" onsubmit="return validateForm()" required>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product Data</h5>
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
          <input type="hidden" class="form-control id" id="idx" name="idx">
          <table class="table table-bordered table-paginate" id="mydatatable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($products as $row) {
                    ?>
                        <tr data-code="<?=$row->code?>" data-name="<?=$row->name?>" data-price="<?=$row->price?>" data-stock="<?=$row->stock?>">
                            <td><?= $no++; ?></td>
                            <td id="code" name="code"><?= $row->code; ?></td>
                            <td id="names" name="names" ><?= $row->name; ?></td>
                            <td id="price" name="price"><?= $row->price; ?></td>
                            <td id="stock" name="stock"><?= $row->stock; ?></td>
                            <td>
                              <button type="submit" class="btn btn-primary" name="xx" id="xx" value="<?= $row->code; ?>">Select</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                  </tbody>
              </table>


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

  $('#addProduct').on('click',function(){
    const x = document.getElementById("orderid").value;
    if(x==""){
      alert ('fill in order ID first');
    }else{
    // const x = document.getElementById("orderid").value;

    $('#idx').val(x);
    $('#createModal').modal('show');
  }
  })
});
</script>
    <?= $this->endSection('content') ?>
