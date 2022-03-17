<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
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

            <form method="post">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6"><div class="mb-3">
            <label for="code" class="form-label">Order ID</label>
            <input type="text" class="form-control" id="orderid" name="orderid" value="<?= $sales->order_id ?>">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Customer</label>
            <input type="text" class="form-control" id="customer" name="customer" value="<?= $sales->customer ?>">
        </div>
      </div>
        <div class="col-sm-6">
          <div class="mb-3">
              <label for="price" class="form-label">Date</label>
              <input type="text" class="form-control" id="date" name="date" value="<?= $sales->date ?>">
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-sm-12" >
          <table class="table table-bordered" id="myTable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Code</th>
      <th scope="col">Product Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($transactions as $row) {
    ?>
        <tr>
          <td><?= $no; ?></td>
            <td id="code<?= $no ?>" name="code<?= $no ?>"><?= $row->product_code; ?></td>
            <td id="prodname<?= $no ?>" name="prodname<?= $no ?>"><?= $row->product_name; ?></td>
            <td id="price<?= $no ?>" name="price<?= $no ?>"><?= $row->price; ?></td>
            <td id="quantity<?= $no ?>" name="quantity<?= $no ?>"><?= $row->quantity; ?></td>
            <td id="totalamount<?= $no ?>"><?= $row->total; ?></td>

            <?php $no++; ?>

        </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<input type="hidden" class="form-control" id="accTotal" name="accTotal">

<div class="container">
  <div class="row">
  <div class="col-sm-10" style="text-align:right">Total:</div>
  <div class="col-sm-2" id="accTotals" name="accTotals"></div>
  </div>
</div>
        </div>
      </div>
      <div class="mb-3">
          <button type="submit" class="btn btn-primary">Back</button>
</button>
      </div>
            </form>
            <hr />

        </div>

    <p id="demo"></p>
    </main>


    <script>
      $('#mydatatable').DataTable();
    </script>
<script>
$(document).ready(function(){
   var acctotal = 0;
  var tablelength = document.getElementById("myTable").rows.length;
  // alert(tablelength);
  for (var i = 1; i<tablelength ;i++){
      var total = document.getElementById("totalamount"+i).innerHTML;
    var acctotal = acctotal + total ;
  // alert(i);
  if(i==tablelength-1){
    break;
  }}
  document.getElementById('accTotals').innerHTML = total;

});


</script>
    <?= $this->endSection('content') ?>
