        <!-- <hr> -->
		<footer>
			<p>
				Une application réalisée par les étudiants FIPA 6 et FIP 19 de l'ENSIIE
			</p>
		</footer>
	
	</div><!-- /.container -->

<?php
    $base = Flight::request()->base;
    if($base == '/') $base = '';
    $js_scripts = ['jquery.min.js',
                   'moment.min.js',
                   'bootstrap.min.js',
                   'bootstrap-datepicker.js',
                   'bootstrap-datetimepicker.min.js',
                   'bootstrap-datetimepicker.fr.js'
                  ];
    foreach($js_scripts as $script) {
        echo '<script src="' . $base . '/js/' . $script . '"></script>';
    }
?>

</body>
</html>
