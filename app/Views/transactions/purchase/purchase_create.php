<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
<script>
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">


  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Begin page content -->
    <main>
        <div class="stockCreateContainer">//this will determine the length
            <h1 class="mt-5">Create New Pembelian</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

           <form id="theform" method="post"  action="<?= base_url(); ?>/purchase/process/" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6">
           <div class="card">
                <div class="card-body">
                     <div style="margin-bottom:10px;">
            <label for="myDate" class="form-label">Date:</label>
            <input type="date" class="form-control" id="myDate" name="myDate" >
        </div>
        <div style="margin-bottom:10px;">
        <label for="code" class="form-label">Nomor Beli:</label>
        <input type="text" class="form-control" id="orderid" name="orderid" onchange="checkId(this)">
      </div>
                    
                     <div style="margin-bottom:10px;">
      <label for="supplier" class="form-label">Nama Pemasok:</label>
      <button type="button" class="btn btn-secondary btn-sm" id="click">
<i class="bi bi-search" id="click"></i>
            </button>
      <input type="text" class="form-control" id="supplier" name="supplier" onchange="" readonly>
      </div>


      <div>
      <label for="cashier" class="form-label">Kasir:</label>
      <select id="cashier" class="form-control" name="cashier">
      <?php
                    foreach ($employee->getResult() as $row) {
                    ?>
                       <option> <?=$row->firstname?></option>
                    <?php
                    }
                    ?>
            </select>
            </div>
                </div>
        </div>
        
      </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                      <div style="margin-bottom:10px;">
            <label for="name" class="form-label">No Polisi: </label>
            <input type="text" class="form-control" id="nopolice" name="nopolice">
        </div>
        <div class="row" style="margin-top:10px;">
      <label for="statuspayment" style="margin-bottom:10px; white-space: pre-wrap;" >Status Bayar:</label>
                <div class="col-sm-4">
      <select id="statuspayment" class="form-control" name="statuspayment">
        <option selected>lunas-cash</option>
        <option>bon-hutang</option>
      </select>
            </div>
            <div class="col-sm-3">
            <input type="number" class="form-control" id="hari" name="hari" placeholder="" >
            </div>
        </div>
        <div  style="margin-top:10px;">
      <label for="comment" style="margin-bottom:10px; white-space: pre-wrap;" >Detail Transaksi:</label>
      <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>
        </div>
                </div>
        </div>
        </div>
      </div>
      <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Transactions</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Photo</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <br>
  <div class="row"> 
               <table class="table table-bordered" id="myTable">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Product Code</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="tablebody">

  </tbody>
</table>
         <input type="hidden" class="form-control" id="accTotal" name="accTotal">
<div class="container">
  <div class="row">
    <div class="col text-center">
      <button type="button" class="btn btn-outline-secondary" id="addProduct" data-id="xx">Secondary</button>
    </div>
  </div>
</div>      
        </div>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div>
          <div class="input-field">
