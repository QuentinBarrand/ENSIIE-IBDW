<?php echo($header); ?>
<?php echo($navbar); ?>

<h1><?php echo $title; ?></h1>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Opération réussie !</h3>
  </div>
  <div class="panel-body">
    <?php echo $data['message']; ?>
  </div>
</div>

<?php echo($footer); ?>
