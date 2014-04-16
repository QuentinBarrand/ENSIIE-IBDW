<?php echo($header); ?>
<?php echo($navbar); ?>

<h1>
    S'inscrire en tant que Choriste
    <br>
    <small>Bienvenue !</small>
</h1>


<div class="row">
    <div class="col-lg-5">
        <form role="form" action="<?php echo Flight::request()->base; ?>/choriste/nouveau" method="post">
          
          <div class="form-group">
            <label>Identifiant</label>
            <input type="text" class="form-control" placeholder="Caractères alphanumériques sans espaces">
          </div>

          <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" class="form-control" id="password0" placeholder="Ce que vous voulez">
            <br>
            <input type="password" class="form-control" id="password1" placeholder="Confirmez votre mot de passe">
          </div>

          <div class="form-group">
            <label>Prénom</label>
            <input type="text" class="form-control" placeholder="John">
          </div>

          <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" placeholder="Doe">
          </div>

          <div class="form-group">
            <label>Ville</label>
            <input type="text" class="form-control" placeholder="Evry">
          </div>

          <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" class="form-control" placeholder="+33 1 23 45 67 89">
          </div>

          <div class="form-group">
            <label>Voix</label>
            <select class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>


          <button type="submit" class="btn btn-default">M'inscrire</button>
        </form>
    </div>

    <div class="col-lg-6 col-lg-offset-1 well">
        <h2>Merci de vous inscrire à notre chorale !</h2>
        <h4>En vous inscrivant, vous pouvez suivre votre progression et participer aux répétitions et concerts.</h4>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Donec a diam lectus. 
            Sed sit amet ipsum mauris. 
            Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit. 
            Donec et mollis dolor. 
            Praesent et diam eget libero egestas mattis sit amet vitae augue. 
            Nam tincidunt congue enim, ut porta lorem lacinia consectetur. 
            Donec ut libero sed arcu vehicula ultricies a non tortor. 
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Aenean ut gravida lorem. 
            Ut turpis felis, pulvinar a semper sed, adipiscing id dolor. 
            Pellentesque auctor nisi id magna consequat sagittis. 
            Curabitur dapibus enim sit amet elit pharetra tincidunt feugiat nisl imperdiet. 
            Ut convallis libero in urna ultrices accumsan. 
            Donec sed odio eros. 
            Donec viverra mi quis quam pulvinar at malesuada arcu rhoncus. 
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            In rutrum accumsan ultricies. 
            Mauris vitae nisi at sem facilisis semper ac in est.
        </p>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Donec a diam lectus. 
            Sed sit amet ipsum mauris. 
            Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit. 
            Donec et mollis dolor. 
            Praesent et diam eget libero egestas mattis sit amet vitae augue. 
            Nam tincidunt congue enim, ut porta lorem lacinia consectetur. 
            Donec ut libero sed arcu vehicula ultricies a non tortor. 
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Aenean ut gravida lorem. 
            Ut turpis felis, pulvinar a semper sed, adipiscing id dolor. 
            Pellentesque auctor nisi id magna consequat sagittis. 
            Curabitur dapibus enim sit amet elit pharetra tincidunt feugiat nisl imperdiet. 
            Ut convallis libero in urna ultrices accumsan. 
            Donec sed odio eros. 
            Donec viverra mi quis quam pulvinar at malesuada arcu rhoncus. 
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            In rutrum accumsan ultricies. 
            Mauris vitae nisi at sem facilisis semper ac in est.
        </p>
    </div>
</div>

<?php echo $footer; ?>
