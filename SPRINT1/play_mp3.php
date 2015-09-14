<?php
$id=$_GET['id'];
?>

<!DOCTYPE html>

<html lang="en">



<meta charset="UTF-8">

<title>Insert YouTube Video in Bootstrap Modal</title>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<style type="text/css">

    .modal-content iframe{

        margin: 0 auto;

        display: block;

    }

</style>



</head>

<body style="background-color:#333;">

<div class="bs-example">

    <!-- Button HTML (to Trigger Modal) -->
	
	<?php $path=$id; ?>

    <a href="#myModal" src="<?php echo $path; ?>" class="btn btn-lg btn-primary play_video" style="background-color:#ed9c28;margin-left:40%;margin-top:20%;" data-toggle="modal">
        Click to Play Music
    </a>

    

    <!-- Modal HTML -->

    <div id="myModal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                  

                </div>

                <div class="modal-body">

                    <iframe  width="560" height="315" id="cartoonVideo" src="" frameborder="0" allowfullscreen></iframe>

                </div>

            </div>

        </div>

    </div>

</div>     

</body>

</html>
<script type="text/javascript">

</script>