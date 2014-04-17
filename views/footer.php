<?php
$base = Flight::request()->base;
if($base == '/') $base = '';
?>
        <!-- <hr> -->
		<footer>
			<p>
				Une application réalisée par les étudiants FIPA 6 et FIP 19 de l'ENSIIE
			</p>
		</footer>
	
	</div><!-- /.container -->

    <script src="<?php echo $base; ?>/js/jquery.min.js"></script>
    <script src="<?php echo $base; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $base; ?>/js/bootstrap-datepicker.js"></script>

</body>
</html>
