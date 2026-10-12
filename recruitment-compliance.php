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
  <title>Recruitment compliance statement | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>compliance statement</div>
      <h1>Recruitment Compliance Statement</h1>
      <p>The legal framework we work within and the checks we complete before introducing healthcare candidates.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Our legal status</a></li>
          <li><a href="#types-of-cookies">How we meet the Conduct Regulations</a></li>
          <li><a href="#how-we-use-cookies">Checks for healthcare candidates</a></li>
          <li><a href="#why-we-process">Supporting CQC-registered providers</a></li>
          <li><a href="#lawful-basis">How to manage your cookie preferences</a></li>
          <li><a href="#sharing-information">International recruitment</a></li>
          <li><a href="#international-transfers">Evidence for clients</a></li>
          <li><a href="#retention">Review</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Our legal status</h2>
          <p>Kingsbury Personnel Ltd acts as an employment agency when we introduce candidates for permanent employment with our clients, and as an employment business when we supply temporary workers who work under our direction and are paid by us. We comply with the Employment Agencies Act 1973 and the Conduct of Employment Agencies and Employment Businesses Regulations 2003. These are enforced by the Fair Work Agency.</p>
        </section>

        <section id="types-of-cookies">
          <h2><span class="policy-num">02</span>How we meet the Conduct Regulations</h2>
          <ul>
            <li>We never charge work-seekers fees for finding them work.</li>
            <li>We agree written terms with candidates before providing services, and give temporary workers a Key Information Document.</li>
            <li>We agree written terms with clients before introducing or supplying anyone.</li>
            <li>We get the information the law requires from clients about each role before we introduce a candidate.</li>
            <li>We confirm each candidate’s identity, experience, qualifications and willingness to do the work.</li>
            <li>Our job adverts state whether a role is permanent or temporary and whether we act as an employment agency or employment business.</li>
            <li>We keep the records the Regulations require for at least one year after we last provide services.</li>
          </ul>
        </section>


        <section id="how-we-use-cookies">
          <h2><span class="policy-num">03</span>Checks for healthcare candidates</h2>

          <div class="cookie-table-wrapper">
            <table class="cookie-table">
              <thead>
                <tr>
                  <th>Check</th>
                  <th>What we do</th>
                  <th>Standard</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td><strong>Identity</strong></td>
                  <td>
                    Verify photo ID against the person, using original documents
                    or a certified digital identity service
                  </td>
                  <td>
                    NHS Employment Check Standards: identity
                  </td>
                </tr>

                <tr>
                  <td><strong>Right to work</strong></td>
                  <td>
                    Home Office online check using a share code, a digital identity
                    service for British and Irish passports, or a manual document
                    check where permitted
                  </td>
                  <td>
                    Immigration, Asylum and Nationality Act 2006; Home Office
                    employer guidance
                  </td>
                </tr>

                <tr>
                  <td><strong>Professional registration</strong></td>
                  <td>
                    Check the NMC register for registration, the part of the
                    register, revalidation date, and any conditions, cautions or
                    suspensions. Re-checked before each new temporary booking and
                    at least monthly
                  </td>
                  <td>
                    NMC; NHS Employment Check Standards: professional registration
                    and qualifications
                  </td>
                </tr>

                <tr>
                  <td><strong>Qualifications and training</strong></td>
                  <td>
                    See original certificates. For temporary workers, verify
                    mandatory training such as safeguarding, moving and handling,
                    basic life support and infection control
                  </td>
                  <td>
                    NHS Employment Check Standards: employer requirements
                  </td>
                </tr>

                <tr>
                  <td><strong>Criminal record</strong></td>
                  <td>
                    Enhanced DBS with the relevant barred list for regulated
                    activity, through a registered umbrella body, or a DBS Update
                    Service status check with consent
                  </td>
                  <td>
                    DBS Code of Practice; Safeguarding Vulnerable Groups Act 2006
                  </td>
                </tr>

                <tr>
                  <td><strong>Employment history and references</strong></td>
                  <td>
                    Full employment history with gaps explained. At least two
                    references, including the most recent employer, covering at
                    least the last 3 years, verified with the referee
                  </td>
                  <td>
                    NHS Employment Check Standards: employment history and
                    references
                  </td>
                </tr>

                <tr>
                  <td><strong>Work health</strong></td>
                  <td>
                    Fitness to work declaration, reviewed by an occupational health
                    adviser where needed. Health information is kept confidential
                    and shared only with consent
                  </td>
                  <td>
                    NHS Employment Check Standards: work health assessment;
                    Equality Act 2010
                  </td>
                </tr>

                <tr>
                  <td><strong>Suitability for the role</strong></td>
                  <td>
                    Confirm the candidate has the experience and qualifications the
                    employer requires, is willing to do the work, and that no legal
                    or professional body requirement is unmet
                  </td>
                  <td>
                    Conduct Regulations 2003, regulations 19 and 20
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>Supporting CQC-registered providers</h2>
          <p>Recruitment agencies that introduce or supply staff are not themselves registered with the Care Quality Commission in England. The care providers we work with are, and under Regulation 19 of the Health and Social Care Act 2008 (Regulated Activities) Regulations 2014 they must make sure the people working for them are fit and proper. We support this by completing the checks above and giving each client a record of them, covering the information set out in Schedule 3 to those Regulations.</p>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Scotland, Wales and Northern Ireland</h2>

          <p>Rules for nurse agencies differ across the UK. Where we supply nurses into Scotland, Wales or Northern Ireland, we follow the registration and conduct requirements that apply there before accepting any booking.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>International recruitment</h2>
          <p>We follow the Code of Practice for the International Recruitment of Health and Social Care Personnel in England. <a class="inline-link" href="./overseas-recruitment.php">See our page for internationally educated nurses</a>.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>Evidence for clients</h2>
          <p>Clients receive written confirmation of each check before a candidate starts, or by the end of the third business day if we first confirm by phone. Full compliance records are available for client audit on request, shared in line with data protection law.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Review</h2>
          <p>A director is responsible for recruitment compliance. We audit a sample of candidate files every quarter and review this statement every year.</p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>