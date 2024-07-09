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

<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-12">
	<h1 class="">Our Corporate Learning Partners</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-12">
    <p class="lead">In the BC Public Service, Corporate Learning is a shared space. 
    Learn more about the Corporate Learning Partners who are all committed 
    to offering learning, development and growth opportunities for all our employees.</p>
</div>
<div class="col-12">
<?php
$terms = get_terms( array(
    'taxonomy' => 'learning_partner',
    'hide_empty' => false,
    'orderby'    => 'count',
    'order'   => 'DESC',
    'exclude' => [121,372,144]
) ); // 121 = Office of Compt General, 372 = unknown, 144 = labour relations 
?>

<div id="partnerlist">
<div class="row row-cols-1 row-cols-md-2 g-4">
  

    <!-- <div class="entry-content searchbox" style="text-align: center">
        <input class="search form-control mb-3" placeholder="Type here to filter partners">
    </div> -->
	
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
    <div class="col">
    <div class="card">
    <?php if(!empty($partnerlogo)): ?>
    <?php $image_attributes = wp_get_attachment_image_src( $attachment_id = $partnerlogo, $size = 'medium' ) ?>
    <?php if ( $image_attributes ) : ?>

    <img src="<?php echo $image_attributes[0]; ?>" 
            width="<?php echo $image_attributes[1]; ?>" 
            height="<?php echo $image_attributes[2]; ?>"
            alt="<?= esc_html( $category->name ) ?> logo">

    <?php endif; ?>
    <?php endif; ?>
    <div class="card-body">
    <div class="card-title">
      <h3><?= esc_html( $category->name ) ?> </h3>
    </div>
    <div class="card-text">
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
</div>
</div>


<?php endforeach ?>
</div>
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
