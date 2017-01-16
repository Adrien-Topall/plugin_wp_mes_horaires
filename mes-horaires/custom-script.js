// fichier jQuery pour le front end.
jQuery(function($) {
// Mettez vos fonctions avec des $ ici

	$( ".datepicker" ).datepicker();

	/*******************************************************************************
	*	Gestion DISABLED et CHECKED
	*******************************************************************************/
	$('.sameOfWeek').each(function(){
		if ( $(this).is(':checked') ) {
			var attrteste = $(this).parent().find('span input.time').attr('disabled');
			// For some browsers, `attr` is undefined; for others,
			// `attr` is false.  Check for both.
			if (typeof attrteste == typeof undefined ){
				$(this).parent().find('span input.time').attr( "disabled", "disabled" );
			}
		}

	});
	

	$( "#horaires_semaine input.isClose" ).change(function() {
		var isCheck = $(this).is(':checked');
		

		if (isCheck) {
			$(this).parent().find('span input.time').attr( "disabled", "disabled" );
			//$(this).parent().children('input').attr( "disabled", "disabled" );
			//$('span input.time').attr( "disabled", "disabled" );
		}
		else{
			$(this).parent().find('span input.time').removeAttr( "disabled");
			//$(this).parent().children('input').removeAttr( "disabled");
		}
	});

	$('#horaires_feries input.sameOfWeek').change(function(){
		var isCheck = $(this).is(':checked');

		if(isCheck) {
			$(this).next('.isClose').attr( "disabled", "disabled" );

			var attrteste = $(this).parent().find('span input.time').attr('disabled');
			// For some browsers, `attr` is undefined; for others,
			// `attr` is false.  Check for both.
			if (typeof attrteste == typeof undefined ){
				$(this).parent().find('span input.time').attr( "disabled", "disabled" );
			}

		}
		else{
			$(this).next('.isClose').removeAttr( "disabled");

			var isCheck = $(this).next('.isClose').is(':checked');
			if (!isCheck) {
				$(this).parent().find('span input.time').removeAttr( "disabled");
			}

		}
	});

	$( "#horaires_feries input.isClose" ).change(function() {
		var isCheck = $(this).is(':checked');

		if (isCheck) {
			$(this).parent().find('span input.time').attr( "disabled", "disabled" );
			//$(this).parent().children('input').attr( "disabled", "disabled" );
			//$('span input.time').attr( "disabled", "disabled" );
		}
		else{
			$(this).parent().find('span input.time').removeAttr( "disabled");
			//$(this).parent().children('input').removeAttr( "disabled");
		}
	});

	/***************************************************************************
	* PopUp nouvelle date
	******************************************************************************/

	$('.add-new-day').click(function(e){
		e.preventDefault();
		$('.horaires_new_day').show(500);
	});

	$('.fermer-new-day').click(function(e){
		e.preventDefault();
		$('.horaires_new_day').hide(500);
	});


});