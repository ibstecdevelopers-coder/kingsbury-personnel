<?php include 'header.php'; ?>

<style>
    .service-hero {
        background: #0b1f3a;
        color: #fff;
        padding: 7.5rem 0 4rem;
        position: relative;
        overflow: hidden;
    }

    .service-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 12% 20%, rgba(124, 58, 237, 0.24), transparent 52%),
            radial-gradient(circle at 88% 80%, rgba(255, 255, 255, 0.06), transparent 48%);
        pointer-events: none;
    }

    .service-hero .site-container {
        position: relative;
        z-index: 1;
    }

    .service-hero h1 {
        font-family: 'Playfair Display', 'Popins', serif;
        font-size: clamp(2.1rem, 4vw, 3rem);
        font-weight: 700;
        line-height: 1.12;
        margin: 0.8rem 0 0;
        color: #fff;
    }

    .service-hero p {
        max-width: 42rem;
        margin-top: 1rem;
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.0625rem;
        line-height: 1.65;
    }

    .service-page {
        padding: 4rem 0 1.25rem;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 2rem;
    }

    .feature-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 18px;
        padding: 2rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.04);
    }

    .feature-card h2 {
        margin: 0 0 1rem;
        font-family: 'Playfair Display', 'Popins', serif;
        font-size: 2rem;
        color: #0b1f3a;
        line-height: 1.2;
    }

    .feature-card p {
        margin: 0;
        color: #475569;
        line-height: 1.8;
        font-size: 1rem;
    }

    .feature-card+.feature-card h2 {
        margin-top: 0;
    }

    .notice-box {
        margin-top: 1.5rem;
        background: #fff9ec;
        border: 1px solid rgba(198, 131, 29, 0.22);
        border-left: 4px solid #c6831d;
        border-radius: 14px;
        padding: 1.2rem 1.25rem;
    }

    .notice-box h3 {
        margin: 0 0 0.55rem;
        font-size: 1.05rem;
        color: #0b1f3a;
    }

    .notice-box p {
        margin: 0;
        color: #475569;
        line-height: 1.7;
    }

    .check-section {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }

    .check-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 2rem;
    }

    .check-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 0.9rem;
    }

    .check-list li {
        position: relative;
        padding-left: 1.5rem;
        color: #334155;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .check-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0.1em;
        color: #7c3aed;
        font-weight: 700;
    }

    @media (max-width: 900px) {

        .feature-grid,
        .check-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<head>
    <title>Care Home Recruitment | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
    <section class="service-hero" style="padding: 150px 0 60px;">
        <div class="site-container">
            <div class="eyebrow eyebrow-light"><span></span>Candidates</div>
            <h1>Care Home Recruitment</h1>
            <p>Care workers, senior carers, nurses and managers for nursing and residential care homes across the UK.</p>
        </div>
    </section>

    <section class="section service-page">
        <div class="site-container">
            <div class="feature-grid">
                <article class="feature-card">
                    <h2>For care workers</h2>
                    <p>We recruit care and support workers, senior care workers and team leaders for residential care, nursing homes and supported living. Experience of dementia care, personal care and learning disability support is welcome, and many roles offer training for people new to care.</p>

                    <div class="notice-box">
                        <h3>You need the right to work in the UK</h3>
                        <p>Since 22 July 2025, employers can no longer sponsor people from overseas for care worker or senior care worker roles. To apply for these roles you must already have the right to work in the UK. If you are already in the UK on a Skilled Worker visa as a care worker, some options to change employer may still apply. Speak to a regulated immigration adviser. We cannot give immigration advice.</p>
                    </div>
                </article>

                <article class="feature-card">
                    <h2 id="managers">For care home managers</h2>
                    <p>We recruit registered managers and deputy managers for adult nursing and residential services, and for children’s homes registered with Ofsted. Senior roles are often confidential. We handle them discreetly and share details only with candidates who meet the brief.</p>
                    <div style="height: 1.25rem;"></div>
                    <h2 style="margin-top: 0;">For care home operators</h2>
                    <p>We fill permanent posts and supply temporary cover with candidates whose checks are complete and documented. <a href="contact.php" class="inline-link">See how we work with employers</a>.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--tint check-section">
        <div class="site-container">
            <div class="section-heading">
                <span class="eyebrow"><span></span>Checks</span>
                <h2>Checks for care roles</h2>
            </div>

            <div class="check-grid">
                <ul class="check-list">
                    <li>Identity and right to work</li>
                    <li>Enhanced DBS with the adults’ barred list, and the children’s barred list where the role requires it</li>
                    <li>Two references, including the most recent care employer</li>
                </ul>

                <ul class="check-list">
                    <li>Full employment history, with gaps explained</li>
                    <li>Care Certificate or relevant qualifications where held</li>
                    <li>Fitness to work declaration</li>
                </ul>
            </div>
        </div>
    </section>

   <section class="final-cta-section">
        <div class="site-container final-cta reveal">
            <div class="final-cta-pattern"></div>
            <div>
                <span class="eyebrow eyebrow-light"><span></span>Care roles</span>
                <h2>Looking for a care role?</h2>
                <p>Send your CV and we will match you with homes near you.</p>
            </div>
            <div class="final-cta-actions">
                <a href="./contact.php" class="btn btn-gold btn-lg">Register Your CV</a>
                <a href="search-job.php" class="btn btn-outline-light btn-lg">See Care Vacancies</a>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>