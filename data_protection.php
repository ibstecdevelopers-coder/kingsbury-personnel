<?php include 'header.php'; ?>

<style>
    /* ---- Privacy Notice page-specific styling ----
         Reuses the site's existing design tokens, fonts and section
         patterns so this page sits visually inline with the rest of
         the site. Only additive rules live here. */

    .policy-hero {
        background: #0b1f3a;
        color: #ffffff;
        padding: 7.5rem 0 4rem;
        position: relative;
        overflow: hidden;
    }

    .policy-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 12% 20%, rgba(124, 58, 237, 0.25), transparent 55%),
            radial-gradient(circle at 88% 80%, rgba(255, 255, 255, 0.06), transparent 50%);
        pointer-events: none;
    }

    .policy-hero .site-container {
        position: relative;
        z-index: 1;
    }

    .policy-hero h1 {
        font-family: 'Playfair Display', 'Popins', serif;
        font-size: clamp(2rem, 4vw, 2.85rem);
        font-weight: 700;
        line-height: 1.15;
        margin-top: 0.75rem;
        color: #ffffff;
    }

    .policy-hero p {
        margin-top: 1rem;
        max-width: 42rem;
        color: rgba(255, 255, 255, 0.78);
        font-size: 1.0625rem;
        line-height: 1.65;
    }

    .policy-version {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.75rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.16);
        font-size: 0.8125rem;
        letter-spacing: 0.02em;
        color: rgba(255, 255, 255, 0.85);
    }

    .policy-version span {
        width: 6px;
        height: 6px;
        border-radius: 999px;
        background: #7c3aed;
        display: inline-block;
    }

    .policy-body {
        padding: 4.5rem 0 5rem;
    }

    .policy-layout {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 3.5rem;
        align-items: start;
    }

    @media (max-width: 900px) {
        .policy-layout {
            grid-template-columns: 1fr;
        }
    }

    .policy-toc {
        position: sticky;
        top: 110px;
        background: #f7f7fb;
        border: 1px solid #ececf4;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .policy-toc h2 {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin: 0 0 0.9rem;
        font-weight: 600;
    }

    .policy-toc ol {
        list-style: none;
        margin: 0;
        padding: 0;
        counter-reset: toc;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .policy-toc a {
        counter-increment: toc;
        display: flex;
        gap: 0.6rem;
        align-items: baseline;
        font-size: 0.875rem;
        color: #334155;
        text-decoration: none;
        line-height: 1.4;
        transition: color 0.15s ease;
    }

    .policy-toc a::before {
        content: counter(toc, decimal-leading-zero);
        font-size: 0.7rem;
        color: #7c3aed;
        font-weight: 600;
        flex-shrink: 0;
    }

    .policy-toc a:hover {
        color: #0b1f3a;
    }

    .policy-content section {
        padding-bottom: 2.75rem;
        margin-bottom: 2.75rem;
        border-bottom: 1px solid #ececf4;
        scroll-margin-top: 100px;
    }

    .policy-content section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .policy-content h2 {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-family: 'Playfair Display', 'Popins', serif;
        font-size: 1.375rem;
        font-weight: 700;
        color: #0b1f3a;
        margin: 0 0 1rem;
    }

    .policy-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 999px;
        background: #0b1f3a;
        color: #ffffff;
        font-size: 0.8125rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .policy-content p {
        color: #475569;
        line-height: 1.75;
        font-size: 1rem;
        margin: 0 0 0.9rem;
    }

    .policy-content p:last-child {
        margin-bottom: 0;
    }

    .policy-content ul {
        margin: 0.5rem 0 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 0.6rem;
    }

    .policy-content ul li {
        position: relative;
        padding-left: 1.6rem;
        color: #475569;
        line-height: 1.6;
        font-size: 0.975rem;
    }

    .policy-content ul li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0.05em;
        color: #7c3aed;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .policy-content a.inline-link {
        color: #7c3aed;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .policy-contact-card {
        background: #f7f7fb;
        border: 1px solid #ececf4;
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        display: grid;
        gap: 0.4rem;
        font-size: 0.975rem;
        color: #334155;
    }

    .policy-contact-card strong {
        color: #0b1f3a;
    }

    .policy-back-top {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 3rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #0b1f3a;
        text-decoration: none;
    }

    .policy-back-top:hover {
        color: #7c3aed;
    }
</style>

