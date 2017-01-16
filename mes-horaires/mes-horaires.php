<?php
/*
Plugin Name: mes horaires
Description: Un plugin pour gerer les horaires d'ouverture
Version: 0.1
Author: Adrien Topall
Author URI: http://webart.ovh
License: GPL2
*/

function create_open_day_table(){
	global $wpdb;

	$table_week = $wpdb->prefix . 'open_day_week';
  $table_extra = $wpdb->prefix . 'open_day_extra';
  $table_perso = $wpdb->prefix . 'open_day_perso';

    $table_week_exist=false;
    $table_extra_exist=false;
    $table_perso_exist=false;

    // on recuppere un tableau avec le nom de toute les tables
    $tables=$wpdb->get_results('SHOW TABLES',ARRAY_N);

    // on verifie si les tables du plugin existe deja
    foreach ($tables as $t) {
      if (preg_match("/$table_week/",$t[0])) {
        $table_week_exist=true;
      }
      if (preg_match("/$table_extra/",$t[0])) {
        $table_extra_exist=true;
      }
      if (preg_match("/$table_perso/",$t[0])) {
        $table_extra_exist=true;
      }
  	}

  	// si la table n'existe pas on la crée
  	if (!$table_week_exist){
      $sql1 = "CREATE TABLE $table_week (
               id           INT(1) AUTO_INCREMENT NOT NULL,
               nom          VARCHAR(80) NOT NULL,
               is_closed    ENUM('FALSE','TRUE') NOT NULL DEFAULT 'TRUE',
               open1        TIME,
               close1       TIME,
               open2        TIME,
               close2       TIME,
               PRIMARY KEY(id)
             )";
  	}

  	// si la table n'existe pas on la crée
  	if (!$table_extra_exist){
      $sql2 = "CREATE TABLE $table_extra (
               id             INT(10) AUTO_INCREMENT NOT NULL,
               nom            VARCHAR(80) NOT NULL,
               day            DATE NOT NULL,
               is_closed      ENUM('FALSE','TRUE') NOT NULL DEFAULT 'TRUE',
               same_of_week   ENUM('FALSE','TRUE') NOT NULL DEFAULT 'TRUE',
               open1          TIME,
               close1         TIME,
               open2          TIME,
               close2         TIME,
               PRIMARY KEY(id),
               INDEX(day),
               INDEX(is_closed)
             )";
  	}

    // si la table n'existe pas on la crée
    if (!$table_perso_exist){
      $sql3 = "CREATE TABLE $table_perso (
               id             INT(10) AUTO_INCREMENT NOT NULL,
               nom            VARCHAR(80) NOT NULL,
               day            DATE NOT NULL,
               is_closed      ENUM('FALSE','TRUE') NOT NULL DEFAULT 'TRUE',
               same_of_week   ENUM('FALSE','TRUE') NOT NULL DEFAULT 'TRUE',
               open1          TIME,
               close1         TIME,
               open2          TIME,
               close2         TIME,
               PRIMARY KEY(id),
               INDEX(day),
               INDEX(is_closed)
             )";
    }

  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    
    

    if (isset($sql1)) {
      dbDelta( $sql1 );

      $wpdb->insert( $table_week, array('nom' => 'lundi') );
      $wpdb->insert( $table_week, array('nom' => 'mardi') );
      $wpdb->insert( $table_week, array('nom' => 'mercredi') );
      $wpdb->insert( $table_week, array('nom' => 'jeudi') );
      $wpdb->insert( $table_week, array('nom' => 'vendredi') );
      $wpdb->insert( $table_week, array('nom' => 'samedi') );
      $wpdb->insert( $table_week, array('nom' => 'dimanche') );
    }

    if (isset($sql2)) {
      dbDelta( $sql2 );

      $thisYear = date('Y');
      $endYear = 2037;

      for ($i = $thisYear; $i < $endYear; $i++) { 
        $les_jours_feries = jours_feries($i);

        foreach ($les_jours_feries as $key => $value) {
          $wpdb->insert( $table_extra, array('nom' => $key, 'day' => $value) );
        }
      }
    }

    if (isset($sql3)) {
      dbDelta( $sql3 );
    }

    
}
register_activation_hook( __FILE__, 'create_open_day_table' );

function delete_open_day_table() {
  global $wpdb;
  $wpdb->query('DROP TABLE `'.$wpdb->prefix.'open_day_week`');
  $wpdb->query('DROP TABLE `'.$wpdb->prefix.'open_day_extra`');
  $wpdb->query('DROP TABLE `'.$wpdb->prefix.'open_day_perso`');
}
register_deactivation_hook(__FILE__, 'delete_open_day_table');

