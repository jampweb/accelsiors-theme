<?php
/**
 * Include the mega menu walker
 */
require_once get_template_directory() . '/inc/mega-menu-walker.php';

if ( ! function_exists( 'accelsiors_theme_setup' ) ) :
	function accelsiors_theme_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' ); // Loads CSS in Editor

        // Register navigation menus
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'accelsiors-theme' ),
        ) );
	}
endif;
add_action( 'after_setup_theme', 'accelsiors_theme_setup' );

function accelsiors_register_hero_block_styles() {
	register_block_style(
		'core/group',
		array(
			'name'  => 'hero-cinematic',
			'label' => __( 'Hero: Cinematic Split', 'accelsiors' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'hero-centered',
			'label' => __( 'Hero: Centered Stack', 'accelsiors' ),
		)
	);
}
add_action( 'init', 'accelsiors_register_hero_block_styles' );

function accelsiors_register_hexa_grid_block_styles() {
	register_block_style(
		'core/group',
		array(
			'name'  => 'hexa-grid-3',
			'label' => __( 'Grid: 3 Cols', 'accelsiors' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'hexa-grid-4',
			'label' => __( 'Grid: 4 Cols', 'accelsiors' ),
		)
	);
}
add_action( 'init', 'accelsiors_register_hexa_grid_block_styles' );

// CRITICAL FIX: Enqueue styles on the Frontend
function accelsiors_enqueue_styles() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_enqueue_style( 'accelsiors-main-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) ); // Cache busting

    // Mega Menu Assets
    wp_enqueue_style( 'accelsiors-mega-menu-style', get_template_directory_uri() . '/assets/css/mega-menu.css', array(), filemtime( get_template_directory() . '/assets/css/mega-menu.css' ) );
    wp_enqueue_script( 'accelsiors-mega-menu-script', get_template_directory_uri() . '/assets/js/mega-menu.js', array(), $theme_version, true );


    // Enqueue Barba.js for SPA transitions
    wp_enqueue_script( 'barba', 'https://unpkg.com/@barba/core', array(), '2.9.7', true );

    // Enqueue Custom Transitions
    wp_enqueue_script( 'accelsiors-transitions', get_template_directory_uri() . '/assets/js/app-transitions.js', array('barba'), $theme_version, true );

    // Smart sticky header behavior
    wp_enqueue_script( 'accelsiors-header', get_template_directory_uri() . '/assets/js/accelsiors-header.js', array(), $theme_version, true );

    // Auto-close Mega Menu on link click (Fix for Barba.js SPA)
    wp_add_inline_script( 'accelsiors-header', "
        document.addEventListener('click', function(e) {
            if (e.target.closest('.wp-block-navigation-item__content')) {
                var closeBtn = document.querySelector('.wp-block-navigation__responsive-container-close');
                if (closeBtn && document.querySelector('.wp-block-navigation__responsive-container.is-menu-open')) {
                    closeBtn.click();
                }
            }
        });
    " );
}
add_action( 'wp_enqueue_scripts', 'accelsiors_enqueue_styles' );

// Auto-Inject Schema Markup based on Docs
function accelsiors_inject_schema() {
    $schema = null;

    if ( is_front_page() ) {
        // Homepage Schema: Organization + FAQ + Article [Source: Brief]
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type'    => 'Organization',
                    'name'     => 'Accelsiors',
                    'url'      => home_url(),
                    'logo'     => get_template_directory_uri() . '/assets/images/logo.png',
                    'description' => 'Accelsiors is a global CRO accelerating life-changing therapies for emerging biotech companies with tailored solutions and HexaHelix expertise.',
                    'sameAs'   => ["https://www.linkedin.com/company/accelsiors", "https://twitter.com/accelsiors", "https://www.facebook.com/accelsiors"]
                ],
                [
                    '@type'    => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'What is Accelsiors HexaHelix?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Accelsiors HexaHelix is our evolved Genetic Code for Success, infusing trials with precision, scientific integrity, efficiency, data transparency, patient-centricity, and AI/data security for emerging biotechs.'
                            ]
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'How does Accelsiors support global clinical trials?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'With expertise in 40+ countries across 6 continents, we offer seamless, patient-centered trials tailored for USA, EU, South Korea, and China.'
                            ]
                        ]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'Accelsiors HexaHelix: Precision-Engineered Clinical Trials',
                    'description' => 'Explore how Accelsiors HexaHelix powers successful trials with six strands for emerging biotechs worldwide.',
                    'author' => [
                        '@type' => 'Organization',
                        'name' => 'Accelsiors'
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Accelsiors',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => get_template_directory_uri() . '/assets/images/logo.png'
                        ]
                    ],
                    'datePublished' => '2025-01-01',
                    'image' => get_template_directory_uri() . '/assets/images/helix-hero.jpg',
                    'url' => home_url()
                ]
            ]
        ];
    } 
    
    // Sub-pages Schema Injection
    if ( is_page('qualitydrive') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    'name' => 'Accelsiors',
                    'url' => home_url(),
                    'logo' => get_template_directory_uri() . '/assets/images/accelsiors-logo.png',
                    'description' => 'Accelsiors is a global CRO accelerating therapies for emerging biotechs with HexaHelix solutions.'
                ],
                [
                    '@type'    => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'What is QualityDRIVE™?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'QualityDRIVE™ is the precision strand of Accelsiors HexaHelix, preventing errors through Quality by Design (QbD) and stakeholder alignment.'
                            ]
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'How does QualityDRIVE™ benefit emerging biotechs?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'It reduces risks by up to 40%, ensures regulatory compliance, and accelerates trials with cost savings.'
                            ]
                        ]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'QualityDRIVE™ – Precision Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how QualityDRIVE™ embeds precision and Quality by Design into clinical trials for emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'publisher' => ['@type' => 'Organization', 'name' => 'Accelsiors', 'logo' => ['@type' => 'ImageObject', 'url' => get_template_directory_uri() . '/assets/images/logo.png']],
                    'datePublished' => '2025-01-01',
                    'image' => get_template_directory_uri() . '/assets/images/hero-qualitydrive.jpg',
                    'url' => home_url('/expertise/hexahelix/qualitydrive')
                ]
            ]
        ];
    } elseif ( is_page('strongcore-scientific') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        ['@type' => 'Question', 'name' => 'What is StrongCORE Scientific™?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'StrongCORE Scientific™ is the scientific integrity strand of Accelsiors HexaHelix, delivering ideal results through globally recognized experts.']],
                        ['@type' => 'Question', 'name' => 'How does StrongCORE Scientific™ benefit emerging biotechs?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'It provides reliable outcomes, expert access, and innovation for complex trials, saving time and enhancing approvals.']]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'StrongCORE Scientific™ – Scientific Integrity Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how StrongCORE Scientific™ delivers ideal trial results with globally recognized expertise for emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'datePublished' => '2025-01-01'
                ]
            ]
        ];
    } elseif ( is_page('acceleroute') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        ['@type' => 'Question', 'name' => 'What is AcceleROUTE™?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'AcceleROUTE™ is the efficiency strand of Accelsiors HexaHelix, ensuring cohesion and acceleration by examining all study aspects under one team.']],
                        ['@type' => 'Question', 'name' => 'How does AcceleROUTE™ benefit emerging biotechs?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'It accelerates timelines by up to 30%, reduces costs through error elimination, and scales globally for efficient trials.']]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'AcceleROUTE™ – Efficiency Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how AcceleROUTE™ drives seamless cohesion and acceleration in clinical trials for emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'datePublished' => '2025-01-01'
                ]
            ]
        ];
    } elseif ( is_page('widescope-intelligence') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        ['@type' => 'Question', 'name' => 'What is WideSCOPE Intelligence™?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'WideSCOPE Intelligence™ is the data strand of Accelsiors HexaHelix, uniting study elements in a full-scale eClinical system to decrease errors and increase transparency.']],
                        ['@type' => 'Question', 'name' => 'How does WideSCOPE Intelligence™ benefit emerging biotechs?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'It enhances transparency with integrated data tools, reduces errors by up to 50%, and supports risk-based monitoring for efficient global trials.']]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'WideSCOPE Intelligence™ – Data Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how WideSCOPE Intelligence™ integrates eClinical systems for transparent, error-free clinical trials in emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'datePublished' => '2025-01-01'
                ]
            ]
        ];
    } elseif ( is_page('propatient-solutions') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        ['@type' => 'Question', 'name' => 'What is ProPATIENT Solutions™?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'ProPATIENT Solutions™ is the patient engagement strand of Accelsiors HexaHelix, developing guidelines to make studies by patients, for patients, without legislative requirements.']],
                        ['@type' => 'Question', 'name' => 'How does ProPATIENT Solutions™ benefit emerging biotechs?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'It improves retention by up to 35%, enhances data quality, and provides a competitive edge through patient-centric research.']]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'ProPATIENT Solutions™ – Patient Engagement Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how ProPATIENT Solutions™ integrates patient voices for better clinical trials in emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'datePublished' => '2025-01-01'
                ]
            ]
        ];
    } elseif ( is_page('acceshild') ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type'    => 'FAQPage',
                    'mainEntity' => [
                        ['@type' => 'Question', 'name' => 'What is ACCESHILD™?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'ACCESHILD™ is the security strand of Accelsiors HexaHelix, providing turnkey AI compliance defense through Audit, Remediation, and Governance phases.']],
                        ['@type' => 'Question', 'name' => 'How does ACCESHILD™ benefit emerging biotechs?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'It reduces AI risks by 50%, ensures multi-region compliance, and avoids delays without internal teams.']]
                    ]
                ],
                [
                    '@type' => 'Article',
                    'headline' => 'ACCESHILD™ – Security Strand of Accelsiors HexaHelix',
                    'description' => 'Learn how ACCESHILD™ shields clinical trials from AI risks with operational compliance for emerging biotechs.',
                    'author' => ['@type' => 'Organization', 'name' => 'Accelsiors'],
                    'datePublished' => '2025-01-01'
                ]
            ]
        ];
    }

    if ( $schema ) {
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'accelsiors_inject_schema');

