<?php
if ( ! function_exists( 'accelsiors_theme_setup' ) ) :
	function accelsiors_theme_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
	}
endif;
add_action( 'after_setup_theme', 'accelsiors_theme_setup' );

function accelsiors_enqueue_styles() {
    wp_enqueue_style( 'accelsiors-style', get_stylesheet_uri(), array(), '1.0.1' );
    
    // Enqueue Swup.js for App-Like Transitions (Zero Cost / Open Source)
    wp_enqueue_script( 'swup', 'https://unpkg.com/swup@4', array(), '4.0', true );
    wp_enqueue_script( 'accelsiors-app', get_template_directory_uri() . '/assets/js/app.js', array('swup'), '1.1.0', true );
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
                    'logo' => get_template_directory_uri() . '/assets/images/logo.png',
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
?>