<!-- <label class="active">Photos</label> -->
<div class="input-images" style="padding-top: .5rem;"></div>
</div>
    </div>
        </div>
    </div>
        <br>
        
               
               <div class="row">
                 <div class="form-group row" style="margin-top:10px;">
    <label for="total" class="col-sm-10 col-form-label" style="text-align:right">Total:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="accTotals" name="accTotals" placeholder="" onchange="testbayar(this)">
      <input type="hidden" id="accHidden" name="accHidden">
    </div>
  </div>
  <div class="form-group row" style="margin-top:10px;">
    <label for="totBayar" class="col-sm-10 col-form-label" style="text-align:right">Total Bayar:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="totBayar" name="totBayar" placeholder="" onchange="testbayar(this)">
    </div>
  </div>
  <div class="form-group row" style="margin-top:10px;">
    <label for="sisa" class="col-sm-10 col-form-label" style="text-align:right">Sisa Bayar:</label>
    <div class="col-sm-2">
      <input type="number" class="form-control" id="sisa" name="sisa" placeholder="" >
    </div>
  </div>
               
               </div>
      <div class="mb-3">
          <button type="button" class="btn btn-primary" onclick="submitbutton()">Create</button>
      </div>
            </form>
            <hr />

        </div>

    <p id="demo"></p>
    </main>
    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-paginate" id="mydatatables" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                  </thead>

                  <tbody id="displayproduct">
                  <?php
                    $no = 1;
                    foreach ($supplier->getResult() as $row) {
                    ?>
                        <tr >
                            <td><?= $no++; ?></td>
                            <td id="codesup<?= $no; ?>" name="codesup"><?= $row->code; ?></td>
                            <td id="namesup<?= $no; ?>" name="namesup" ><?= $row->name; ?></td>
                            <td id="addresssup<?= $no; ?>" name="addresssup"><?= $row->address; ?></td>
                            <td>
                              <button type="submit" class="btn btn-primary" name="getProductCode" id="getProductCode" value="<?= $row->name; ?>" onclick="supplierTemp(this)">Select</button>
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
        <button type="button" class="btn btn-primary">Save changes</button>
      

      </div>
    </div>
  </div>
</div>
    <!-- CREATE PRODUCTS MODAL -->
    <!-- <form name="formm" onsubmit="return validateForm()" required> -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true" >
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
          <input type="hidden" class="form-control id" id="orderdate" name="orderdate">
          <input type="hidden" class="form-control id" id="ordercustomer" name="ordercustomer">

          <table class="table table-bordered table-paginate" id="mydatatables" cellspacing="0" width="100%">
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

                  <tbody id="displayproductt">
                  <?php
                    $no = 0;
                    foreach ($products->getResult() as $row) {
                    ?>
                        <tr data-code="<?=$row->code?>" data-name="<?=$row->name?>" data-price="<?=$row->price?>" data-stock="<?=$row->stock?>">
                            <td><?= $no++; ?></td>
                            <td id="code<?= $no; ?>" name="code" id="code"><?= $row->code; ?></td>
                            <td id="names<?= $no; ?>" name="names" ><?= $row->name; ?></td>
                            <td id="price<?= $no; ?>" name="price"><?= $row->price; ?></td>
                            <td id="stock<?= $no; ?>" name="stock"><?= $row->stock; ?></td>
                            <td>
                              <button type="submit" class="btn btn-primary" name="getProductCode" id="getProductCode" value="<?= $row->code; ?>" onclick="addTemp(this,<?= $no; ?>)">Select</button>
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
    <!-- </form> -->
<div id="testinger">aaaa</div>
<input type="hidden" value="0" id="index">
<script>
$(function () {
  $('.input-images').imageUploader({

  });
});
</script>
    <script>
      $('#mydatatables').DataTable();
    </script>
<script type="text/javascript">
var idarray = [];
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd ;
document.getElementById("myDate").value = today;
function keyip(objButton,index){
    document.getElementById("pricee"+index).value = document.getElementById("pricee"+index).value.replaceAll(/\D/g, "").replaceAll(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
$('#click').on('click',function(){
  $('#supplierModal').modal('show');

});

$('input').keyup(function(event) {
    if(event.target.id == 'orderid'){
      
      return
    }
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
      return value.replaceAll(/\D/g, "").replaceAll(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
  });
  $('#addProduct').on('click',function(){
    const x = document.getElementById("orderid").value;
    const orderDate = document.getElementById("myDate").value;
    const orderCustomer = document.getElementById("supplier").value;
    var i = "<?php  ?>";
    var orderid = document.getElementById("orderid").value;


        $('#idx').val(x);
    $('#ordercustomer').val(orderCustomer);
    $('#orderdate').val(orderDate);

    // alert(i);
    $('#createModal').modal('show');
    $.ajax({
      url : "<?php echo base_url("purchase/create/settable"); ?>",
                  type: "GET",
                  data: {id:i,orderid :orderid},
                  success: function(data)
                  {
                  // document.getElementById("quantity"+index).value = data;
                  // document.getElementById("testinger").innerHTML = data;
                  document.getElementById("displayproductt").innerHTML =  data;
      }
                })
});

function deleteFunction(objButton,index){
  var i = "<?php  ?>";
  var product = objButton.value;
  var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            product: product,
          };  
          $.ajax({
    url : "<?php echo base_url("purchase/create/deleterow"); ?>",
                type: "POST",
                data: dataJson, 
                dataType: "json",
                success: function(data)
                {
          
    }
              })

              $.ajax({
    url : "<?php echo site_url("/purchase/create/setmodal"); ?>",
                type: "GET",
                data: {},

                success: function(data)
                {
                    var str=data;
                     var res=str.split('!');
                    document.getElementById("tablebody").innerHTML =  res[0];
                    document.getElementById("accTotals").value = res[1];

                //   document.getElementById("total"+x).value = data.total;
                //   document.getElementById("accTotals").innerHTML = data.acctotal;

    }
              })
}
function testbayar(objButton){
  var ex = document.getElementById('accTotals').value;
var acctotal = ex.replaceAll(',','');
    var ex1 = document.getElementById("totBayar").value;
    var totbayar = ex1.replaceAll(',','');

var sisa = acctotal - totbayar;
    document.getElementById("sisa").value = sisa;
// alert(acctotal)


}
function checkId(objButton){
  var orderid = document.getElementById("orderid").value;
$.ajax({
  url : "<?php echo base_url("purchase/create/checkid"); ?>",
              type: "GET",
              data: {orderid:orderid},
              success: function(data)
              {
                if(data != ""){
                  alert ('ID Used!');
                }
  }
            })
}
function submitbutton(){
  var status = document.getElementById("statuspayment").value;
  var sisa = document.getElementById("sisa").value;
  var hari = document.getElementById("hari").value;

  var orderid = document.getElementById("orderid").value;
  var supplier = document.getElementById("supplier").value;

  if(status == "lunas-cash" && sisa!="0"){
    alert('Check Total Bayar dan Status');
  }else if(status == "bon-hutang" && sisa == 0){
    alert('Check Toyal Bayar dan Status')
  }else if(status == "bon-hutang" && (hari == "" || hari == "0")){
    alert('Check Status')
  }else if(sisa<0){
    alert('Check Nominal Pembayaran');
  }else if (orderid == "" || supplier == ""){
alert('Check ulang ID');
  }
    else{
    document.getElementById("theform").submit();
  }

}

function priceFunction(objButton,index){
//   var price = objButton.value;
  var price = document.getElementById("pricee"+index).value;
// alert(price);
  var product = document.getElementById("code"+index).innerHTML;
  var acctotal = 0;
    var orderid = document.getElementById("orderid").value;
    var quantity = document.getElementById("quantity"+index).value;
    var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            price: price, 
            product: product,
            quantity:quantity,
          };

          // alert(csrfHash);
  $.ajax({
    url : "<?php echo site_url("/purchase/create/pricetemp"); ?>",
                type: "GET",
                data: dataJson, 
                dataType: "json",
                success: function(data)
                {
                  document.getElementById("totalss"+index).value =data.total;
                  document.getElementById("quantity"+index).value =data.quantity;

                  document.getElementById("accTotals").value = data.acctotal;

    }
              })
//
}

function addTemp(objButton,index){
  var product = objButton.value;
  var name = document.getElementById("names"+index).innerHTML;
  var orderid = document.getElementById("orderid").value;
  var url = "<?php echo base_url('/sales/create/addtemp')?>";
  var i = "<?php  ?>";
// alert (index);
  var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            orderid: orderid,
            product: product,
            name:name
          };
// alert (name);
$.ajax({
    url : "<?php echo site_url("/purchase/create/tempajax"); ?>",
                type: "POST",
                data: dataJson, 
                dataType: "json",
                success: function(data)
                {
                //   alert(data); 
                //   document.getElementById("total"+x).value = data.total;
                //   document.getElementById("accTotals").innerHTML = data.acctotal;

    }
              })

              $.ajax({
    url : "<?php echo site_url("/purchase/create/setmodal"); ?>",
                type: "GET",
                data: {orderid:orderid},

                success: function(data)
                {
                    var str=data;
                     var res=str.split('!');
                    document.getElementById("tablebody").innerHTML =  res[0];
                    // document.getElementById("displayproduct").innerHTML = res[2];
                //   document.getElementById("total"+x).value = data.total;
                //   document.getElementById("accTotals").innerHTML = data.acctotal;

    }
              })
  // alert(parseInt(document.getElementById("index").value) + 1);
  $('#createModal').modal('hide');

}
function supplierTemp(objButton){
  document.getElementById("supplier").value =  objButton.value;

  $('#supplierModal').modal('hide');

}

</script>
    <?= $this->endSection('content') ?>
