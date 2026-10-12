<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php if (isset($kpPageTitle)): ?>
        <title><?= htmlspecialchars($kpPageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
    <?php endif; ?>
    <meta name="description"
        content="Kingsbury Personnel connects businesses with exceptional talent across care, nursing, legal, and hospitality through professional recruitment and staffing solutions across the UK." />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#0b1f3a" />

    <meta property="og:title"
        content="Kingsbury Personnel Ltd. | Recruitment & Staffing Solutions" />
    <meta property="og:description"
        content="Professional recruitment and staffing solutions connecting UK businesses with exceptional talent." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.kingsburypersonnel.com/" />
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1600&q=80" />

    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Popins+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Popins', 'sans-serif'],
                        display: ['Playfair Display', 'Popins']
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/jobs.css" />

    <!-- Meta Pixel Code -->
    <link rel="preconnect" href="https://connect.facebook.net" crossorigin />
    <link rel="preconnect" href="https://www.facebook.com" />
  
</head>

<body class="bg-white text-slate-900 antialiased">
    <?php if (!empty($kpIsIndexPage)): ?>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=3711907918949422&ev=PageView&noscript=1"
                alt="" /></noscript>
    <?php endif; ?>
    <!-- End Meta Pixel Code -->
    <a href="#main-content" class="skip-link">Skip to content</a>

    <header id="site-header" class="site-header" aria-label="Primary">
        <div class="site-container header-inner">
            <a href="./index.php" class="brand" aria-label="Kingsbury Personnel Ltd.">
                <img src="./assets/images/Kingsbury-Personnel-Logo.png"
                    alt="Kingsbury Personnel Ltd." class="site-logo" />
            </a>

            <nav class="desktop-nav" aria-label="Main navigation">
                <a href="./index.php">Home</a>
                <a href="./search-job.php">Search Job</a>
                <a href="./index.php#about">About</a>
                <a href="./index.php#expertise">Expertise</a>
                <a href="./data_protection.php">Data Protection</a>
                <a href="./index.php#how-it-works">How It Works</a>
                <a href="./index.php#faqs">FAQs</a>
                <a href="./contact.php">Contact</a>
            </nav>

            <div class="header-actions">
                <a href="./contact.php" class="btn btn-primary header-cta">Register Your CV</a>
                <button id="menu-toggle" class="menu-toggle" type="button"
                    aria-controls="mobile-menu" aria-expanded="false"
                    aria-label="Open navigation">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <nav id="mobile-menu" class="mobile-menu" aria-label="Mobile navigation"
            aria-hidden="true">
            <div class="site-container mobile-menu-inner">
                <a href="./index.php">Home</a>
                <a href="./search-job.php">Search Job</a>
                <a href="./index.php#about">About</a>
                <a href="./index.php#expertise">Expertise</a>
                <a href="./data_protection.php">Data Protection</a>
                <a href="./index.php#how-it-works">How It Works</a>
                <a href="./index.php#faqs">FAQs</a>
                <a href="./contact.php">Contact</a>
                <a href="./contact.php" class="btn btn-primary">Register Your CV</a>
            </div>
        </nav>
    </header>