// Register Custom Block Styles for the HexaHelix Grid
function accelsiors_register_block_styles() {
    register_block_style( 'core/columns', array(
        'name'  => 'cards-vertical',
        'label' => __( 'Vertical Cards (Poster)', 'accelsiors' ),
    ) );

    register_block_style( 'core/columns', array(
        'name'  => 'cards-horizontal',
        'label' => __( 'Horizontal Cards (Landscape)', 'accelsiors' ),
    ) );
}
add_action( 'init', 'accelsiors_register_block_styles' );

// Register Custom Pattern Category
function accelsiors_register_pattern_category() {
    register_block_pattern_category(
        'accelsiors',
        array( 'label' => __( 'Accelsiors Custom Blocks', 'accelsiors' ) )
    );
}
add_action( 'init', 'accelsiors_register_pattern_category' );

/**
 * Contact page settings defaults.
 */
function accelsiors_get_contact_settings_defaults() {
    return array(
        'hero_title'         => 'Contact us',
        'hero_description'   => 'Are you interested in learning more about how Accelsiors can create solutions to help you accelerate your clinical trials? Our team is ready to answer your questions. Get in touch with our experienced clinical research experts!',
        'linkedin_url'       => 'https://www.linkedin.com/company/accelsiors',
        'x_url'              => 'https://x.com/accelsiors',
        'facebook_url'       => 'https://www.facebook.com/accelsiors',
        'phone'              => '+41 43 508 72 37',
        'general_email'      => 'info@accelsiors.com',
        'business_email'     => 'bdglobal@accelsiors.com',
        'pv_email'           => 'pvteam@accelsiors.com',
        'hq_name'            => 'Accelsiors AG',
        'hq_address'         => "Bahnhof-Park 2, CH-6340 Baar,\nSwitzerland",
        'locations_url'      => '#',
        'dpo_name'           => 'Aron Bence Paldeak',
        'dpo_email'          => 'dataprotection@accelsiors.com',
        'privacy_notice_url' => '#',
        'contact_form_code'  => '',
    );
}

