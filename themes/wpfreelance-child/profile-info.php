<?php /* Template name: Profile-info */
get_header();?>
<div id="pagehead" class="vh-center">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pagehead3.jpg" alt="image">
    <div class="container">
        <h3>Recevoir des demande de devis pour vos competences</h3>
    </div>
</div>


<div class="wrap-content">
    <div class="container">
        <div class="tags">
            <p class="text1">Vos competences</p>

            <div class="choosen-container">
                <form method="get">
                    <select data-placeholder="Choose tags ..." name="tags[]" multiple class="chosen-select">
                      <option value="Alarme Securite">Alarme Securite</option>
                      <option value="Amenagement exterieur">Amenagement exterieur</option>
                      <option value="Ascenseur - Monte-charges">Ascenseur - Monte-charges</option>
                      <option value="Amenagement exterieur">Amenagement exterieur</option>
                      <option value="Alarme Securite">Alarme Securite</option>
                      <option value="Amenagement exterieur">Amenagement exterieur</option>
                      <option value="Ascenseur - Monte-charges">Ascenseur - Monte-charges</option>
                      <option value="Amenagement exterieur">Amenagement exterieur</option>
                    </select>
                  </form>
            </div>

        </div>
            <div class="text-right">
                <a href="#" class="buttons button-2">Retour tableau de bord</a>
                <a href="#" class="buttons button-2">Sauvegarder</a>
            </div>
        
    </div>
</div>
<?php get_footer();?>