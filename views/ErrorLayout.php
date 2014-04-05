<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>Liste des évènements</h1>

<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">Erreur</h3>
  </div>
  <div class="panel-body">
    <?php echo $data['error']; ?>
  </div>
</div>

<?php echo($footer); ?>
