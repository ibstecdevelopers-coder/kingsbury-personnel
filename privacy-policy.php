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
    <title>Privacy Policy | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>Privacy Policy</div>
      <h1>Privacy Notice</h1>
      <p>This notice explains how Kingsbury Personnel Ltd collects, uses,
        shares and protects your personal
        information as a recruitment agency and employment business
        providing permanent and temporary
        recruitment services.</p>
      <div class="policy-version"><span></span>Version 2.0</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Introduction</a></li>
         <!-- <li><a href="#contact-details">Contact Details</a></li> -->
          <li><a href="#information-we-collect">Information We
              Collect</a></li>
          <li><a href="#how-we-collect">How We Collect Information</a></li>
          <li><a href="#why-we-process">Why We Process Your Data</a></li>
          <li><a href="#lawful-basis">Lawful Basis</a></li>
          <li><a href="#sharing-information">Sharing Information</a></li>
          <li><a href="#international-transfers">International
              Transfers</a></li>
          <li><a href="#retention">Retention</a></li>
          <li><a href="#your-rights">Your Rights</a></li>
          <li><a href="#security">Security</a></li>
          <li><a href="#complaints">Complaints</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Introduction</h2>
          <p>Kingsbury Personnel Ltd is a recruitment agency and employment
            business providing permanent and
            temporary recruitment services. We process personal information
            in accordance with the UK GDPR and
            the Data Protection Act 2018.</p>
        </section>

       <!-- <section id="contact-details">
          <h2><span class="policy-num">02</span>Contact Details</h2>
          <div class="policy-contact-card">
            <div><strong>Company:</strong> Kingsbury Personnel Ltd</div>
            <div><strong>Contact:</strong> Bilal Sheikh</div>
            <div><strong>Telephone:</strong> <a class="inline-link"
                href="tel:+441494211220">+44 (0) 1494 211220</a></div>
            <div><strong>Email:</strong> <a class="inline-link"
                href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a></div>
          </div>
        </section> -->

        <section id="information-we-collect">
          <h2><span class="policy-num">02</span>Information We Collect</h2>
          <p>We may collect:</p>
          <ul>
            <li>Name and contact details</li>
            <li>CV and employment history</li>
            <li>Qualifications and professional registrations</li>
            <li>Right to Work documents</li>
            <li>DBS/criminal record information where required</li>
            <li>References</li>
            <li>Bank details for payroll</li>
            <li>Health/disability information where relevant</li>
            <li>Training records</li>
            <li>Emergency contact details</li>
          </ul>
        </section>

        <section id="how-we-collect">
          <h2><span class="policy-num">03</span>How We Collect
            Information</h2>
          <p>Directly from you, job boards, referrals, referees, clients,
            publicly available professional
            profiles, and third-party recruitment partners.</p>
        </section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>Why We Process Your
            Data</h2>
          <p>To:</p>
          <ul>
            <li>Match you to vacancies</li>
            <li>Submit your CV to clients (with appropriate lawful
              basis)</li>
            <li>Arrange interviews</li>
            <li>Verify identity and Right to Work</li>
            <li>Obtain references</li>
            <li>Process payroll</li>
            <li>Meet legal and regulatory obligations</li>
            <li>Improve our recruitment services</li>
          </ul>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Lawful Basis</h2>
          <p>We rely on:</p>
          <ul>
            <li>Consent</li>
            <li>Performance of a contract</li>
            <li>Legitimate interests</li>
            <li>Legal obligations</li>
          </ul>
          <p style="margin-top: 0.9rem;">Special category data is processed
            only where permitted by UK GDPR.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Sharing Information</h2>
          <p>We may share information with prospective employers, clients,
            payroll providers, DBS providers,
            training providers, HMRC, pension providers, regulators, legal
            advisers and IT providers where
            necessary.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>International Transfers</h2>
          <p>We do not routinely transfer personal data outside the UK.
            Where transfers occur, appropriate
            safeguards will be implemented.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Retention</h2>
          <p>We retain data only as long as necessary and in line with legal
            and regulatory requirements,
            including the Conduct of Employment Agencies and Employment
            Businesses Regulations 2003 and HMRC
            obligations.</p>
        </section>

        <section id="your-rights">
          <h2><span class="policy-num">09</span>Your Rights</h2>
          <p>You have the right to:</p>
          <ul>
            <li>Access your data</li>
            <li>Correct inaccurate data</li>
            <li>Request deletion where applicable</li>
            <li>Restrict processing</li>
            <li>Object to processing</li>
            <li>Data portability</li>
            <li>Withdraw consent where consent is relied upon</li>
            <li>Lodge a complaint with the ICO</li>
          </ul>
        </section>

        <section id="security">
          <h2><span class="policy-num">10</span>Security</h2>
          <p>We maintain appropriate technical and organisational measures
            to protect your information from
            unauthorised access, loss or misuse.</p>
        </section>

        <section id="complaints">
          <h2><span class="policy-num">11</span>Complaints</h2>
          <p>If you have any concerns, contact at <a
              class="inline-link" href="tel:+441494211220">+44 (0) 1494
              211220</a> or <a class="inline-link"
              href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a>.
            You may also complain to the <strong>Information Commissioner's Office
            (ICO)</strong> via
            <a class="inline-link" href="https://www.ico.org.uk"
              target="_blank" rel="noopener noreferrer">www.ico.org.uk</a>
            or telephone 0303 123 1113.
          </p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>