<?php include 'header.php'; ?>

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
  <title>Modern slavery statement | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>legal</div>
      <h1>Modern slavery statement</h1>
      <p>The steps we take to prevent modern slavery and exploitation in recruitment.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Introduction</a></li>
          <li><a href="#types-of-cookies">Our business</a></li>
          <li><a href="#how-we-use-cookies">Where the risks are</a></li>
          <li><a href="#why-we-process">Our policies</a></li>
          <li><a href="#lawful-basis">Due diligence and warning signs</a></li>
          <li><a href="#sharing-information">Training</a></li>
          <li><a href="#international-transfers">How to report a concern</a></li>
          <li><a href="#retention">Approval</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Introduction</h2>
          <p>This statement sets out the steps Kingsbury Personnel Ltd takes to prevent modern slavery and human trafficking in our business and supply chains. Section 54 of the Modern Slavery Act 2015 requires a statement from organisations with a turnover of £36 million or more. We publish this statement voluntarily, because recruitment, and international recruitment into health and social care in particular, carries known risks of exploitation.</p>
        </section>

        <section id="types-of-cookies">
          <h2><span class="policy-num">02</span>Our business</h2>
          <p>We are a UK recruitment agency and employment business. We introduce candidates to employers for permanent roles and supply temporary workers, mainly to care homes and healthcare providers, and also in early years, hospitality and legal services. Our supply chain includes our clients, job boards, a DBS umbrella body, payroll and IT service providers.</p>
        </section>


        <section id="how-we-use-cookies">
          <h2><span class="policy-num">03</span>Where the risks are</h2>
<ul>
<li>Candidates being charged illegal recruitment fees by third parties, in the UK or abroad</li>
<li>Candidates being controlled by someone else who holds their documents, wages or bank account</li>
<li>Debt bondage linked to travel, visa or training costs</li>
<li>Clients or other agencies exploiting workers after placement</li>
</ul>
        </section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>Our policies</h2>
          <ul>
          <li>We never charge work-seekers fees, in line with section 6 of the Employment Agencies Act 1973.</li>
          <li>We follow the Code of Practice for International Recruitment, including no active recruitment from red list countries.</li>
          <li>Our <a class="inline-link" href="./safeguarding.php">safeguarding statement</a>, <a class="inline-link" href="./equal-opportunities.php">equal opportunities policy</a> and whistleblowing arrangements.</li>
          <li>We pay temporary workers directly into bank accounts in their own name, at or above the National Minimum Wage.</li>
          </ul>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Due diligence and warning signs</h2>

          <p>During registration and compliance checks our consultants look for signs of exploitation, including:</p>
          <ul>
          	<li>several candidates sharing the same address, phone number, email or bank account</li>
            <li>a third party speaking for the candidate, attending interviews or holding their documents</li>
            <li>a candidate who cannot tell us their own address or who does not control their passport</li>
            <li>reluctance to meet or talk without someone else present</li>
            <li>signs that the candidate has paid someone to get the job or visa</li>
          </ul>
          <p>If we have concerns, we speak to the candidate privately, do not proceed with the placement until we are satisfied, and report to the Modern Slavery and Exploitation Helpline, the Fair Work Agency or the police as appropriate.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Training</h2>
          <p>All consultants receive training on recognising modern slavery, labour exploitation and illegal fee-charging when they join, with a refresher every year.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>How to report a concern</h2>
          <p>If you are worried that someone is being exploited, call the Modern Slavery and Exploitation Helpline on 08000 121 700, or report it to the Fair Work Agency. If someone is in immediate danger, call 999. You can also tell us in confidence at <a class="inline-link" href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a>.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Approval</h2>
          <p>This statement was approved by the board of Kingsbury Personnel Ltd and covers the financial year ending 2026. We review it every year.</p>
          <p>Signed on behalf of the board: Director, Kingsbury Personnel Ltd. Date: September 2026.</p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>