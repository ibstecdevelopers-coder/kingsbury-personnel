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
  <title>Safeguarding Statement | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>legal</div>
      <h1>Safeguarding Statement</h1>
      <p>How we protect vulnerable adults and children through safer recruitment.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">
      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Our commitment</a></li>
          <li><a href="#types-of-cookies">The law we follow</a></li>
          <li><a href="#how-we-use-cookies">Safer recruitment</a></li>
          <li><a href="#why-we-process">Our duty to refer</a></li>
          <li><a href="#lawful-basis">How we respond to concerns</a></li>
          <li><a href="#sharing-information">Safeguarding lead</a></li>
          <li><a href="#international-transfers">How to report a concern</a></li>
          <li><a href="#retention">Whistleblowing</a></li>
          <li><a href="#training">Training and review</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Our commitment</h2>
          <p>The candidates we place work with some of the most vulnerable people in society: older people, people with dementia, disabled adults, people with mental health needs, and children. Safeguarding them is part of every recruitment decision we make.</p>
        </section>

        <section id="types-of-cookies">
          <h2><span class="policy-num">02</span>The law we follow</h2>
          <ul>
        <li>The Care Act 2014 and statutory guidance on safeguarding adults</li>
        <li>The Children Act 1989 and 2004, and Working Together to Safeguard Children 2023</li>
        <li>The Safeguarding Vulnerable Groups Act 2006</li>
        <li>The Early Years Foundation Stage safeguarding requirements, for nursery roles</li>
        <li>The Rehabilitation of Offenders Act 1974 and the DBS Code of Practice</li>
    </ul>
        </section>


        <section id="how-we-use-cookies">
          <h2><span class="policy-num">03</span>Safer recruitment</h2>
          <p>For every role involving vulnerable adults or children we:</p>
<ul>
        <li>Verify identity using original documents or approved digital checks.</li>
        <li>Request an enhanced DBS check with the adults’ and/or children’s barred list where the role is eligible, or verify an existing certificate through the DBS Update Service with the candidate’s consent.</li>
        <li>Check professional registration and any conditions, including on the NMC register.</li>
        <li>Obtain at least two references, including the most recent employer, and verify them with the referee.</li>
        <li>Check the full employment history and explore any gaps.</li>
        <li>Ask about the reasons for leaving roles involving vulnerable people.</li>
        <li>Interview every candidate before introduction.</li>
    </ul>
        </section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>Our duty to refer</h2>
         <p>As a personnel supplier under the Safeguarding Vulnerable Groups Act 2006, we have a legal duty to refer a person to the Disclosure and Barring Service if we stop supplying them because they have harmed, or posed a risk of harm to, a child or vulnerable adult. We will also refer registered nurses to the Nursing and Midwifery Council where there is a concern about their fitness to practise.</p>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>How we respond to concerns</h2>

          <ul>
        <li>We act on every concern the day we receive it.</li>
        <li>We share information with the employer, the local authority safeguarding team and the police where needed to protect people.</li>
        <li>Where a temporary worker is the subject of a serious allegation, we stop supplying them while the matter is investigated.</li>
        <li>We keep a record of concerns, actions and outcomes.</li>
    </ul>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Safeguarding lead</h2>
          <p>A named director is responsible for safeguarding at Kingsbury. Contact our safeguarding lead at <a class="inline-link" href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a> or on <a class="inline-link" href="tel:+441494211220">+44 (0)1494 211220</a>.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>How to report a concern</h2>
          <div class="policy-contact-card" style="margin-top: 1.25rem;">
            <div><strong>If someone is in immediate danger, call 999.</strong></div>
            <div>If you are worried about an adult or child in a care, nursing or childcare setting, contact the local authority safeguarding team for the area where they live. Then tell us, so we can act too.</div>
          </div>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Whistleblowing</h2>
          <p>Our candidates and workers can raise concerns about wrongdoing or poor practice in confidence, and are protected by the Public Interest Disclosure Act 1998. Free advice is available from the whistleblowing charity <a class="inline-link" href="https://protect-advice.org.uk/">Protect</a>.</p>
        </section>
        <section id="training">
          <h2><span class="policy-num">09</span>Training and review</h2>
          <p>All consultants complete safeguarding training when they join and every year after. We review this statement every year and after any serious incident.</p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>