/**
 * Return merged contact page settings.
 */
function accelsiors_get_contact_settings() {
    $stored   = get_option( 'accelsiors_contact_settings', array() );
    $defaults = accelsiors_get_contact_settings_defaults();

    if ( ! is_array( $stored ) ) {
        $stored = array();
    }

    return wp_parse_args( $stored, $defaults );
}

/**
 * Sanitize contact page settings before save.
 */
function accelsiors_sanitize_contact_settings( $input ) {
    $defaults = accelsiors_get_contact_settings_defaults();
    $output   = array();

    foreach ( $defaults as $key => $default_value ) {
        $value = isset( $input[ $key ] ) ? $input[ $key ] : $default_value;

        switch ( $key ) {
            case 'hero_title':
            case 'hq_name':
            case 'dpo_name':
                $output[ $key ] = sanitize_text_field( $value );
                break;

            case 'hero_description':
            case 'hq_address':
                $output[ $key ] = sanitize_textarea_field( $value );
                break;

            case 'phone':
                $output[ $key ] = sanitize_text_field( $value );
                break;

            case 'contact_form_code':
                $output[ $key ] = sanitize_text_field( $value );
                break;

            case 'general_email':
            case 'business_email':
            case 'pv_email':
            case 'dpo_email':
                $output[ $key ] = sanitize_email( $value );
                break;

            default:
                $output[ $key ] = esc_url_raw( $value );
        }
    }

    return $output;
}