class emf_open_day {







}


new emf_open_day();

function jolie_date($date){

  setlocale(LC_ALL, 'fr_FR').': ';
  $timestamp = strtotime($date);
  return iconv('ISO-8859-1', 'UTF-8', strftime('%A %d %B %Y', $timestamp));

}

function gestion_des_horaires(){
  include_once('config.php');
}

add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');
function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page(
        'options-general.php',
        'Mes horaires',
        'Mes horaires',
        'manage_options',
        'mes-horaires',
        'gestion_des_horaires' );
}






/******************************************************************************
* Ajout des scripts
********************************************************************************/

add_action( 'admin_enqueue_scripts', 'mes_horaires_add_stylesheet_to_admin' );

    /**
     * Add stylesheet to the page
     */
    function mes_horaires_add_stylesheet_to_admin() {

        wp_enqueue_script('jquery');
        wp_enqueue_script('field-date-js', 'Field_Date.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), time(), true );  
        wp_enqueue_style( 'jquery-ui-datepicker-style' , '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
        wp_enqueue_style( 'admin', plugins_url('admin.css', __FILE__) );
        wp_enqueue_script( 'custom-script', plugins_url('custom-script.js', __FILE__), array( 'jquery' ) );
    }

/**
 * Load the parent and child theme styles
 */
function mes_horaires_script() {

  wp_enqueue_style( 'horaires', plugins_url('horaires.css', __FILE__) );
  
  wp_enqueue_script( 'custom-front-script', plugins_url('custom-front-script.js', __FILE__), array( 'jquery' ) );

  wp_localize_script('custom-front-script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

}
add_action( 'wp_enqueue_scripts', 'mes_horaires_script' );


include_once('verifAjax.php');


/******************************************************************************/
/*                                                                            */
/*                       __        ____                                       */
/*                 ___  / /  ___  / __/__  __ _____________ ___               */
/*                / _ \/ _ \/ _ \_\ \/ _ \/ // / __/ __/ -_|_-<               */
/*               / .__/_//_/ .__/___/\___/\_,_/_/  \__/\__/___/               */
/*              /_/       /_/                                                 */
/*                                                                            */
/*                                                                            */
/******************************************************************************/
/*                                                                            */
/* Titre          : Jours fériés en France                                    */
/*                                                                            */
/* URL            : http://www.phpsources.org/scripts641-PHP.htm              */
/* Auteur         : developpeurweb                                            */
/* Date édition   : 02 Mai 2011                                               */
/* Website auteur : http://rodic.fr                                           */
/* Modifier       : 08 mars 2016 by Adrien Topall                             */
/*                                                                            */
/******************************************************************************/


    function dimanche_paques($annee)
    {
        return date("Y-m-d", easter_date($annee));
    }

    function vendredi_saint($annee)
    {
        $dimanche_paques = dimanche_paques($annee);
        return date("Y-m-d", strtotime( $dimanche_paques." -2 day"));
    }

    function lundi_paques($annee)
    {
        $dimanche_paques = dimanche_paques($annee);
        return date("Y-m-d", strtotime( $dimanche_paques." +2 day"));
    }
    function jeudi_ascension($annee)
    {
        $dimanche_paques = dimanche_paques($annee);
        return date("Y-m-d", strtotime( $dimanche_paques." +40 day"));
    }
    function lundi_pentecote($annee)
    {
        $dimanche_paques = dimanche_paques($annee);
        return date("Y-m-d", strtotime( $dimanche_paques." +51 day"));
    }
    
  
    function jours_feries($annee)
    {
      $one = lundi_paques($annee);
      $two = jeudi_ascension($annee);
      $tree = lundi_pentecote($annee);

        $jours_feries = array(    
            "lundi de paques" => $one,    
            "Jeudi de l'Ascension" => $two,
            "lundi de pentecote" => $tree,
            "Nouvel an" => $annee."-01-01",        //    Nouvel an
            "Fête du travail" => $annee."-05-01",        //    Fête du travail
            "Armistice 1945" => $annee."-05-08",        //    Armistice 1945
            "Assomption" => $annee."-05-15",        //    Assomption
            "Fête nationale" => $annee."-07-14",        //    Fête nationale
            "Armistice" => $annee."-11-11",        //    Armistice 1918
            "Toussaint" => $annee."-11-01",        //    Toussaint
            "Noël" => $annee."-12-25"        //    Noël
        );

        return $jours_feries;
    }

/******************************************************************************
* Ajout du widget
********************************************************************************/
