<?php
/**
 * Title: Contact Home
 * Slug: accelsiors/contact-home
 * Categories: footer
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}},"backgroundColor":"light-gray","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-light-gray-background-color has-background" style="padding-top:3rem;padding-bottom:3rem">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Accelerate Your Biotech Journey – Get in Touch</h2>
    <!-- /wp:heading -->
    
    <!-- wp:html -->
    <form class="wp-block-group" style="max-width: 600px; margin: 0 auto;">
        <p><input type="text" placeholder="Name*" style="width:100%; padding: 10px; margin-bottom: 10px;" required></p>
        <p><input type="text" placeholder="Job Title*" style="width:100%; padding: 10px; margin-bottom: 10px;" required></p>
        <p><input type="email" placeholder="Email*" style="width:100%; padding: 10px; margin-bottom: 10px;" required></p>
        <p><select style="width:100%; padding: 10px; margin-bottom: 10px;"><option>Region of Interest</option><option>USA</option><option>EU</option><option>South Korea</option><option>China</option></select></p>
        <p><label><input type="checkbox"> Interest in HexaHelix?</label></p>
        <p><textarea placeholder="Message" style="width:100%; padding: 10px; margin-bottom: 10px;"></textarea></p>
        <p><button type="submit" class="wp-block-button__link has-primary-background-color has-text-color has-background wp-element-button">Submit</button></p>
    </form>
    <!-- /wp:html -->
</div>
<!-- /wp:group -->