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

  .healthcare-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    align-items: start;
    gap: clamp(2rem, 5vw, 4.5rem);
  }

  .healthcare-info-grid h2 {
    margin: 0 0 1rem;
    color: var(--navy);
    font-size: clamp(1.5rem, 2.2vw, 2rem);
  }

  .healthcare-info-grid ul {
    display: grid;
    gap: 0.55rem;
    padding-left: 1.25rem;
  }

  .compliance-panel {
    background: #fff;
    border: 1px solid #e1e7ed;
    border-radius: 8px;
    padding: clamp(1.25rem, 3vw, 2rem);
  }

  .compliance-panel h3 {
    margin: 0 0 1rem;
    color: var(--navy);
    font-size: 1.2rem;
  }

  .compliance-checklist {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    gap: 0.8rem;
  }

  .compliance-checklist li {
    position: relative;
    padding-left: 1.5rem;
    color: #475569;
    line-height: 1.65;
  }

  .compliance-checklist li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--gold);
    font-weight: 700;
  }

  @media (max-width: 900px) {
    .healthcare-info-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
<style>
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

  .policy-content h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: 'Playfair Display', 'Popins', serif;
    font-size: 1rem;
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


  .cookie-table-wrapper {
    width: 100%;
    overflow-x: auto;
    margin-top: 20px;
  }

  .cookie-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #f7f7f7;
    border: 1px solid #dcdcdc;
    border-radius: 9px;
    overflow: hidden;
    font-family: inherit;
    color: #222;
  }

  .cookie-table th,
  .cookie-table td {
    padding: 11px 13px;
    text-align: left;
    vertical-align: top;
    border-bottom: 1px solid #dcdcdc;
    line-height: 1.35;
  }

  .cookie-table th {
    background: #eeeeee;
    font-weight: 500;
    font-size: 16px;
  }

  .cookie-table td {
    font-size: 16px;
    font-weight: 400;
  }

  /* Column widths */
  .cookie-table th:nth-child(1),
  .cookie-table td:nth-child(1) {
    width: 22%;
  }

  .cookie-table th:nth-child(2),
  .cookie-table td:nth-child(2) {
    width: 29%;
  }

  .cookie-table th:nth-child(3),
  .cookie-table td:nth-child(3) {
    width: 23%;
  }

  .cookie-table th:nth-child(4),
  .cookie-table td:nth-child(4) {
    width: 13%;
  }

  .cookie-table th:nth-child(5),
  .cookie-table td:nth-child(5) {
    width: 13%;
  }

  /* Remove bottom border from final row */
  .cookie-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Rounded corners */
  .cookie-table thead tr:first-child th:first-child {
    border-top-left-radius: 9px;
  }

  .cookie-table thead tr:first-child th:last-child {
    border-top-right-radius: 9px;
  }

  .cookie-table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 9px;
  }

  .cookie-table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 9px;
  }

  /* Mobile */
  @media (max-width: 700px) {
    .cookie-table {
      min-width: 700px;
    }

    .cookie-table th,
    .cookie-table td {
      padding: 10px 12px;
      font-size: 14px;
    }
  }
</style>

<head>
  <title>Healthcare Recruitment Services | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="service-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>Employers</div>
      <h1>Healthcare Recruitment Services</h1>
      <p>Permanent recruitment and temporary staffing for care homes and healthcare providers, with a complete compliance file for every candidate.</p>
    </div>
  </section>

  <section class="section">
    <div class="site-container healthcare-info-grid">
      <div class="policy-content">
        <h2>What we provide</h2>
        <ol class="steps steps--stack">
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">01</span> Permanent recruitment</h3>
            <p>We search, screen and introduce candidates for permanent posts. You interview and employ the candidate directly. Our fee and rebate terms are set out in our terms of business, which we send before any introduction.</p>
          </li>
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">02</span> Temporary and contract staffing</h3>
            <p>We supply checked temporary workers to cover vacancies, leave and short-term demand. For this work we act as an employment business and agree terms with you before the first assignment.</p>
          </li>
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">03</span> Leadership roles</h3>
            <p>We recruit registered managers, deputy managers and clinical leads, including confidential searches where a current post-holder is still in role.</p>
          </li>
        </ol>
      </div>
      <div class="policy-content">
        <h2>Settings we work in</h2>
        <ul>
          <li>Nursing homes and residential care homes</li>
          <li>Supported living services</li>
          <li>Learning disability and autism services</li>
          <li>Mental health services</li>
          <li>Community nursing</li>
          <li>Nurseries and early years settings</li>
        </ul>
      </div>
    </div>
  </section>
  <section class="section section-soft" id="compliance"
    aria-labelledby="compliance-title">
    <div class="site-container healthcare-info-grid">
      <div class="policy-content">
        <h2 id="compliance-title">Supporting your regulatory duties</h2>
        <p>Care providers registered with the Care Quality Commission must
          be able to show that the people working for them are fit and
          proper, under Regulation 19 of the Health and Social Care Act 2008
          (Regulated Activities) Regulations 2014. We carry out the checks
          that support this and give you the evidence.</p>
        <p>Our checks follow the six NHS Employment Check Standards:
          identity, right to work, professional registration and
          qualifications, employment history and references, criminal record
          checks, and work health assessments.</p>
        <a class="btn btn-secondary"
          href="./recruitment-compliance.php">Read our recruitment compliance
          statement</a>
      </div>
      <div class="compliance-panel">
        <h3>What you receive with each candidate</h3>
        <ul class="compliance-checklist">
          <li>Confirmation of NMC registration status and revalidation date</li>
          <li>Enhanced DBS details and barred list check result</li>
          <li>Right to work check record</li>
          <li>Two references, including the most recent employer</li>
          <li>Full employment history with gaps explained</li>
          <li>Fitness to work declaration</li>
          <li>Mandatory training records for temporary workers</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="final-cta-section" style="margin-top: 6rem">
    <div class="site-container final-cta reveal">
      <div class="final-cta-pattern"></div>
      <div>
        <span class="eyebrow eyebrow-light"><span></span>Care roles</span>
        <h2>Tell us what you need</h2>
        <p>A consultant will call you to understand the role and agree terms before we introduce anyone.</p>
      </div>
      <div class="final-cta-actions">
        <a href="./employers.php" class="btn btn-gold btn-lg">Request Staff</a>
        <a href="./contact.php" class="btn btn-outline-light btn-lg">Contact Us</a>
      </div>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>