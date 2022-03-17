<?= $this->extend('Views/layout/page_layout') ?>

<?= $this->section('content') ?>
  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
  <script>
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  
  </script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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

            <form method="post" action="<?= base_url(); ?>/purchase/editprocess/<?= $orderid ?>" id="theform" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6">
           <div class="card">
                <div class="card-body">
                     <div style="margin-bottom:10px;">
            <label for="myDate" class="form-label">Date:</label>
            <input type="date" class="form-control" id="myDate" name="myDate" value="<?=$date?>">
        </div>
        <div style="margin-bottom:10px;">
        <label for="code" class="form-label">Nomor Beli:</label>
        <input type="text" class="form-control" id="orderid" name="orderid" onchange="" value="<?=$orderid?>">
      </div>
                    
                     <div>
      <label for="supplier" class="form-label">Nama Pemasok:</label>
      <button type="button" class="btn btn-secondary btn-sm" id="click">
<i class="bi bi-search" id="click"></i>
            </button>
      <input type="text" class="form-control" id="supplier" name="supplier" onchange="" value="<?=$supplier?>" readonly>
      </div>

      <div>
      <label for="cashier" class="form-label">Kasir:</label>
      <select id="cashier" class="form-control" name="cashier">
      <?php
        $selected = "";
                    foreach ($employee->getResult() as $row) {
                      if($cashier == $row->firstname){
                        $selected =  "selected";
                      }else{
                        $selected = "";
                      }
                    ?>
                       <option <?=$selected?>> <?=$row->firstname?></option>
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
            <input type="text" class="form-control" id="nopolice" name="nopolice" value="<?=$nopolice?>">
        </div>
        <div class="row" style="margin-top:10px;">
      <label for="statuspayment" style="margin-bottom:10px; white-space: pre-wrap;" >Status Bayar:</label>
                <div class="col-sm-4">
      <select id="statuspayment" class="form-control" name="statuspayment" value="<?=$status?>">
      <?php
        if($status == "lunas-cash"){
            echo "
            <option selected>lunas-cash</option>
        <option>bon-hutang</option>
            ";
        }else{
            echo "
            <option>lunas-cash</option>
        <option selected>bon-hutang</option>
            ";
        }
      ?>
      </select>
            </div>
            <div class="col-sm-3">
            <input type="number" class="form-control" id="hari" name="hari" placeholder="" value="<?=$days?>" >
            </div>
        </div>
        <div  style="margin-top:10px;">
      <label for="comment" style="margin-bottom:10px; white-space: pre-wrap;" >Detail Transaksi:</label>
      <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment" ><?=$detail?></textarea></pre>
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
  <table class="table table-bordered" id="myTable">
  <thead>
    <tr>
      <th scope="col-1">No</th>
      <th scope="col-2">Product Code</th>
      <th scope="col-5">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="tablebody">

    <?php
    $no = 1;
    foreach ($products->getResult() as $row) {
    ?>
        <tr >
            <td><?= $no; ?></td>
            <td id="code<?=$no?>" name="code"><?= $row->product_code; ?></td>
            <td id="names<?=$no?>" name="names" ><?= $row->product_name; ?></td>
            <td id="price" name="price"><input type='text' id='pricee<?= $no; ?>' name='pricee<?=$no?>' value='<?= number_format($row->price); ?>' onchange='PriceFunction(this,<?= $no; ?>)'></td>
            <td id="quantity" name="quantity"><input type='number' id='quantity<?= $no; ?>' name='quantity<?=$no?>' value='<?= $row->quantity; ?>' onchange='PriceFunction(this,<?= $no; ?>)' min="1"></td>
            <td id="total<?=$no?>" name="quantity"><input type='text' id='totalss<?=$no?>' name='country' value='<?= number_format($row->total); ?>' readonly></td>
            <td>
              <button type='button' class='btn btn-danger' name='getProductCode<?=$no?>' id='getProductCode<?=$no?>' value='<?= $row->product_code; ?>' onclick='deleteFunction(this,<?= $no; ?>)'>Delete</button>
            </td>
        </tr>
        <?php $no++; ?>
    <?php
    }
    ?>
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
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <div>

</div>
<div>
<div class="input-field">
<!-- <label class="active">Photos</label> -->
<div class="input-images-2" style="padding-top: .5rem;"></div>
</div>
    </div>


  
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
</div>
      <div class="row">
        <div><br></div>
        <div class="col-sm-12" >



        </div>
      </div>
      <div class="row">
                 <div class="form-group row" style="margin-top:10px;">
    <label for="total" class="col-sm-10 col-form-label" style="text-align:right">Total:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="accTotals" name="accTotals" placeholder="" value="<?=number_format($total)?>">
      <input type="hidden" id="accHidden" name="accHidden">
    </div>
  </div>
  <div class="form-group row" style="margin-top:10px;">
    <label for="totBayar" class="col-sm-10 col-form-label" style="text-align:right">Total Bayar:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="totBayar" name="totBayar" placeholder="" onchange="testbayar(this)" value="<?=number_format($paid)?>">
    </div>
  </div>
  <div class="form-group row" style="margin-top:10px;">
    <label for="sisa" class="col-sm-10 col-form-label" style="text-align:right">Sisa Bayar:</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" id="sisa" name="sisa" placeholder="" value="<?=number_format($unpaid)?>">
    </div>
  </div>
               
               </div>
     
      <?php
        $count = 0;
        $output= "";
        $link =  base_url('/uploadtrans/');
        foreach($image as $x){
            echo '<input type="hidden" id="original" name="original[]" value=" '.$x->gambar.' ">';
            $count++;
        }
      ?>

      <div class="mb-3">
      <button type="button" class="btn btn-primary" onclick="editbutton()">Edit</button>

          <button type="submit" class="btn btn-primary" id="editbutton">Edit</button>
</button>
      </div>
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
                    $num = 1;
                    foreach ($item->getResult() as $x) {
                    ?>
                        <tr >
                            <td><?= $num; ?></td>
                            <td id="code<?=$num?>" name="code" id="code"><?= $x->code; ?></td>
                            <td id="namess<?=$num?>" name="names" ><?= $x->name; ?></td>
                            <td id="prices<?=$num?>" name="price"><?= $x->price; ?></td>
                            <td id='stock<?=$num?>' name='stock'><?= $x->stock; ?></td>
                            <td>
                               <button type='submit' class='btn btn-primary' name='getProductCode' id='getProductCode' value='<?= $x->code; ?>' onclick='testFunction(this,<?=$num?>)'>Select</button>
                            </td>
                        </tr>
                    <?php
                    $num++;
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
<input type="hidden" value="<?= csrf_hash() ?>" id="csrf">
<script>

function editbutton(){
  var status = document.getElementById("statuspayment").value;
  var sisa = document.getElementById("sisa").value;
  var paid = document.getElementById("totBayar").value;

  var hari = document.getElementById("hari").value;

  var orderid = document.getElementById("orderid").value;
  var supplier = document.getElementById("supplier").value;

  if(status == "lunas-cash" && sisa!="0" && paid==0){
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
function keyip(objButton,index){
    document.getElementById("pricee"+index).value = document.getElementById("pricee"+index).value.replaceAll(/\D/g, "").replaceAll(/\B(?=(\d{3})+(?!\d))/g, ",");
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
let preloaded = [
    <?php
        $count = 0;
        $link =  base_url('/uploadtrans/');
        foreach($image as $x){
            echo '{id:'.$count.', src:" '.$link."/".$x->gambar.' "},';
            $count++;
        }
      ?>
  
];

function testbayar(objButton){
  var ex = document.getElementById('accTotals').value;
var acctotal = ex.replaceAll(',','');
    var ex1 = document.getElementById("totBayar").value;
    var totbayar = ex1.replaceAll(',','');

var sisa = acctotal - totbayar;
    document.getElementById("sisa").value = sisa;
// alert(acctotal)


}

$(function () {
  $('.input-images-2').imageUploader({
    preloaded: preloaded,
    imagesInputName: 'photos',
    preloadedInputName: 'old'
  });
});

</script>
    <script>
      $('#mydatatable').DataTable();
    </script>
<script type="text/javascript">
document.getElementById("accTotals").innerHTML = <?= $total ?>;


$(document).ready(function(){

  $('#addProduct').on('click',function(){
    const x = document.getElementById("orderid").value;
    // const orderDate = document.getElementById("date").value;
    // const orderCustomer = document.getElementById("customer").value;


    // const x = document.getElementById("orderid").value;

    $('#idx').val(x);
    // $('#ordercustomer').val(orderCustomer);
    // $('#orderdate').val(orderDate);

    // alert(i);
    $('#createModal').modal('show');
   
  })

  $('#test').click(function(){
  })

  // $('#editbutton').on('click',function(){alert("yes")}
});

function PriceFunction(objButton,x){
    var ex = document.getElementById("pricee"+x).value;
    var price = ex.replaceAll(',','');
  var product = document.getElementById("code"+x).innerHTML;
  var orderid = "<?php echo $orderid?>"; 
  var quantity = document.getElementById("quantity"+x).value;
  
//   alert(product);
  var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            price: price, 
            product: product,
            quantity:quantity,
            orderid: orderid 
          };
          // alert(csrfHash);
        //   alert(orderid);
  $.ajax({
    url : "<?php echo site_url("/purchase/edit/priceajax"); ?>",
                type: "POST",
                data: dataJson, 
                dataType: "json",
                success: function(data)
                {
                    document.getElementById("totalss"+x).value =data.total;
                  document.getElementById("quantity"+x).value =data.quantity;
                // alert(data.acctotal);
                  document.getElementById("accTotals").value = data.acctotal;

    }
              })

}
function deleteFunction(objButton,x){
  var product = objButton.value;
  var i = "<?php echo $i?>";
  var orderid = "<?php echo $orderid?>"
  var total = document.getElementById("totalss"+x).value;

  var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            product: product, 
            orderid: orderid,
            total: total,
          };
//   alert(total);
  $.ajax({
    url : "<?php echo base_url("purchase/edit/deleterowedit"); ?>",
                type: "get",
                data: dataJson,
                // dataType: 'json',
                success: function(data)
                {
                  var str=data;
                  var res=str.split('!');
document.getElementById("tablebody").innerHTML =  res[0];
document.getElementById("accTotals").value = res[1];
document.getElementById("displayproduct").innerHTML = res[2];


    }
              })
}


function myFunction(objButton, index) {
  var i = "<?php echo $i?>";
  var orderid = "<?php echo $orderid?>";
var product = document.getElementById('code' + index).innerHTML;
  var acctotal = 0;
  var quantity = objButton.value;
  var prodname = document.getElementById('names' + index).innerHTML;
  var total = document.getElementById("total"+index).value;
  var price = document.getElementById("price"+index).value;

  var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
            product: product, 
            orderid: orderid,
            quantity:quantity,
            total: total ,
            price:price
          };
// alert(price);
$.ajax({
  url : "<?php echo base_url("sales/edit/editqty"); ?>",
              type: "GET",
              data: dataJson,
              dataType: "JSON" ,
              success: function(data)
              {
                document.getElementById("price"+index).value = data.price;
                document.getElementById("total"+index).value = data.total;
                document.getElementById("accTotals").innerHTML = data.acctotal;

// document.getElementById("accTotals").innerHTML = res[1];
                // document.getElementById("testinger").innerHTML = data;
// document.getElementById("tablebody").innerHTML +=  data;
// document.getElementById("tablebody").innerHTML =  data;

// document.getElementById("index").value = data;
  }
            })
}

function testFunction(objButton,indexx){

  var i = "<?php echo $i?>";
  var product = objButton.value;
  var name = document.getElementById("namess"+indexx).innerHTML;
  var price = document.getElementById("prices"+indexx).innerHTML;
  var orderid = "<?php
  $db = \Config\Database::connect();

  $searchsql = "SELECT * FROM purchase WHERE order_id = ?";
  $query = $db->query($searchsql, [$i]);
  $row = $query->getRow();
echo $row->order_id;
  ?>";



  var dataJson = {
      [csrfName]: csrfHash,
      orderid: orderid,
      product: product,
      name:name
  }
// alert (prodcode);
  $.ajax({
    url : "<?php echo base_url("purchase/edit/addedit"); ?>",
                type: "post",
                data: dataJson,
                dataType: "json",
                success: function(data)
                {
              
    }
              });
//   alert(parseInt(document.getElementById("index").value) + 1);
  $.ajax({
    url : "<?php echo base_url("purchase/edit/displaymainedit"); ?>",
                type: "get",
                data: {orderid:orderid},
                success: function(data)
                {
                    var str=data;
                var res=str.split('!'); 
                document.getElementById("tablebody").innerHTML =  res[0];
document.getElementById("accTotals").innerHTML = res[1];
document.getElementById("displayproduct").innerHTML = res[2];
              
    }
              })
  $('#createModal').modal('hide');

}

</script>
    <?= $this->endSection('content') ?>
