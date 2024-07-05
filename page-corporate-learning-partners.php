<?php
/**
 * The template for displaying all Learning Partners
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

?>

<div class="wp-block-cover alignfull has-background-dim-80 has-background-dim hero" 
	style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;background-color:#28537d;min-height:300px">
		
		<?php $thum = get_the_post_thumbnail_url(get_the_ID(),'full') ?>

			<img loading="lazy" 
					class="wp-block-cover__image-background wp-image-4447" 
					alt="" 
					src="<?= $thum ?>" 
					tyle="object-position:71% 18%" 
					data-object-fit="cover" 
					data-object-position="71% 18%" 
					sizes="(max-width: 1352px) 100vw, 1352px" 
					width="1352" 
					height="888">

	<div class="wp-block-cover__inner-container">
		<?php the_title( '<h1 class="alignfull has-text-align-center heroheader has-white-color has-text-color">', '</h1>' ); ?>
	</div>
</div>


<div class="entry-content">
    <?php
/* Start the Loop */
while ( have_posts() ) :
	the_post();
	the_content();
endwhile; // End of the loop.
?>
<?php
$terms = get_terms( array(
    'taxonomy' => 'learning_partner',
    'hide_empty' => false,
    'orderby'    => 'count',
    'order'   => 'DESC',
    'exclude' => [121,372,144]
) ); // 121 = Office of Compt General, 372 = unknown, 144 = labour relations 
?>
</div> <!-- /.entry-content -->

<div id="partnerlist">

    <!-- <div class="entry-content searchbox" style="text-align: center">
        <input class="search form-control mb-3" placeholder="Type here to filter partners">
    </div> -->
	
<div class="alignwide">
<div class="hubgrid">
<div class="hubgridinner">
<?php $count = 1 ?>
<?php foreach( $terms as $category ) : ?>
    
    <?php
    $pcount = $category->count . ' course';
    if($category->count > 1) $pcount = $category->count . ' courses';
    $category_link = sprintf( 
        '<a href="%1$s" title="%2$s" class="partnerofferings">View %3$s from this partner</a>',
        esc_url( get_category_link( $category->term_id ) ),
        esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
        esc_html( $pcount )
    );
    $partnerurl = '';
    $partnerlogo = '';
    $term_vals = get_term_meta($category->term_id);
    foreach($term_vals as $key=>$val){
        //echo $val[0] . '<br>';
        if($key == 'partner-url') {
            $partnerurl = $val[0];
        }
        if($key == 'category-image-id') {
            $partnerlogo = $val[0];
        }  
    } 
    ?>
    <div class="hubcard">
    <?php if(!empty($partnerlogo)): ?>
    <?php $image_attributes = wp_get_attachment_image_src( $attachment_id = $partnerlogo, $size = 'medium' ) ?>
    <?php if ( $image_attributes ) : ?>
    <div class="hubfeatimage">
    <img src="<?php echo $image_attributes[0]; ?>" 
            width="<?php echo $image_attributes[1]; ?>" 
            height="<?php echo $image_attributes[2]; ?>"
            alt="<?= esc_html( $category->name ) ?> logo">
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <div class="hubtitle">
      <h3><?= esc_html( $category->name ) ?> </h3>
    </div>
    <div class="hubexcerpt flexible">
    <?= sprintf( esc_html__( '%s', 'textdomain' ), $category->description ) ?>



    </div>
    <?php if(!empty($partnerurl)): ?>
    <div class="partner-url">
        <a target="_blank" 
            rel="noopener" 
            href="<?= $partnerurl ?>">
                View Partner Website
        </a>
    </div>
    <?php endif ?>
    <div class="hublink">
    <?php if($category->count > 0): ?>

    <?= sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) ?>
    
    <?php else: ?>
        <div style="background-color: #c3d4e4; margin: 2em 0; padding: 1em; text-align: center;">
            <em>This partner does not currently have any courses listed in the Hub.</em>
        </div>
    <?php endif ?>
    </div>
</div>
<?php $count++ ?>
<?php if($count%2>0): ?>
</div>
<div class="hubgridinner">
<?php endif ?>
<?php endforeach ?>
</div>
</div>
</div> <!-- / -->


<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>

var courseoptions = {
    valueNames: [ 'partnername', 'partnerdesc' ]
};
var partners = new List('partnerlist', courseoptions);
document.getElementById('pcount').innerHTML = partners.update().matchingItems.length;
partners.on('searchComplete', function(){
    //console.log(upcomingClasses.update().matchingItems.length);
    //console.log(courses.update().matchingItems.length);
    document.getElementById('pcount').innerHTML = partners.update().matchingItems.length;
});

</script> -->
<?php get_footer() ?>
