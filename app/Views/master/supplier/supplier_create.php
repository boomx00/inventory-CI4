<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="stockCreateContainer">
            <h1 class="mt-5">Create Supplier Data</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/supplier/create">
             <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
            <div class="form-group row">
                <label for="code" class="col-sm-3 col-form-label">Supplier Code</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="code" name="code">
                </div>
            </div>
        </div>
        <div class="mb-3">
        <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Supplier Name</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
        </div>
        <div class="mb-3">
          <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Address</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="address" name="address">
                </div>
            </div>
          </div>
          <div class="mb-3">

          <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="phone" name="phone">
                </div>
            </div>
            </div>
        
            <div class="mb-3">
            <div class="form-group row">
                <label for="comment" class="col-sm-3 col-form-label">Detail</label>

                <div class="col-sm-9">
                <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>                </div>
            </div>

           
                </div>


            </div>



      </div>
        <div class="col-sm-6">
        
      </div>
      <div class="mb-3">
          <button type="submit" class="btn btn-primary">Create</button>
</button>

      </div>

            </form>
            <hr />

        </div>
    </main>

    <?= $this->endSection('content') ?>
    <!-- <div class="col-sm-6">
                <div class="form-group row">
                <label for="code" class="col-sm-3 col-form-label">Supplier Code</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="code" name="code">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Supplier Name</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Address</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="address" name="address">
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="phone" name="phone">
                </div>
            </div>

            <div class="form-group row">
                <label for="comment" class="col-sm-3 col-form-label">Detail</label>

                <div class="col-sm-9">
                <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>                </div>
            </div>

           
                </div>

            </div>

            <div class="col-sm-6">

            </div> -->