<?php 

/*********************************
* Ajax
**********************************/

add_action( 'wp_ajax_ouvert_fermer', 'ouvert_fermer' );
add_action( 'wp_ajax_nopriv_ouvert_fermer', 'ouvert_fermer' );

function ouvert_fermer() {

	global $wpdb;

	$table_week = $wpdb->prefix . 'open_day_week';
  	$table_extra = $wpdb->prefix . 'open_day_extra';
  	$table_perso = $wpdb->prefix . 'open_day_perso';


	$today = date("Y-m-d");
	$theDay = date("N");

	// recupère les données du jour
	$verif_week = $wpdb->get_row("SELECT * FROM $table_week WHERE id = $theDay LIMIT 1");


	// verifie si on est un jour ferier, si oui recupère les données
	$verif_ferie = $wpdb->get_row("SELECT * FROM $table_extra WHERE day = $today LIMIT 1");

	if (empty($verif_ferie)) {

		// verifie si il y a des paramettre particulier aujourd'hui, si oui recupère les données
		$verif_perso = $wpdb->get_row("SELECT * FROM $table_perso WHERE day = $today LIMIT 1");

		if (empty($verif_perso)) {
			if ($verif_week->is_closed == 'TRUE') { 
				echo '<p class="h_close">Fermé</p>';
			}
			else{
				echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
			}
		}
		elseif ( $verif_perso->same_of_week == 'TRUE' ) {
			if ($verif_week->is_closed == 'TRUE') {
				echo '<p class="h_close">Fermé</p>';
			}
			else{
				echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
			}
		}
		elseif ( $verif_perso->is_closed == 'TRUE' ) {
			echo '<p class="h_close">Fermé</p>';
		}
		else{
			echo '<p class="h_open">ouvert de '. substr( $verif_perso->open1, 0, -3).' à '. substr( $verif_perso->close1, 0, -3).'</p>';
		}
	}
	elseif ( $verif_ferie->same_of_week == 'TRUE' ) {
		if ($verif_week->is_closed == 'TRUE') {
			echo '<p class="h_close">Fermé</p>';
		}
		else{
			echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
		}
	}
	elseif ( $verif_ferie->is_closed == 'TRUE' ){
		echo '<p class="h_close">Fermé</p>';
	}
	else{
		echo '<p class="h_open">ouvert de '. substr( $verif_ferie->open1, 0, -3).' à '. substr( $verif_ferie->close1, 0, -3).'</p>';
	}

	die();
}

/****************************************************
* Fonction qui recupere horaire ouverture
*****************************************************/

function getHoraire( $date ){

	global $wpdb;

	$table_week = $wpdb->prefix . 'open_day_week';
  	$table_extra = $wpdb->prefix . 'open_day_extra';
  	$table_perso = $wpdb->prefix . 'open_day_perso';

  	$leJour = date("N", strtotime( $date )); 

  	// recupère les données du jour
	$verif_week = $wpdb->get_row("SELECT * FROM $table_week WHERE id = $leJour LIMIT 1");

	// verifie si on est un jour ferier, si oui recupère les données
	$verif_ferie = $wpdb->get_row("SELECT * FROM $table_extra WHERE day = $date LIMIT 1");

	if (empty($verif_ferie)) {

		// verifie si il y a des paramettre particulier aujourd'hui, si oui recupère les données
		$verif_perso = $wpdb->get_row("SELECT * FROM $table_perso WHERE day = $date LIMIT 1");

		if (empty($verif_perso)) {
			if ($verif_week->is_closed == 'TRUE') { 
				echo '<p class="h_close">Fermé</p>';
			}
			else{
				echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
			}
		}
		elseif ( $verif_perso->same_of_week == 'TRUE' ) {
			if ($verif_week->is_closed == 'TRUE') {
				echo '<p class="h_close">Fermé</p>';
			}
			else{
				echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
			}
		}
		elseif ( $verif_perso->is_closed == 'TRUE' ) {
			echo '<p class="h_close">Fermé</p>';
		}
		else{
			echo '<p class="h_open">ouvert de '. substr( $verif_perso->open1, 0, -3).' à '. substr( $verif_perso->close1, 0, -3).'</p>';
		}
	}
	elseif ( $verif_ferie->same_of_week == 'TRUE' ) {
		if ($verif_week->is_closed == 'TRUE') {
			echo '<p class="h_close">Fermé</p>';
		}
		else{
			echo '<p class="h_open">ouvert de '. substr( $verif_week->open1, 0, -3).' à '. substr( $verif_week->close1, 0, -3).'</p>';
		}
	}
	elseif ( $verif_ferie->is_closed == 'TRUE' ){
		echo '<p class="h_close">Fermé</p>';
	}
	else{
		echo '<p class="h_open">ouvert de '. substr( $verif_ferie->open1, 0, -3).' à '. substr( $verif_ferie->close1, 0, -3).'</p>';
	}

	die();
}

/*********************************
* Ajax popUpHoraire
**********************************/

add_action( 'wp_ajax_popUpHoraire', 'popUpHoraire' );
add_action( 'wp_ajax_nopriv_popUpHoraire', 'popUpHoraire' );

function popUpHoraire(){

}

?>