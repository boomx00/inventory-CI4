<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<main class="flex-shrink-0">

<br><br><br>
<div class="stockCreateContainer">
  <div class="card">
      <div class="card-header">
          <h3>Data Barang</h3>
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
          <a href="<?= base_url('/stock/create'); ?>" class="btn btn-primary">Tambah</a>
          <hr />
  <table class="table table-bordered table-paginate" id="mydatatable" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:6%">Code</th>
                <th style="width:30%">Name</th>
                <th style="width:10%">Price</th>
                <th style="width:5%">Stock</th>
                <th  style="width:10%">Action</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $no = 1;
            foreach ($stock as $row) {
            ?>
                <tr data-code="<?=$row->code?>" data-name="<?=$row->name?>" data-price="<?=$row->price?>" data-stock="<?=$row->stock?>">
                    <td><?= $no++; ?></td>
                    <td><?= $row->code; ?></td>
                    <td><?= $row->name; ?></td>
                    <td><?= $row->price; ?></td>
                    <td><?= $row->stock; ?></td>
                    <td>
                      <a href="<?= base_url('/stock/edit/')."/".$row->code; ?>" class="btn btn-info btn-sm click">Edit</a>
                        <a title="Delete" href="<?= base_url('/stock/delete/')."/".$row->code;?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?')">Delete</a>
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
