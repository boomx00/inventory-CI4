<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Begin page content -->
    <main>
        <div class="stockCreateContainer">//this will determine the length
            <h1 class="mt-5">Create New Sales</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

           <form method="post" action="<?= base_url(); ?>/sales/process" id="theform">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6">
           <div class="card">
                <div class="card-body">
                     <div style="margin-bottom:10px;">
            <label for="price" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div style="margin-bottom:10px;">
        <label for="code" class="form-label">Order ID:</label>
        <input type="text" class="form-control" id="orderid" name="orderid" onchange="checkId(this)">
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
            <label for="name" class="form-label">Customer </label>
            <input type="text" class="form-control" id="customer" name="customer">
        </div>
        <div style="margin-top:10px;">
      <label for="comment" style="margin-bottom:10px; white-space: pre-wrap;" >Detail:</label>
      <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>
        </div>
                    
                </div>
        </div>
        </div>
      </div>
               
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
               
               <div class="row">
                 <div class="form-group row" style="margin-top:10px;">
    <label for="total" class="col-sm-10 col-form-label" style="text-align:right">Total:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="accTotals" name="accTotals" placeholder="">
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
      <input type="number" class="form-control" id="sisa" name="sisa" placeholder="">
    </div>
  </div>
               
               </div>
      <div class="mb-3">
      <button type="button" class="btn btn-primary" onclick="submitbutton()">Create</button>

          <!-- <button type="submit" class="btn btn-primary" >Create</button> -->

      </div>

                <!-- <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="password_conf" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_conf" name="password_conf">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div> -->
            </form>
            <hr />

        </div>

    <p id="demo"></p>
    </main>

    <!-- CREATE PRODUCTS MODAL -->
    <!-- <form name="formm" onsubmit="return validateForm()" required> -->
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
          <input type="hidden" class="form-control id" id="orderdate" name="orderdate">
          <input type="hidden" class="form-control id" id="ordercustomer" name="ordercustomer">

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

                  <tbody id="displayproduct">
                    <?php
                    $no = 1;
                    foreach ($products->getResult() as $row) {
                    ?>
                        <tr data-code="<?=$row->code?>" data-name="<?=$row->name?>" data-price="<?=$row->price?>" data-stock="<?=$row->stock?>">
                            <td><?= $no++; ?></td>
                            <td id="code" name="code" id="code"><?= $row->code; ?></td>
                            <td id="names" name="names" ><?= $row->name; ?></td>
                            <td id="price" name="price"><?= $row->price; ?></td>
                            <td id="stock" name="stock"><?= $row->stock; ?></td>
                            <td>
                              <button type="submit" class="btn btn-primary" name="getProductCode" id="getProductCode" value="<?= $row->code; ?>" onclick="testFunction(this)">Select</button>
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
    <input type="text" name= "name1" id="id2">

    <!-- </form> -->
<div id="testinger">aaaa</div>
<input type="hidden" value="0" id="index">
    <script>
      $('#mydatatable').DataTable();
    </script>
<script type="text/javascript">
var idarray = [];
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd ;
todaystring = yyyy + mm  + dd ;
document.getElementById("date").value = today;
document.getElementById("orderid").value = "SM"+todaystring+".";

function submitbutton(){
  var status = document.getElementById("statuspayment").value;
  var sisa = document.getElementById("sisa").value;
  var hari = document.getElementById("hari").value;


  if(status == "lunas-cash" && sisa!="0"){
    alert('Check Total Bayar dan Status');
  }else if(status == "bon-hutang" && sisa == 0){
    alert('Check Toyal Bayar dan Status')
  }else if(status == "bon-hutang" && (hari == "" || hari == "0")){
    alert('Check Status')
  }else if(sisa<0){
    alert('Check Nominal Pembayaran');
  }else if (orderid == ""){
alert('Check ulang ID');
  }
    else{
    document.getElementById("theform").submit();
  }

}
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
  function keyip(objButton,index){
    document.getElementById("prices"+index).value = document.getElementById("prices"+index).value.replaceAll(/\D/g, "").replaceAll(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
$(document).ready(function(){

  

  $('#addProduct').on('click',function(){
    const x = document.getElementById("orderid").value;
    const orderDate = document.getElementById("date").value;
    const orderCustomer = document.getElementById("customer").value;
    var i = "<?php  ?>";
    var orderid = document.getElementById("orderid").value;


if(x==""){
  alert('fill order id first');
}else{
    $('#idx').val(x);
    $('#ordercustomer').val(orderCustomer);
    $('#orderdate').val(orderDate);

    // alert(i);
    $('#createModal').modal('show');
    $.ajax({
      url : "<?php echo base_url("sales/create/settable"); ?>",
                  type: "GET",
                  data: {id:i,orderid :orderid},
                  success: function(data)
                  {
                  // document.getElementById("quantity"+index).value = data;
                  // document.getElementById("testinger").innerHTML = data;
                  document.getElementById("displayproduct").innerHTML =  data;


      }
                })
              }
  })

  $('#test').click(function(){
//     var x = document.getElementById('quantity1').value;
//     var z = document.getElementById('quantity2').value;
// var tablelength = document.getElementById("myTable").rows.length;
//     alert(tablelength);
    // var quantity = document.getElementById('quantity').value;
    //
    // var total = x * quantity;
    // document.getElementById('totalvalue').innerHTML= total;
    // alert (total);
  })


});


function tryfunction(objButton){

  alert('yes');
}
function testbayar(objButton){
var totalbayar = objButton.value;
var totbayar = totalbayar.replaceAll(',','');
var ex = document.getElementById('accTotals').value;
var total = ex.replaceAll(',','');
// alert(ex);
var sisa = total - totbayar;

document.getElementById('sisa').value = sisa;
}

function checkId(objButton){
var id = objButton.value;
var originalid= "";
var newid = "";
if(idarray.length==0 ){
  // alert('yes');
  idarray.push(id);
};
if(idarray.length==1 ){
  originalid = idarray[0];
};
if(id != originalid){
  idarray.push(id);
  newid=idarray[1];
}
// for (i = 0; i < idarray.length; i++) {
// console.log(idarray[i]);
// }

// alert (newid);
$.ajax({
  url : "<?php echo base_url("sales/create/checkid"); ?>",
              type: "GET",
              data: {originalid:originalid, newid:newid},
              success: function(data)
              {
                if(data=='false'){
                  alert('id exist');
                  document.getElementById("orderid").value = "";
                }
                if(data == 'true'){
                  idarray[0] = newid;
                  idarray.pop();
              }
// document.getElementById("tablebody").innerHTML +=  data;
// document.getElementById("tablebody").innerHTML =  data;

// document.getElementById("index").value = data;
  }
            })
}

function deleteFunction(objButton){
  var i = "<?php  ?>";
  var code = objButton.value;
  $.ajax({
    url : "<?php echo base_url("sales/create/deleterow"); ?>",
                type: "GET",
                data: {code: code, id:i},
                success: function(data)
                {
                  var str=data;
              var res=str.split('!');
                  // document.getElementById("testinger").innerHTML = data;
// document.getElementById("tablebody").innerHTML +=  data;
document.getElementById("tablebody").innerHTML =  res[0];
document.getElementById("accTotals").value = res[1];

// document.getElementById("index").value = data;
    }
              })
}
function myFunction(objButton, index) {
  var i = "<?php  ?>";
  var acctotal = 0;
  var quantity = objButton.value;
var product = document.getElementById("code"+index).innerHTML;
var tablelength = document.getElementById("myTable").rows.length;
var total = quantity * document.getElementById('price'+index).innerHTML;
var acctotal;
$.ajax({
  url : "<?php echo base_url("sales/create/qtytemp"); ?>",
              type: "GET",
              data: {quantity: quantity, id:i, product: product,total: total},
              success: function(data)
              {
              var str=data;
              var res=str.split('n');
              acctotal = res[0];
              // alert (res[1]);
              // document.getElementById("testinger").innerHTML = data;

              document.getElementById("totalamounts"+index).value = res[0];
              document.getElementById("accTotals").value = res[1];
              // //
              // document.getElementById("accHidden").value= res[1];

  }
            })

}

function priceFunction(objButton,index){
  var ex = objButton.value;
  var price = ex.replaceAll(',','');

  var product = document.getElementById("code"+index).innerHTML;
  var acctotal = 0;
    var orderid = document.getElementById("orderid").value;
    var quantity = document.getElementById("quantity"+index).value;
    
   
$.ajax({
  url : "<?php echo base_url("sales/create/pricetemp"); ?>",
              type: "GET",
              data: {price:price, product:product, orderid:orderid,quantity:quantity},
              success: function(data)
              {
                // document.getElementById("testinger").innerHTML = data;

              var str=data;
              var res=str.split('!');
              acctotal = res[0];
              // alert (res[1]);
              //
              document.getElementById("totalamounts"+index).value = res[0];
              document.getElementById("accTotals").value = res[1];
              //
              // document.getElementById("accHidden").value= res[0];

  }
            })
}

function testFunction(objButton){
  var thisProdCode = objButton.value;
  var mydatatablelength = document.getElementById("mydatatable").rows.length;
  var orderid = document.getElementById("orderid").value;
  var date = document.getElementById("date").value;
  var customer = document.getElementById("customer").value;
  var url = "<?php echo base_url('/sales/create/addtemp')?>";
  var i = "<?php  ?>";
  var index = parseInt(document.getElementById("index").value);

// alert (orderid);
  $.ajax({
    url : "<?php echo base_url("sales/create/addtemp"); ?>",
                type: "GET",
                data: {prodcode: thisProdCode, id:i, orderid: orderid, customer: customer,date:date},
                success: function(data)
                {
                  // document.getElementById("testinger").innerHTML = data;
// document.getElementById("tablebody").innerHTML +=  data;
document.getElementById("tablebody").innerHTML =  data;

// document.getElementById("index").value = data;
    }
              })
  // alert(parseInt(document.getElementById("index").value) + 1);
  $('#createModal').modal('hide');

}

</script>
    <?= $this->endSection('content') ?>
