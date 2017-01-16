// fichier jQuery pour le front end.
jQuery(function($) {
// Mettez vos fonctions avec des $ ici


	/***************************************************************************
	* Info in div .logo
	******************************************************************************/
	//$('header div.logo').append('<p>teste</p>');

	function ouvertFermerAjax(){
		$.post(
			ajaxurl,
			{
				'action': 'ouvert_fermer'
			},
			function(response){
				// ici on peut choisir de ou afficher la reponse.
				$('header div.logo').append(response);
			}
		);
	}
	ouvertFermerAjax();

	/***************************************************************************
	* PopUp 7 prochaine jour
	******************************************************************************/

	function popUpHoraire(){
		$.post(
			ajaxurl,
			{
				'action': 'popUpHoraire'
			},
			function(response){
				// ici on peut choisir de ou afficher la reponse.
				//$('header div.logo').append(response);
				console.log(response);
			}
		);
	}

});