/**
 * Add contact settings section under Settings.
 */
function accelsiors_register_contact_settings_page() {
    add_options_page(
        __( 'Contact Page Settings', 'accelsiors' ),
        __( 'Contact Page', 'accelsiors' ),
        'manage_options',
        'accelsiors-contact-settings',
        'accelsiors_render_contact_settings_page'
    );
}
add_action( 'admin_menu', 'accelsiors_register_contact_settings_page' );

/**
 * Register contact settings.
 */
function accelsiors_register_contact_settings() {
    register_setting(
        'accelsiors_contact_settings_group',
        'accelsiors_contact_settings',
        array(
            'sanitize_callback' => 'accelsiors_sanitize_contact_settings',
            'default'           => accelsiors_get_contact_settings_defaults(),
            'type'              => 'array',
        )
    );
}
add_action( 'admin_init', 'accelsiors_register_contact_settings' );

/**
 * Render Contact Page settings UI.
 */
function accelsiors_render_contact_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $settings = accelsiors_get_contact_settings();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Contact Page Settings', 'accelsiors' ); ?></h1>
        <p><?php esc_html_e( 'Configure the contact page details and links used by the Contact pattern.', 'accelsiors' ); ?></p>

        <form action="options.php" method="post">
            <?php settings_fields( 'accelsiors_contact_settings_group' ); ?>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="hero_title"><?php esc_html_e( 'Hero title', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[hero_title]" id="hero_title" type="text" class="regular-text" value="<?php echo esc_attr( $settings['hero_title'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="hero_description"><?php esc_html_e( 'Hero description', 'accelsiors' ); ?></label></th>
                    <td><textarea name="accelsiors_contact_settings[hero_description]" id="hero_description" rows="4" class="large-text"><?php echo esc_textarea( $settings['hero_description'] ); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="linkedin_url"><?php esc_html_e( 'LinkedIn URL', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[linkedin_url]" id="linkedin_url" type="url" class="regular-text" value="<?php echo esc_attr( $settings['linkedin_url'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="x_url"><?php esc_html_e( 'X URL', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[x_url]" id="x_url" type="url" class="regular-text" value="<?php echo esc_attr( $settings['x_url'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="facebook_url"><?php esc_html_e( 'Facebook URL', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[facebook_url]" id="facebook_url" type="url" class="regular-text" value="<?php echo esc_attr( $settings['facebook_url'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="phone"><?php esc_html_e( 'Phone', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[phone]" id="phone" type="text" class="regular-text" value="<?php echo esc_attr( $settings['phone'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="general_email"><?php esc_html_e( 'General email', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[general_email]" id="general_email" type="email" class="regular-text" value="<?php echo esc_attr( $settings['general_email'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="business_email"><?php esc_html_e( 'Business development email', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[business_email]" id="business_email" type="email" class="regular-text" value="<?php echo esc_attr( $settings['business_email'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="pv_email"><?php esc_html_e( 'Global pharmacovigilance email', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[pv_email]" id="pv_email" type="email" class="regular-text" value="<?php echo esc_attr( $settings['pv_email'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="hq_name"><?php esc_html_e( 'Headquarters name', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[hq_name]" id="hq_name" type="text" class="regular-text" value="<?php echo esc_attr( $settings['hq_name'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="hq_address"><?php esc_html_e( 'Headquarters address', 'accelsiors' ); ?></label></th>
                    <td><textarea name="accelsiors_contact_settings[hq_address]" id="hq_address" rows="3" class="large-text"><?php echo esc_textarea( $settings['hq_address'] ); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="locations_url"><?php esc_html_e( 'Locations page URL', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[locations_url]" id="locations_url" type="url" class="regular-text" value="<?php echo esc_attr( $settings['locations_url'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dpo_name"><?php esc_html_e( 'Data protection officer name', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[dpo_name]" id="dpo_name" type="text" class="regular-text" value="<?php echo esc_attr( $settings['dpo_name'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dpo_email"><?php esc_html_e( 'Data protection officer email', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[dpo_email]" id="dpo_email" type="email" class="regular-text" value="<?php echo esc_attr( $settings['dpo_email'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="privacy_notice_url"><?php esc_html_e( 'Privacy notice URL', 'accelsiors' ); ?></label></th>
                    <td><input name="accelsiors_contact_settings[privacy_notice_url]" id="privacy_notice_url" type="url" class="regular-text" value="<?php echo esc_attr( $settings['privacy_notice_url'] ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="contact_form_code"><?php esc_html_e( 'Contact form shortcode (optional)', 'accelsiors' ); ?></label></th>
                    <td>
                        <input name="accelsiors_contact_settings[contact_form_code]" id="contact_form_code" type="text" class="large-text" value="<?php echo esc_attr( $settings['contact_form_code'] ); ?>">
                        <p class="description"><?php esc_html_e( 'Paste a shortcode (e.g. Contact Form 7). If empty, the theme fallback form is shown.', 'accelsiors' ); ?></p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Shortcode to display the mega menu.
 *
 * @return string The HTML output for the menu.
 */
function accelsiors_mega_menu_shortcode() {
    ob_start();
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => 'nav',
        'container_class'=> 'main-navigation',
        'walker'         => new Mega_Menu_Walker(),
    ) );
    return ob_get_clean();
}
add_shortcode( 'accelsiors_mega_menu', 'accelsiors_mega_menu_shortcode' );

/**
 * Register the contact page block pattern.
 */
function accelsiors_register_contact_pattern() {
    $settings = accelsiors_get_contact_settings();

    // Prepare social links HTML
    $social_links_html = '';
    if ( ! empty( $settings['linkedin_url'] ) ) {
        $social_links_html .= '<!-- wp:social-link {"url":"' . esc_url( $settings['linkedin_url'] ) . '","service":"linkedin"} /-->';
    }
    if ( ! empty( $settings['x_url'] ) ) {
        $social_links_html .= '<!-- wp:social-link {"url":"' . esc_url( $settings['x_url'] ) . '","service":"x"} /-->';
    }
    if ( ! empty( 'facebook_url' ) ) {
        $social_links_html .= '<!-- wp:social-link {"url":"' . esc_url( $settings['facebook_url'] ) . '","service":"facebook"} /-->';
    }

    // Prepare contact form shortcode
    $contact_form_shortcode = ! empty( $settings['contact_form_code'] ) ? $settings['contact_form_code'] : '<!-- wp:paragraph --><p>No contact form shortcode has been set in Settings > Contact Page.</p><!-- /wp:paragraph -->';


    register_block_pattern(
        'accelsiors-theme/contact-page',
        array(
            'title'       => __( 'Contact Page Layout', 'accelsiors-theme' ),
            'description' => __( 'A two-column layout for the contact page with details and a form.', 'accelsiors-theme' ),
            'categories'  => array( 'accelsiors' ),
            'content'     => '<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"2rem","left":"2rem"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( 'Our Headquarters' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>' . esc_html( $settings['hq_name'] ) . '</strong><br>' . nl2br( esc_html( $settings['hq_address'] ) ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( 'Contact Us' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><strong>' . esc_html( 'General Inquiries:' ) . '</strong> <a href="mailto:' . esc_attr( $settings['general_email'] ) . '">' . esc_html( $settings['general_email'] ) . '</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>' . esc_html( 'Business Development:' ) . '</strong> <a href="mailto:' . esc_attr( $settings['business_email'] ) . '">' . esc_html( $settings['business_email'] ) . '</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>' . esc_html( 'Phone:' ) . '</strong> ' . esc_html( $settings['phone'] ) . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( 'Follow Us' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:social-links {"iconColor":"text-main","iconColorValue":"#1a1a1a","className":"is-style-default"} -->
<ul class="wp-block-social-links has-icon-color is-style-default">' . $social_links_html . '</ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( 'Send us a Message' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:shortcode -->' . $contact_form_shortcode . '<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
        )
    );
}
add_action( 'init', 'accelsiors_register_contact_pattern', 11 );

/**
 * Register custom block styles.
 */
function accelsiors_register_custom_block_styles() {
    // Stacked Media & Text Block Style
    register_block_style(
        'core/media-text',
        array(
            'name'  => 'stacked',
            'label' => __( 'Stacked', 'accelsiors-theme' ),
        )
    );
}
add_action( 'init', 'accelsiors_register_custom_block_styles' );

?>
