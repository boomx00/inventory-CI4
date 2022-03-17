<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<main class="flex-shrink-0">

<br><br><br>
<div class="stockCreateContainer">

  <div class="card">
      <div class="card-header">
          <h3>Data Sales</h3>
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
          <a href="<?= base_url('/sales/new'); ?>" class="btn btn-primary">Add New</a>
          <hr />
  <table class="table table-sm table-bordered table-striped"  id="mydatatable" cellspacing="0" width="100%" >
          <thead style="background-color: grey">
            <tr>
                <th  style="width:3%">No</th>
                <th  style="width:5%">Date</th>
                <th  style="width:5%">Order ID</th>
                <th  style="width:10%">Customer</th>
                <th  style="width:5%">Status-Bayar</th>
                <th  style="width:5%">Status-Transaksi</th>
                <th  style="width:5%">Cashier</th>
                <th style="width:5%">Total</th>
                <th style="width:5%">Paid</th>
                <th style="width:5%">Unpaid</th>

                <th style="width:10%">Action</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $no = 1;
            $color="";
            foreach ($sales as $row) {
            if($row->status == "lunas-cash"){
              $color = "green";
            }else{
              $color = "red";
            }
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row->date; ?></td>
                    <td><?= $row->order_id; ?></td>
                    <td><?= $row->customer; ?></td>
                    <td style="background-color:<?=$color?>"><?= $row->status; ?></td>
                    <td><?= $row->transaction; ?></td>
                    <td><?= $row->cashier; ?></td>
                    <td><?= $row->total; ?></td>
                    <td><?= $row->paid; ?></td>
                    <td><?= $row->unpaid; ?></td>

                    <td>
                      <?php
                      $id = $row -> order_id;
                      $linkedit =  base_url('/sales/edit/');
                      $linkdelete =  base_url('/sales/delete/');
                      $linkview = base_url('sales/view/');
                      $linkprint = base_url('test/test');
                        if(session()->get('role') == 'admin'){
                          
                          echo '<a class="btn btn-info" href="'.$linkedit."/".$id.'">Edit</a>
                          <a class="btn btn-info click" data-toggle="modal" data-target=".bd-example-modal-lg" href="'.$linkprint.'">Print</a>
                          <a class="btn btn-danger" href="'.$linkdelete."/".$id.'" onclick="return confirm("Apakah Anda yakin ingin menghapus data ?")">Delete</a>';
                        }else{
                          echo '<a class="btn btn-info click" data-toggle="modal" data-target=".bd-example-modal-lg" href="'.$linkedit."/".$id.'">View</a>';
                        }
                      ?>
                        <!-- <a class="btn btn-info click" data-toggle="modal" data-target=".bd-example-modal-lg" href="<?= base_url("sales/edit/$id"); ?>">Edit</a> -->
                        <!-- <a title="Delete" class="btn btn-danger" href="<?= base_url("sales/delete/$id") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?')">Delete</a> -->
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
          </div>

<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
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
// $('tr').on('dblclick', function() {
//     var codes = $(this).data('code');    // alert(code);
//     var name = $(this).data('name');
//     var price = $(this).data('price');
//     var stock = $(this).data('stock');
//     $('#code').val(codes);
//     $('#name').val(name);
//     $('#price').val(price);
//     $('#stock').val(stock);
//
//
//     $('#addModal').modal('show');
// });
$('.click').on('click', function() {
  // $('#editModal').modal('show');
// alert('yes');
});
</script>
</main>

<?= $this->endSection('content') ?>
