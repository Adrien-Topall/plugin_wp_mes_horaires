<?php 

switch ($_POST['witch']) {
		case 'horaires_semaine':

			for ($j=1; $j < 8; $j++) { 
				$is_closed = 'FALSE';
				$open1 = '00:00';
				$close1 = '00:00';
				$open2 = '00:00';
				$close2 = '00:00';

				if ( isset($_POST['closed_day'.$j]) && $_POST['closed_day'.$j] == 'closed' ) {
					$is_closed = 'TRUE';	
				}
				else{
					if ( isset($_POST['open1_day'.$j]) && !empty($_POST['open1_day'.$j]) ) {
						$open1 = $_POST['open1_day'.$j];
					}
					if ( isset($_POST['close1_day'.$j]) && !empty($_POST['close1_day'.$j]) ) {
						$close1 = $_POST['close1_day'.$j];
					}
					if ( isset($_POST['open2_day'.$j]) && !empty($_POST['open2_day'.$j]) ) {
						$open2 = $_POST['open2_day'.$j];
					}
					if ( isset($_POST['close2_day'.$j]) && !empty($_POST['close2_day'.$j]) ) {
						$close2 = $_POST['close2_day'.$j];
					}
				}

				$wpdb->update( $wpdb->prefix.'open_day_week', array( 'is_closed' => $is_closed, 'open1' => $open1, 'close1' => $close1, 'open2' => $open2, 'close2' => $close2 ), array( 'id' => $j ) );
				
			}

			break;

		case 'horaires_feries':

			$nb_j = explode(',', $_POST['jour_ferie_ids']);

			foreach ($nb_j as $key => $value) {
				$same_of_week = 'FALSE';
				$is_closed = 'FALSE';
				$open1 = '00:00';
				$close1 = '00:00';
				$open2 = '00:00';
				$close2 = '00:00';

				if ( isset($_POST['sameOfWeek_day'.$value]) && $_POST['sameOfWeek_day'.$value] == 'sameOfWeek' ) {
					$same_of_week = 'TRUE';	
				}
				elseif ( isset($_POST['closed_day'.$value]) && $_POST['closed_day'.$value] == 'closed' ) {
					$is_closed = 'TRUE';	
				}
				else{
					if ( isset($_POST['open1_day'.$value]) && !empty($_POST['open1_day'.$value]) ) {
						$open1 = $_POST['open1_day'.$value];
					}
					if ( isset($_POST['close1_day'.$value]) && !empty($_POST['close1_day'.$value]) ) {
						$close1 = $_POST['close1_day'.$value];
					}
					if ( isset($_POST['open2_day'.$value]) && !empty($_POST['open2_day'.$value]) ) {
						$open2 = $_POST['open2_day'.$value];
					}
					if ( isset($_POST['close2_day'.$value]) && !empty($_POST['close2_day'.$value]) ) {
						$close2 = $_POST['close2_day'.$value];
					}
				}

				$wpdb->update( $wpdb->prefix.'open_day_extra', array( 'is_closed' => $is_closed, 'same_of_week' => $same_of_week, 'open1' => $open1, 'close1' => $close1, 'open2' => $open2, 'close2' => $close2 ), array( 'id' => $value ) );

			}

			break;

		case 'horaires_personalise':
			# code...
			break;

		case 'horaires_new_day':
				
				if ( isset($_POST['new_nom']) && isset($_POST['new_date']) && !empty($_POST['new_nom']) && !empty($_POST['new_date']) ) {
					
					$is_closed = 'FALSE';
					$same_of_week = 'FALSE';

					// reformatage de la date
					$date_temp = explode('/', $_POST['new_date']);
					$date = $date_temp[2].'-'.$date_temp[0].'-'.$date_temp[1];

					// comparaison avec avec les jour feries
					$conflit = $wpdb->get_row('SELECT `day` FROM `' . $wpdb->prefix . 'open_day_perso` WHERE `day`= '.$date.' ');
					if ( null !== $conflit ) {
					  
					  	$message = "Attention, cette date existe deja dans les jours feries !";
					} else {

						if ( isset($_POST['new_isClose']) && $_POST['new_isClose'] == 'true' ) {
							$is_closed = 'TRUE';
						}
						if ( isset($_POST['new_sameOfWeek']) && $_POST['new_sameOfWeek'] == 'true' ) {
							$same_of_week = 'TRUE';
						}

					  	// enregistrement de la date
						$resultat = $wpdb->insert( $wpdb->prefix . 'open_day_perso' , array('nom' => $_POST['new_nom'], 'day' => $date, 'is_closed' => $is_closed, 'same_of_week' => $same_of_week, 'open1' => $_POST['new_open1'], 'close1' => $_POST['new_close1'], 'open2' => $_POST['new_open2'], 'close2' => $_POST['new_close2'] ) );
						if ( ! ( $resultat === FALSE ) ) {
							$message = "Nouvelle date bien enregistré." ;
						} else {
							$message = "Oups ! Un problème a été rencontré." ;
						}
					}

				}

			break;
		
		default:
			# code...
			break;
	}





 ?>