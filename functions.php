<?php
if ( ! function_exists( 'accelsiors_theme_setup' ) ) :
	function accelsiors_theme_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
	}
endif;
add_action( 'after_setup_theme', 'accelsiors_theme_setup' );

// Auto-Inject Schema Markup based on Docs
function accelsiors_inject_schema() {
    $schema = null;

    if ( is_front_page() ) {
        // Organization Schema [Source: 193]
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'Accelsiors',
            'url'      => home_url(),
            'description' => 'Accelsiors is a global CRO accelerating life-changing therapies...',
            // Add logo URL here dynamically if needed
        ];
    } 
    
    // Example for ACCESHILD sub-page
    if ( is_page('acceshild') ) {
        // [Source: 408]
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'What is ACCESHILD™?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'ACCESHILD™ is the security strand of Accelsiors HexaHelix...'
                    ]
                ]
            ]
        ];
    }

    if ( $schema ) {
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'accelsiors_inject_schema');
?>