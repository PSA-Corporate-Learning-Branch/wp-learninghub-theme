<!doctype html>
<html <?php language_attributes(); ?> data-bs-theme="light">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<?php wp_head(); ?>
</head>
<body class="bg-body-secondary">
<?php wp_body_open(); ?>

<header id="mainheader" role="banner" class="sticky-top">
    <nav class="navbar navbar-expand-lg px-3 bg-dark-subtle" role="navigation" aria-label="<?php esc_attr_e('Primary menu', 'twentytwentyone'); ?>">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="wordmark navbar-brand order-lg-first me-lg-3">
                <?php //the_custom_logo(); 
                ?>
                Learning<span style="color: #ebba44; font-weight: bold;">HUB</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                <span class="search-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 order-1 order-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/learninghub/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/learninghub/about/" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            About</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/learninghub/about/">About the LearningHUB</a></li>
                            <li><a class="dropdown-item" href="/learninghub/corporate-learning-partners/">Learning Partners</a></li>
                            <li><a class="dropdown-item" href="/learninghub/what-is-corp-learning-framework/">Corporate Learning Framework</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/learninghub/learning-systems/">
                            Learning Platforms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/learninghub/filter/">All Courses</a>
                    </li>
                </ul>
            </div>
            <form method="get" action="/learninghub/" class="collapse navbar-collapse mt-1 mt-lg-0" role="search" id="navbarSearch">
                <label for="s" class="sr-only">Search</label>
                <input type="search" id="s" class="s bg-white text-black flex-grow-1 flex-shrink-1 me-1" name="s" placeholder="Find learning" required value="<?= esc_html(get_search_query()) ?>">
                <button type="submit" class="searchsubmit" aria-label="Submit Search">
                    Search
                </button>
            </form>
        </div>
    </nav>
</header><!-- #masthead -->
</div>


