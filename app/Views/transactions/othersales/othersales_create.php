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
            <h1 class="mt-5">Create New Other Sales</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

           <form method="post"  action="<?= base_url(); ?>/othersales/create/" enctype="multipart/form-data">
                <?= csrf_field(); ?>
      
              
    

    <br>
    <div class="row">
        <div class="col-sm-6">
           <div class="card">
                <div class="card-body">
                     <div style="margin-bottom:10px;">
            <label for="date" class="form-label">Date:</label>
            <div class="row"> 
            <div class="col-sm-5">
            <input type="date" class="form-control" id="date" name="date" >
            </div>
            </div>
        </div>
        <div style="margin-bottom:10px;">
        <div class="row">
        <div class="col-sm-5">
        <label for="category" class="form-label">Category:</label>
        <input type="text" class="form-control" id="category" name="category" onchange="">
        </div>
        </div>
      </div>
                    
                     <div style="margin-bottom:10px;">
      <label for="amount" class="form-label">Amount:</label>
      <input type="number" class="form-control" id="amount" name="amount" onchange="">

      </div>


      <div>
      <div  style="margin-top:10px;">
      <label for="comment" style="margin-bottom:10px; white-space: pre-wrap;" >Detail Transaksi:</label>
      <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>
        </div>
            </div>
                </div>
        </div>
        
      </div>
        <div class="col-sm-6">
           
      </div>
            </div>
    <br>
    <hr>
      <div> <h3> Photos </h3></div>
          <div class="input-field">
<!-- <label class="active">Photos</label> -->
<div class="input-images" style="padding-top: .5rem;"></div>
        </div>
        <br>
        
               
              
      <div class="mb-3">
          <button type="submit" class="btn btn-primary" id="submitbutton">Create</button>
      </div>
            </form>
            <hr />

        </div>

    <p id="demo"></p>
    </main>
  
    <!-- </form> -->
<div id="testinger">aaaa</div>
<input type="hidden" value="0" id="index">
<script>
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd ;
todaystring = yyyy + mm  + dd ;
document.getElementById("date").value = today;
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

$('#click').on('click',function(){
  $('#supplierModal').modal('show');

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
                  document.getElementById("displayproduct").innerHTML =  data;
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
    var acctotal = document.getElementById("accTotals").value;
    var totbayar = document.getElementById("totBayar").value;
var sisa = acctotal - totbayar;
    document.getElementById("sisa").value = sisa;
// alert(acctotal)


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
// alert (product);
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