<head>
    <title>Data Protection Notice | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
    <section class="policy-hero" style="padding: 150px 0 60px;">
        <div class="site-container">
            <div class="eyebrow eyebrow-light"><span></span>UK GDPR &amp; Data
                Protection Act 2018</div>
            <h1>Data Protection Notice</h1>
            <p>Kingsbury Personnel's Data Protection Notice explains how we collect, use, share and protect your personal data under UK GDPR and the Data Protection Act 2018.</p>
        </div>
    </section>

    <section class="policy-body">
        <div class="site-container policy-layout">

            <aside class="policy-toc" aria-label="Privacy notice sections">
                <h2>On this page</h2>
                <ol>
                    <li><a href="#introduction">Introduction</a></li>
                    <li><a href="#information-we-collect">Our Commitment</a></li>
                    <li><a href="#how-we-collect">What Information We Collect</a></li>
                    <li><a href="#why-we-process">How We Use Your Information</a></li>
                    <li><a href="#lawful-basis">Who We Share Your Data With</a></li>
                    <li><a href="#sharing-information">How We Keep Your Data Safe</a></li>
                    <li><a href="#international-transfers">Your Rights</a></li>
                   <li><a href="#contact-us">Contact Us</a></li>
                    <li><a href="#your-rights">Our Policies</a></li>
                </ol>
            </aside>

            <article class="policy-content">

                <section id="introduction">
                    <h2><span class="policy-num">01</span>Introduction</h2>
                    <p>At Kingsbury Personnel Ltd, we handle personal information every day, including CVs, contact details, qualifications and right-to-work documents. We take that responsibility seriously. This page explains how we protect your data and what rights you have. For full detail, please read our <a class="inline-link" href="./privacy-policy.php">Privacy Policy</a>.</p>
                </section>

                <section id="information-we-collect">
                    <h2><span class="policy-num">02</span>Our Commitment</h2>
                    <p>Kingsbury Personnel complies with the UK General Data Protection Regulation (UK GDPR) and the Data Protection Act 2018. We only collect and use personal data where we have a lawful reason to do so. We keep it secure, and we are open about how we use it. We have reviewed our data processes and put appropriate technical and organisational measures in place to protect the information entrusted to us.</p>
                    <ul>
                        <li>ICO Registration Number: <strong>ZB196377</strong></li>
                        <li>Data Protection Officer: <strong>Bilal Sheikh</strong></li>
                    </ul>
                </section>

                <section id="how-we-collect">
                    <h2><span class="policy-num">03</span>What Information We Collect</h2>
                    <p><strong>Candidates:</strong> Name, address, email address, phone number, CV, work history, qualifications, professional registration details (e.g. NMC PIN), references, right-to-work documents and, where required for the role, DBS and compliance information.</p>
                    <p><strong>Clients:</strong> Business contact names, job titles, email addresses, phone numbers and details of your staffing requirements.</p>
                    <p>Some roles, particularly in care and nursing, may require us to handle sensitive information such as health or criminal-record checks. We only collect this where it is necessary for the role or legally required, and we apply extra care to it.</p>
                </section>

                <section id="why-we-process">
                    <h2><span class="policy-num">04</span>How We Use Your Information</h2>
                    <p>We use your information to:</p>
                    <ul>
                        <li>Register you and match you to suitable roles</li>
                        <li>Put you forward to employers with your knowledge</li>
                        <li>Carry out compliance and pre-employment checks</li>
                        <li>Communicate with you about opportunities and your applications</li>
                        <li>Meet our legal and regulatory obligations</li>
                    </ul>
                </section>

                <section id="lawful-basis">
                    <h2><span class="policy-num">05</span>Who We Share Your Data With</h2>
                    <p>We never sell your data or share it for third-party marketing. We only share your details with prospective employers or clients for roles you have been considered for, and with trusted service providers or regulators where necessary to deliver our services or comply with the law. Anyone we share data with is expected to protect it appropriately.</p>
                </section>

                <section id="sharing-information">
                    <h2><span class="policy-num">06</span>How We Keep Your Data Safe</h2>
                    <ul>
                        <li>Access to personal data is limited to staff who need it for their role</li>
                        <li>Data is stored on secure, access-controlled systems</li>
                        <li>Our team is trained in data protection and good security practice</li>
                        <li>We review our policies and procedures regularly</li>
                        <li>We keep personal data only as long as needed for recruitment, legal or compliance purposes, then securely delete it</li>
                    </ul>
                </section>

                <section id="international-transfers">
                    <h2><span class="policy-num">07</span>Your Rights</h2>
                    <p>Under UK data protection law, you have the right to:</p>
                    <ul>
                        <li>Be informed about how your data is used</li>
                        <li>Access the personal data we hold about you</li>
                        <li>Have inaccurate data corrected</li>
                        <li>Have your data erased, in certain circumstances</li>
                        <li>Restrict or object to how we process your data</li>
                        <li>Withdraw consent at any time, where we rely on consent</li>
                        <li>Request your data in a portable format</li>
                    </ul>
                    <p>To exercise any of these rights, please contact us using the details below. We will respond within one month of receiving your request.</p>
                </section>

                <section id="contact-us">
                    <h2><span class="policy-num">08</span>Contact Us</h2>
                    <p>If you have any questions, concerns or complaints about how we handle your data:</p>
                    <p><strong>Email:</strong> <a class="inline-link" href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a></p>
                    <p><strong>Phone:</strong> <a class="inline-link" href="tel:+441494211220">+44 (0) 1494 211220</a></p>
                    <p><strong>Post:</strong> Data Protection, Kingsbury Personnel Ltd, 124 City Road, London, England, EC1V 2NX</p>
                    <p>If you are unhappy with our response, you have the right to complain to the Information Commissioner's Office (ICO) at <a class="inline-link" href="https://www.ico.org.uk"
                            target="_blank" rel="noopener noreferrer">www.ico.org.uk</a> or telephone 0303 123 1113.</p>
                </section>

                <section id="your-rights">
                    <h2><span class="policy-num">09</span>Our Policies</h2>
                    <ul>
                        <li><a class="inline-link" href="./privacy-policy.php">Privacy Policy</a></li>
                        <li><a class="inline-link" href="./terms-conditions.php">Terms & Conditions</a></li>
                        <li><a class="inline-link" href="#cookie-settings" onclick="openCookieSettings(); return false;">Cookie Settings</a></li>
                    </ul>
                </section>

                <a href="#main-content" class="policy-back-top">↑ Back to top</a>

            </article>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>