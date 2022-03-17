<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tutorial Upload Gambar Menggunakan Codeigniter 4 - Ilmu Coding</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"> -->
    <link rel="stylesheet" href="<?= base_url('css/image-uploader.min.css') ?>">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>
<form method="post" action="<?= base_url(); ?>/upload/process" name="form-example-1" id="form-example-1" enctype="multipart/form-data"> 
<?= csrf_field(); ?>
<div class="input-field">
    <input type="text" name="name-1" id="name-1">
    <label for="name-1">Name</label>
</div>

<div class="input-field">
    <input type="text" name="description-1" id="description-1">
    <label for="description-1">Description</label>
</div>

<div class="input-field">
    <label class="active">Photos</label>
    <div class="input-images-1" style="padding-top: .5rem;"></div>
</div>

<button>Submit and display data</button>

</form>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript"  src="<?= base_url('js/image-uploader.min.js') ?>"></script>

</body>

<script>

$(function () {

$('.input-images-1').imageUploader();

});



</script>
</html> 