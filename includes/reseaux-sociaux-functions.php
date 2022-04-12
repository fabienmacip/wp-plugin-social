<?php

/* START - ADMIN CSS */

function my_admin_theme_style(){
  wp_enqueue_style('my-admin-theme', plugins_url('reseaux-sociaux.css', __FILE__));

}

add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

/* END - ADMIN CSS */

/* START - ADMIN SIDEBAR */

function social_media_sidebar(){
  add_menu_page('My First Page', 'Reseaux sociaux', 'manage_options', 'social-media', "social_media_page", 'dashicons-share');

}

add_action('admin_menu','social_media_sidebar');

/* END - ADMIN SIDEBAR */



/* START - ADMIN TOPBAR */

function social_media_topbar($wp_admin_bar){
  $admin_topbar = array(
    'id' => 'reseaux-sociaux',
    'title' => 'Reseaux sociaux',
    'href' => admin_url('admin.php?page=social-media'),
  );

  $wp_admin_bar->add_node($admin_topbar);
}

add_action('admin_bar_menu','social_media_topbar', 999);

/* END - ADMIN TOPBAR */


/* START - CREATION DE LA PAGE ADMIN : FONCTION */

function social_media_section_settings(){
  // Création d'une section
  add_settings_section("social_media_section", "", null, "social-media");

  // Création des champs
  add_settings_field("social-media-facebook", "Partager sur Facebook", "social_media_facebook_switch", "social-media", "social_media_section");
  add_settings_field("social-media-whatsapp", "Partager sur What's app", "social_media_whatsapp_switch", "social-media", "social_media_section");
  add_settings_field("social-media-linkedin", "Partager sur Linked In", "social_media_linkedin_switch", "social-media", "social_media_section");
  add_settings_field("social-media-twitter", "Partager sur Twitter", "social_media_twitter_switch", "social-media", "social_media_section");

  // Enregistrement des champs
  register_setting("social_media_section", "social-media-facebook");
  register_setting("social_media_section", "social-media-whatsapp");
  register_setting("social_media_section", "social-media-linkedin");
  register_setting("social_media_section", "social-media-twitter");

}

/* END - CREATION DE LA PAGE ADMIN : FONCTION */


/* START - CREATION DE LA PAGE ADMIN : HTML */

function social_media_facebook_switch(){ ?>
  <label class="switch">
    <input type="checkbox" name="social-media-facebook" value="activate" <?php checked('activate', get_option('social-media-facebook'), true); ?> />
    <span class="slider round"></span>
  </label>
<?php } 

function social_media_whatsapp_switch(){ ?>
  <label class="switch">
    <input type="checkbox" name="social-media-whatsapp" value="activate" <?php checked('activate', get_option('social-media-whatsapp'), true); ?> />
    <span class="slider round"></span>
  </label>
<?php } 

function social_media_linkedin_switch(){ ?>
  <label class="switch">
    <input type="checkbox" name="social-media-linkedin" value="activate" <?php checked('activate', get_option('social-media-linkedin'), true); ?> />
    <span class="slider round"></span>
  </label>
<?php } 

function social_media_twitter_switch(){ ?>
  <label class="switch">
    <input type="checkbox" name="social-media-twitter" value="activate" <?php checked('activate', get_option('social-media-twitter'), true); ?> />
    <span class="slider round"></span>
  </label>
<?php } 

add_action("admin_init", "social_media_section_settings");

/* END - CREATION DE LA PAGE ADMIN : HTML */


/* START - CREATION DE LA PAGE ADMIN : FORMULAIRE HTML */

function social_media_page(){ ?>

  <div class="container">
    <h1>Réseaux sociaux</h1>

    <form method="post" action="options.php">
      <?php
        settings_fields("social_media_section");
        do_settings_sections("social-media");
        submit_button();
      ?>
    </form>
  </div>

<?php }


/* END - CREATION DE LA PAGE ADMIN : FORMULAIRE HTML */


/* START - CREATION DE LA PAGE FRONT : HTML */

function social_media_icons_front($social_media_icons){
  global $post;
  
  $link = get_permalink($post->ID);
  $link = esc_url($link);

  $html = "<div class='container row'>
    <div class='h3'>Partager sur :</div>";

  if(get_option("social-media-facebook") == "activate") {
    $html = $html . "
      <div class='col-1'>
      <a target='_blanck' href='https://www.facebook.com/sharer/sharer.php?u=".$link."'>
      <i class='fab fa-facebook-square fa-2x'></i>
      </a>
      </div>
      ";
    }

    if(get_option("social-media-whatsapp") == "activate") {
      $html = $html . "
        <div class='col-1'>
          <a target='_blanck' href='tel:+33611223344'>
            <i class='fab fa-whatsapp-square fa-2x'></i>
          </a>
        </div>
      ";
    }
  
    if(get_option("social-media-linkedin") == "activate") {
      $html = $html . "
        <div class='col-1'>
          <a target='_blanck' href='http://www.linkedin.com/shareArticle?url=".$link."'>
            <i class='fab fa-linkedin fa-2x'></i>
          </a>
        </div>
      ";
    }

    if(get_option("social-media-twitter") == "activate") {
      $html = $html . "
        <div class='col-1'>
          <a target='_blanck' href='http://www.twitter.com/share?url=".$link."'>
            <i class='fab fa-twitter-square fa-2x'></i>
          </a>
        </div>
      ";
    }

    $social_media_icons = $social_media_icons . $html;

    return $social_media_icons;

  }
  
  add_filter("the_content","social_media_icons_front");
  
  /* END - CREATION DE LA PAGE FRONT : HTML */









