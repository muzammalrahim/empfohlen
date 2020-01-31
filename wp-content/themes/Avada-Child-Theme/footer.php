<?php
/**
 * The footer template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<?php do_action( 'avada_after_main_content' ); ?>

</div>  <!-- fusion-row -->
</main>  <!-- #main -->
<?php do_action( 'avada_after_main_container' ); ?>

<?php
/**
 * Get the correct page ID.
 */
$c_page_id = Avada()->fusion_library->get_page_id();
?>

<?php
/**
 * Only include the footer.
 */
?>
<?php if ( ! is_page_template( 'blank.php' ) ) : ?>
    <?php $footer_parallax_class = ( 'footer_parallax_effect' === Avada()->settings->get( 'footer_special_effects' ) ) ? ' fusion-footer-parallax' : ''; ?>

    <div class="fusion-footer<?php echo esc_attr( $footer_parallax_class ); ?>">
        <?php get_template_part( 'templates/footer-content' ); ?>
    </div> <!-- fusion-footer -->

    <div class="fusion-sliding-bar-wrapper">
        <?php
        /**
         * Add sliding bar.
         */
        if ( Avada()->settings->get( 'slidingbar_widgets' ) ) {
            get_template_part( 'sliding_bar' );
        }
        ?>
    </div>

    <?php do_action( 'avada_before_wrapper_container_close' ); ?>
<?php endif; // End is not blank page check. ?>
</div> <!-- wrapper -->
</div> <!-- #boxed-wrapper -->
<div class="fusion-top-frame"></div>
<div class="fusion-bottom-frame"></div>
<div class="fusion-boxed-shadow"></div>
<a class="fusion-one-page-text-link fusion-page-load-link"></a>

<div class="avada-footer-scripts">
    <?php wp_footer(); ?>
</div>

<script type="application/javascript">
       jQuery( document ).ready(function() {
           jQuery(".banner").append('<div class="eug-header-wave"><div class="wave-0"></div><div class="wave-1"></div><div class="wave-2"></div></div>');
           jQuery(".reg-btn-main").append('<div class="eug-header-wave"><div class="wave-0"></div><div class="wave-1"></div><div class="wave-2"></div></div>');

           //video section
                var custom_videos = 0;
                var custom_videos_show = 1;
                if(jQuery('.custom_videos').length) {
                    custom_videos = jQuery('.custom_videos').length;
                }
           if(custom_videos <= 0){
               jQuery( '#button-click' ).hide();
           }
           jQuery( '#button-click' ).click(function () {
               if(custom_videos <= 0 || custom_videos_show >= custom_videos){
                   jQuery( '#button-click' ).hide();
               }else {
                   custom_videos_show = custom_videos_show + 1;
                   var elem_custom_videos_show = '.custom_videos-'+custom_videos_show;
                   jQuery(elem_custom_videos_show).css({'display': 'block'});
                   jQuery(elem_custom_videos_show).slideDown("slow");
                   if(custom_videos_show >= custom_videos){
                       jQuery( '#button-click' ).hide();
                   }
               }
           });
    });
</script>

</body>
</html>
