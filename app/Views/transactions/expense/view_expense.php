<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<main class="flex-shrink-0">

<br><br><br>
<div class="stockCreateContainer">
  <div class="card">
      <div class="card-header">
          <h3>Data Expense</h3>
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
          <a href="<?= base_url('/expense/new'); ?>" class="btn btn-primary">Tambah</a>
          <hr />
  <table class="table table-sm table-bordered table-paginate table-striped" id="mydatatable" cellspacing="0" width="100%">
          <thead style="background-color: grey">
            <tr>
                <th style="width:3%">No</th>
                <th style="width:6%">Date</th>
                <th style="width:30%">Category</th>
                <th style="width:10%">Amount</th>
                <th style="width:5%">Detail</th>
                <th  style="width:10%">Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $count = 1;
            foreach($expense as $x){            
          ?>
          <tr>
          <td><?= $count?></td>
          <td><?= $x['date']?></td>
          <td><?= $x['category']?></td>
          <td><?= $x['amount']?></td>
          <td><?= $x['detail']?></td>
          <td><a class="btn btn-info click" data-toggle="modal" data-target=".bd-example-modal-lg" href="<?=base_url('/expense/edit/'.$x['id'])?>">Edit</a>
          <a class="btn btn-danger" href="<?=base_url('/expense/delete/'.$x['id'])?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?')">Delete</a></td>
            </tr>



<?php
$count++;
}
?>
          </tbody>
      </table>
</div>
          </div>
          </div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control code" id="code" name="code">

        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control name" id="name" name="name">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control price" id="price" name="price">


        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control stock" id="stock" name="stock">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#mydatatable').DataTable();
</script>
<script>
$('tr').on('dblclick', function() {
    var codes = $(this).data('code');    // alert(code);
    var name = $(this).data('name');
    var price = $(this).data('price');
    var stock = $(this).data('stock');
    $('#code').val(codes);
    $('#name').val(name);
    $('#price').val(price);
    $('#stock').val(stock);


    $('#addModal').modal('show');
});

</script>

</main>
<?= $this->endSection('content') ?>
