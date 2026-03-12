<?php
/**
 * Title: Contact Home
 * Slug: accelsiors/contact-home
 * Categories: accelsiors
 */
$contact_settings = function_exists( 'accelsiors_get_contact_settings' ) ? accelsiors_get_contact_settings() : array();

$hero_title         = isset( $contact_settings['hero_title'] ) ? $contact_settings['hero_title'] : 'Contact us';
$hero_description   = isset( $contact_settings['hero_description'] ) ? $contact_settings['hero_description'] : '';
$linkedin_url       = isset( $contact_settings['linkedin_url'] ) ? $contact_settings['linkedin_url'] : '#';
$x_url              = isset( $contact_settings['x_url'] ) ? $contact_settings['x_url'] : '#';
$facebook_url       = isset( $contact_settings['facebook_url'] ) ? $contact_settings['facebook_url'] : '#';
$phone              = isset( $contact_settings['phone'] ) ? $contact_settings['phone'] : '';
$general_email      = isset( $contact_settings['general_email'] ) ? $contact_settings['general_email'] : '';
$business_email     = isset( $contact_settings['business_email'] ) ? $contact_settings['business_email'] : '';
$pv_email           = isset( $contact_settings['pv_email'] ) ? $contact_settings['pv_email'] : '';
$hq_name            = isset( $contact_settings['hq_name'] ) ? $contact_settings['hq_name'] : '';
$hq_address         = isset( $contact_settings['hq_address'] ) ? $contact_settings['hq_address'] : '';
$locations_url      = isset( $contact_settings['locations_url'] ) ? $contact_settings['locations_url'] : '#';
$dpo_name           = isset( $contact_settings['dpo_name'] ) ? $contact_settings['dpo_name'] : '';
$dpo_email          = isset( $contact_settings['dpo_email'] ) ? $contact_settings['dpo_email'] : '';
$privacy_notice_url = isset( $contact_settings['privacy_notice_url'] ) ? $contact_settings['privacy_notice_url'] : '#';
$contact_form_code  = isset( $contact_settings['contact_form_code'] ) ? $contact_settings['contact_form_code'] : '';
?>

<!-- wp:group {"align":"full","className":"acc-contact-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acc-contact-hero">
    <!-- wp:group {"className":"acc-contact-hero__inner","layout":{"type":"constrained"}} -->
    <div class="wp-block-group acc-contact-hero__inner">
        <!-- wp:heading {"level":1} -->
        <h1><?php echo esc_html( $hero_title ); ?></h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p><?php echo esc_html( $hero_description ); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acc-contact-main","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acc-contact-main">
    <!-- wp:columns {"className":"acc-contact-layout"} -->
    <div class="wp-block-columns acc-contact-layout">
        <!-- wp:column {"width":"32%","className":"acc-contact-sidebar"} -->
        <div class="wp-block-column acc-contact-sidebar" style="flex-basis:32%">
            <h3>Follow Us</h3>
            <ul class="acc-contact-links">
                <li><a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener">LinkedIn</a></li>
                <li><a href="<?php echo esc_url( $x_url ); ?>" target="_blank" rel="noopener">X</a></li>
                <li><a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener">Facebook</a></li>
            </ul>

            <h3>Call Our Contact Center</h3>
            <p><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d\+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>

            <h3>Email Us</h3>
            <p>General Information:<br><a href="mailto:<?php echo antispambot( esc_attr( $general_email ) ); ?>"><?php echo esc_html( $general_email ); ?></a></p>
            <p>Global Business Development:<br><a href="mailto:<?php echo antispambot( esc_attr( $business_email ) ); ?>"><?php echo esc_html( $business_email ); ?></a></p>

            <h3>Global Pharmacovigilance</h3>
            <p>Email:<br><a href="mailto:<?php echo antispambot( esc_attr( $pv_email ) ); ?>"><?php echo esc_html( $pv_email ); ?></a></p>

            <h3>Location of Our Headquarters</h3>
            <p><strong><?php echo esc_html( $hq_name ); ?></strong><br><?php echo nl2br( esc_html( $hq_address ) ); ?></p>
            <p><a href="<?php echo esc_url( $locations_url ); ?>">See all our locations</a></p>

            <h3>Data Protection</h3>
            <p>Accelsiors' Data Protection Officer:<br><strong><?php echo esc_html( $dpo_name ); ?></strong><br><a href="mailto:<?php echo antispambot( esc_attr( $dpo_email ) ); ?>"><?php echo esc_html( $dpo_email ); ?></a></p>
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"68%","className":"acc-contact-form-col"} -->
        <div class="wp-block-column acc-contact-form-col" style="flex-basis:68%">
            <h2>Send us a message</h2>
            <p>Interested to contact one of our experts or request a proposal? Complete the form below and we will contact you shortly to answer your questions. Fields marked with * are required.</p>

            <?php if ( ! empty( $contact_form_code ) ) : ?>
                <?php echo do_shortcode( $contact_form_code ); ?>
            <?php else : ?>
                <form class="acc-contact-form" method="post" action="#">
                    <div class="acc-contact-form-grid">
                        <p><label>Your Name:*<input type="text" required></label></p>
                        <p><label>Job Title:*<input type="text" required></label></p>
                        <p><label>Email:*<input type="email" required></label></p>
                        <p><label>Phone:<input type="text"></label></p>
                        <p><label>Company:*<input type="text" required></label></p>
                        <p><label>Country:*<input type="text" required></label></p>
                        <p><label>Please Select Your Industry:*<select><option>—Please choose an option—</option></select></label></p>
                        <p><label>Solution / Area of Your Interest:*<select><option>—Please choose an option—</option></select></label></p>
                    </div>
                    <p><label>Your Message:<textarea rows="5" placeholder="How can we help you?"></textarea></label></p>
                    <p class="acc-contact-consent"><label><input type="checkbox" required> I have read and agree with Accelsiors' <a href="<?php echo esc_url( $privacy_notice_url ); ?>">Privacy Notice for Business Partners</a>.</label></p>
                    <p><button type="submit">Submit</button></p>
                </form>
            <?php endif; ?>
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
