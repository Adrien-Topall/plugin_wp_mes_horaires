<?php 
global $wpdb;

$message = "";
if (isset($_POST) && !empty($_POST)) {
	
	include_once('requete-post.php');

}

// recuperation des données
$data_week = $wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'open_day_week` LIMIT 7');

$data_feries = $wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'open_day_extra` WHERE `day` >= NOW() ORDER BY `day` ASC LIMIT 10');

$data_perso = $wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'open_day_perso` WHERE `day` >= NOW() ORDER BY `day` ASC LIMIT 20');

?>

<div class="wrap" id="meshoraires">

	<h2>Mes Horaires</h2>
	<p><?php echo $message; ?></p>
	<form action="" method="post" name="horaires_semaine" id="horaires_semaine">
		<h2>Par defaut</h2>
		<input type="hidden" name="witch" value="horaires_semaine">
		<input type="submit" class="add-new-h2" value="Enregistrer les changements">
		<ul>
			<?php 
			for ($i=0; $i < 7; $i++) { ?>
				<li data-id="<?php echo $data_week[$i]->id; ?>">
					<h3><?php echo $data_week[$i]->nom; ?></h3>
					<input class="isClose" type="checkbox" name="closed_day<?php echo $data_week[$i]->id; ?>" value="closed" 
						<?php if ( 'TRUE' == $data_week[$i]->is_closed ) echo 'checked="checked"'; ?>
					>Fermé
					
					<br>
					<span>
						<label for="open1_day<?php echo $data_week[$i]->id; ?>">Open 1</label>
						<input class="time" type="text" id="open1_day<?php echo $data_week[$i]->id; ?>" maxlength="5" name="open1_day<?php echo $data_week[$i]->id; ?>" value="<?php echo substr( $data_week[$i]->open1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_week[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close1_day<?php echo $data_week[$i]->id; ?>">Close 1</label>
						<input class="time" type="text" id="close1_day<?php echo $data_week[$i]->id; ?>" maxlength="5" name="close1_day<?php echo $data_week[$i]->id; ?>" value="<?php echo substr( $data_week[$i]->close1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_week[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="open2_day<?php echo $data_week[$i]->id; ?>">Open 2</label>
						<input class="time" type="text" id="open2_day<?php echo $data_week[$i]->id; ?>" maxlength="5" name="open2_day<?php echo $data_week[$i]->id; ?>" value="<?php  echo substr( $data_week[$i]->open2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_week[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close2_day<?php echo $data_week[$i]->id; ?>">Close 2</label>
						<input class="time" type="text" id="close2_day<?php echo $data_week[$i]->id; ?>" maxlength="5" name="close2_day<?php echo $data_week[$i]->id; ?>" value="<?php echo substr( $data_week[$i]->close2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_week[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
				</li>
			<?php }	?>

		</ul>
		

	</form>
	<form action="" method="post" name="horaires_feries" id="horaires_feries">
		<h2>Jours fériés</h2>
		<input type="hidden" name="witch" value="horaires_feries">
		<input type="submit" class="add-new-h2" value="Enregistrer les changements">
		<ul>
			<?php 
			$jour_ferie_ids = '';
			$nb_feries = count($data_feries);
			for ($i=0; $i < $nb_feries; $i++) { ?>
				<li data-id="<?php echo $data_feries[$i]->id; ?>">
					<h3><?php echo $data_feries[$i]->nom; ?></h3>
					<p><?php echo jolie_date($data_feries[$i]->day); ?></p>
					<br>
					<input class="sameOfWeek" type="checkbox" name="sameOfWeek_day<?php echo $data_feries[$i]->id; ?>" value="sameOfWeek"
						<?php if ( 'TRUE' == $data_feries[$i]->same_of_week ) echo 'checked="checked"'; ?>
					>Horaires normale
					<input class="isClose" type="checkbox" name="closed_day<?php echo $data_feries[$i]->id; ?>" value="closed" 
						<?php if ( 'TRUE' == $data_feries[$i]->is_closed ) echo 'checked="checked"'; 
							if ('TRUE' == $data_feries[$i]->same_of_week ) echo 'disabled="disabled"';
						?>
					>Fermé
					
					<br>
					<span>
						<label for="open1_day<?php echo $data_feries[$i]->id; ?>">Open 1</label>
						<input class="time" type="text" id="open1_day<?php echo $data_feries[$i]->id; ?>" maxlength="5" name="open1_day<?php echo $data_feries[$i]->id; ?>" value="<?php echo substr( $data_feries[$i]->open1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_feries[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close1_day<?php echo $data_feries[$i]->id; ?>">Close 1</label>
						<input class="time" type="text" id="close1_day<?php echo $data_feries[$i]->id; ?>" maxlength="5" name="close1_day<?php echo $data_feries[$i]->id; ?>" value="<?php echo substr( $data_feries[$i]->close1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_feries[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="open2_day<?php echo $data_feries[$i]->id; ?>">Open 2</label>
						<input class="time" type="text" id="open2_day<?php echo $data_feries[$i]->id; ?>" maxlength="5" name="open2_day<?php echo $data_feries[$i]->id; ?>" value="<?php echo substr( $data_feries[$i]->open2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_feries[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close2_day<?php echo $data_feries[$i]->id; ?>">Close 2</label>
						<input class="time" type="text" id="close2_day<?php echo $data_feries[$i]->id; ?>" maxlength="5" name="close2_day<?php echo $data_feries[$i]->id; ?>" value="<?php echo substr( $data_feries[$i]->close2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_feries[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<?php $jour_ferie_ids .= $data_feries[$i]->id.','; ?>
				</li>
			<?php }	?>
			<input type="hidden" name="jour_ferie_ids" value="<?php echo $jour_ferie_ids; ?>">
		</ul>

	</form>
	<form action="" method="post" name="horaires_personalise">

		<!--<input type="text" class="datepicker">-->
		<h2>Personalisés</h2>
		<input type="hidden" name="witch" value="horaires_personalise">
		<input type="submit" class="add-new-h2" value="Enregistrer les changements">
		<button class="add-new-h2 add-new-day">Nouveau</button>
		
		<ul>
			<?php 

			$nb_perso = count($data_perso);
			for ($i=0; $i < $nb_perso; $i++) { ?>
				<li data-id="<?php echo $data_feries[$i]->id; ?>">
					<h3><?php echo $data_perso[$i]->nom; ?></h3>
					<p><?php echo jolie_date($data_perso[$i]->day); ?></p>
					<br>
					<input class="sameOfWeek" type="checkbox" name="sameOfWeek_day<?php echo $data_perso[$i]->id; ?>" value="sameOfWeek"
						<?php if ( 'TRUE' == $data_perso[$i]->same_of_week ) echo 'checked="checked"'; ?>
					>Horaires normale
					<input class="isClose" type="checkbox" name="closed_day<?php echo $data_perso[$i]->id; ?>" value="closed" 
						<?php if ( 'TRUE' == $data_perso[$i]->is_closed ) echo 'checked="checked"'; 
							if ('TRUE' == $data_perso[$i]->same_of_week ) echo 'disabled="disabled"';
						?>
					>Fermé
					
					<br>
					<span>
						<label for="open1_day<?php echo $data_perso[$i]->id; ?>">Open 1</label>
						<input class="time" type="text" id="open1_day<?php echo $data_perso[$i]->id; ?>" maxlength="5" name="open1_day<?php echo $data_perso[$i]->id; ?>" value="<?php echo substr( $data_perso[$i]->open1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_perso[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close1_day<?php echo $data_perso[$i]->id; ?>">Close 1</label>
						<input class="time" type="text" id="close1_day<?php echo $data_perso[$i]->id; ?>" maxlength="5" name="close1_day<?php echo $data_perso[$i]->id; ?>" value="<?php echo substr( $data_perso[$i]->close1, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_perso[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="open2_day<?php echo $data_perso[$i]->id; ?>">Open 2</label>
						<input class="time" type="text" id="open2_day<?php echo $data_perso[$i]->id; ?>" maxlength="5" name="open2_day<?php echo $data_perso[$i]->id; ?>" value="<?php echo substr( $data_perso[$i]->open2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_perso[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
					<span>
						<label for="close2_day<?php echo $data_perso[$i]->id; ?>">Close 2</label>
						<input class="time" type="text" id="close2_day<?php echo $data_perso[$i]->id; ?>" maxlength="5" name="close2_day<?php echo $data_perso[$i]->id; ?>" value="<?php echo substr( $data_perso[$i]->close2, 0, -3); ?>"
							<?php if ( 'TRUE' == $data_perso[$i]->is_closed ) echo 'disabled="disabled"'; ?>
						>
					</span>
				</li>
			<?php }	?>

		</ul>

	</form>
	<form action="" method="post" name="horaires_new_day" class="horaires_new_day">
		<input type="hidden" name="witch" value="horaires_new_day">
		<input type="submit" class="add-new-h2" value="Enregistrer">
		<button class="add-new-h2 fermer-new-day">Annuler</button>
		<ul>
			<li>
				<label for="new_nom">Nom : </label>
				<input type="text" id="new_nom" name="new_nom">
				<label for="new_date">Date : </label>
				<input type="text" id="new_date" name="new_date" class="datepicker">
				<br>
				<label for="new_sameOfWeek">Horaires normale : </label>
				<input type="checkbox" id="new_sameOfWeek" name="new_sameOfWeek" value="true">
				<label for="new_isClose">Fermé : </label>
				<input type="checkbox" id="new_isClose" name="new_isClose" value="true">
				<br>
				<label for="new_open1">Open 1</label>
				<input class="time" type="text" id="new_open1" name="new_open1" >
				<label for="new_close1">Close 1</label>
				<input class="time" type="text" id="new_close1" name="new_close1" >
				<label for="new_open2">Open 2</label>
				<input class="time" type="text" id="new_open2" name="new_open2" >
				<label for="new_close2">Close 2</label>
				<input class="time" type="text" id="new_close2" name="new_close2" >
			</li>
		</ul>
	</form>


</div>