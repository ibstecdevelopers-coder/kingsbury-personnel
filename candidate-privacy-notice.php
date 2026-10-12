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
    <title>Candidate Privacy Notice | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>LEGAL NOTICE</div>
      <h1>Candidate Privacy Notice</h1>
      <p>How we use your personal data when you look for work through us.</p>
      <div class="policy-version"><span></span>Last updated: September 2026. Version 1.0</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Who this notice is for</a></li>
          <li><a href="#types-of-cookies">Who we are</a></li>
          <li><a href="#how-we-use-cookies">What we collect and where from</a></li>
          <li><a href="#why-we-process">How we use it and our lawful basis</a></li>
          <li><a href="#lawful-basis">Special category and criminal offence data</a></li>
          <li><a href="#sharing-information">Who we share it with</a></li>
          <li><a href="#international-transfers">WhatsApp and international transfers</a></li>
          <li><a href="#retention">How long we keep it</a></li>
          <li><a href="#automated">Automated decisions</a></li>
          <li><a href="#your_rights">Your rights</a></li>
          <li><a href="#doyouhave">Do you have to give us your data?</a></li>
          <li><a href="#complaints">Complaints</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Who this notice is for</h2>
          <p>This notice is for anyone who registers with us to find work, anyone we place in a permanent role or supply for temporary work, and people who give references for our candidates. It explains what we collect, why, who we share it with and your rights.</p>
        </section>

        <section id="types-of-cookies">
    <h2><span class="policy-num">02</span>Who we are</h2>
<div class="policy-contact-card" style="margin-top: 1.25rem;">
            <div><strong>Controller:</strong> Kingsbury Personnel Ltd.</div>
            <div><strong>Company number:</strong> 11804530 (registered in England and Wales)</div>
            <div><strong>Registered office:</strong> 124 City Road, London, EC1V 2NX</div>
            <div><strong>ICO registration:</strong> ZB196377</div>
            <div><strong>Data protection contact:</strong> Our Data Protection Lead, at <a class="inline-link"
                href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a> by post to the address above marked “Data Protection”, or on <a class="inline-link"
                href="tel:+441494211220">+44 (0) 1494 211220</a>.</div>
          </div>
          <p style="margin-top: 1.25rem;">When we introduce you for a permanent role we act as an employment agency. When we supply you for temporary work we act as an employment business.</p>
</section>


       <section id="how-we-use-cookies">
  <h2><span class="policy-num">03</span>What we collect and where from</h2>
<p>We collect personal data from you directly, and from job boards where you have posted your CV, referees, previous employers, the NMC register, the Disclosure and Barring Service (through an umbrella body), the Home Office right to work service, and employers you are introduced to (for example, interview feedback).</p>
<p>At registration we ask for your contact details, profession, preferred region and type of work, your right to work status and your CV. If you progress towards a role, we will also ask for identity and right to work documents, your NMC PIN or other registration, qualification certificates, referee details, DBS details and a fitness to work declaration. If you take temporary work, we need bank, tax and National Insurance details.</p>
<p>Please do not include your date of birth, photograph or health information in your CV. We do not need them to consider you.</p>
  
</section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>How we use it and our lawful basis</h2>
          <div class="cookie-table-wrapper">
    <table class="cookie-table">
    <h3>Why we use your data</h3>
                    <thead>
                        <tr>
                            <th scope="col">Purpose</th>
                            <th scope="col">Personal data used</th>
                            <th scope="col">Lawful basis</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        <th scope="row">Registering you and finding suitable
                        roles</th><td>Contact details, CV, work history,
                        qualifications, preferences</td><td>Legitimate interests
                        (providing work-finding services you asked for); steps
                        before a contract</td></tr><tr><th
                        scope="row">Introducing you to employers</th><td>CV,
                        experience, check results relevant to the
                        role</td><td>Legitimate interests, and only with your
                        agreement for each employer</td></tr><tr><th
                        scope="row">Checking identity and right to
                        work</th><td>Passport, visa, share code, identity
                        documents</td><td>Legal obligation (Immigration, Asylum
                        and Nationality Act 2006)</td></tr><tr><th
                        scope="row">Checking professional
                        registration</th><td>NMC PIN, register status,
                        revalidation date, conditions</td><td>Legal obligation
                        and legitimate interests (Conduct Regulations 2003,
                        regulation 19–22)</td></tr><tr><th scope="row">Criminal
                        record checks</th><td>DBS certificate details and barred
                        list results</td><td>Legal obligation; see special
                        category section below</td></tr><tr><th
                        scope="row">Taking up references and checking employment
                        history</th><td>Referee details, reference content,
                        employment dates</td><td>Legitimate interests; legal
                        obligation to check suitability</td></tr><tr><th
                        scope="row">Fitness to work</th><td>Health declaration
                        relevant to the role</td><td>Legal obligation; see
                        special category section below</td></tr><tr><th
                        scope="row">Paying temporary workers</th><td>Bank
                        details, National Insurance number, tax code, pension
                        details</td><td>Contract and legal obligation (HMRC,
                        auto-enrolment)</td></tr><tr><th scope="row">Keeping
                        records required by law</th><td>Records of services
                        provided</td><td>Legal obligation (Conduct Regulations
                        2003, regulation 29)</td></tr><tr><th scope="row">Job
                        alerts by email or WhatsApp</th><td>Contact details,
                        profession</td><td>Consent, which you can withdraw at
                        any time</td></tr><tr><th scope="row">Equal
                        opportunities monitoring</th><td>Anonymous monitoring
                        answers, if you choose to give them</td><td>Consent; DPA
                        2018 Schedule 1 paragraph 8</td></tr><tr><th
                        scope="row">Safeguarding referrals</th><td>Relevant
                        information about concerns</td><td>Legal obligation
                        (Safeguarding Vulnerable Groups Act
                        2006)</td></tr></tbody></table>
  </div>
        
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Special category and criminal offence data</h2>
          <p>Some roles require health information (for fitness to work and reasonable adjustments) and criminal record information (DBS checks). These have extra protection.</p>
          <ul><li><strong>Health information</strong> is processed under UK
                  GDPR Article 9(2)(b) (employment and social security
                  obligations) and Data Protection Act 2018 Schedule 1, Part 1,
                  paragraph 1. We only collect what the role requires and store
                  it separately with restricted access.</li>
                <li><strong>Criminal record information</strong> is processed
                  under UK GDPR Article 10 and Data Protection Act 2018 Schedule
                  1, including paragraph 1 (employment) and paragraph 18
                  (safeguarding of children and individuals at risk). We only
                  request a DBS check at the level the role legally
                  requires.</li>
                <li><strong>Equal opportunities monitoring</strong> is optional,
                  kept separately from your application and used only in
                  anonymous form.</li></ul>
                   <p style="margin-top: 1.25rem">We have an Appropriate Policy Document that explains how we
                protect this information. You can ask for a
                copy.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Who we share it with</h2>
          <ul><li><strong>Employers and clients</strong>: we will
                  always tell you about a role and get your agreement before we
                  send your CV or details to an employer.</li><li><strong>The
                    NMC, the DBS and our DBS umbrella body, and the Home
                    Office</strong>, to carry out
                  checks.</li><li><strong>Referees and previous
                    employers</strong>, to verify your
                  history.</li><li><strong>Payroll providers, HMRC and pension
                    providers</strong>, if you take temporary work through
                  us.</li><li><strong>Our service providers</strong>:
                  recruitment database, email, cloud storage, hosting and IT
                  support, acting on our
                  instructions.</li><li><strong>Regulators and
                    authorities</strong>: the DBS, the NMC, the Fair Work
                  Agency, local authority safeguarding teams or the police,
                  where the law requires it or to protect someone from
                  harm.</li></ul>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>WhatsApp and international transfers</h2>
          <p>If you message us on WhatsApp, your messages are processed by Meta, which may transfer data to the United States. We use WhatsApp only for recruitment conversations you start or agree to. Do not send identity documents by WhatsApp unless we ask you to and confirm it is appropriate.</p>
          <p>We do not otherwise routinely transfer candidate data outside the UK. Where a service provider processes data abroad, we rely on UK adequacy regulations, the UK Extension to the EU-US Data Privacy Framework, or the International Data Transfer Agreement. If we introduce you to an employer outside the UK at your request, we will explain the safeguards first.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>How long we keep it</h2>
          <table class="cookie-table"><h3>How long we keep candidate
                    records</h3><thead><tr><th scope="col">Record</th><th
                        scope="col">Retention period</th><th
                        scope="col">Reason</th></tr></thead><tbody><tr><th
                        scope="row">Candidates we have not placed</th><td>2
                        years after our last meaningful contact</td><td>So we
                        can offer you future roles; the law requires at least 1
                        year</td></tr><tr><th scope="row">Candidates and workers
                        we have placed</th><td>6 years after your last placement
                        or assignment</td><td>Legal claims, HMRC and regulatory
                        audit</td></tr><tr><th scope="row">Payroll and tax
                        records</th><td>6 years after the end of the tax
                        year</td><td>HMRC requirements</td></tr><tr><th
                        scope="row">Right to work check copies</th><td>The
                        length of your work with us plus 2 years</td><td>Home
                        Office requirements</td></tr><tr><th scope="row">DBS
                        certificate information</th><td>We record the
                        certificate number, date, level and outcome. We do not
                        keep copies of certificates for more than 6
                        months</td><td>DBS Code of Practice</td></tr><tr><th
                        scope="row">References</th><td>With your candidate
                        record, as above</td><td></td></tr><tr><th
                        scope="row">Job alert consent</th><td>Until you withdraw
                        consent, then a suppression record so we do not contact
                        you
                        again</td><td>PECR</td></tr></tbody></table>
        </section>
        <section id="automated">
          <h2><span class="policy-num">09</span>Automated decisions</h2>
          <p>We do not make decisions about you based solely on automated processing, including profiling. A consultant reviews every application and decides whether to contact you about a role.</p>
        </section>
        <section id="your_rights">
          <h2><span class="policy-num">10</span>Your rights</h2>
          <p>You can ask to access, correct or delete your
                data, restrict or object to how we use it, move it to another
                organisation, and withdraw consent (for example, to job alerts).
                Some records must be kept by law even if you ask us to delete
                them, such as payroll records and records we must keep under the
                Conduct Regulations. We will explain if this applies. See <a
                  href="./data-rights.php">your data
                  rights</a>.</p>
        </section>
        <section id="doyouhave">
          <h2><span class="policy-num">11</span>Do you have to give us your data?</h2>
          <p>You do not have to register with us. But we cannot find you work without your contact details and CV, and we cannot introduce you for healthcare roles without completing the legally required checks. If you do not provide right to work evidence, the law prevents employers from employing you.</p>
        </section>
        <section id="complaints">
          <h2><span class="policy-num">12</span>Complaints</h2>
          <p>If you are unhappy with how
                we have used your personal data, you have the right to complain
                to us. Email <a class="inline-link" href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a>,
                use our <a class="inline-link" href="./data-rights.php#request">online form</a>, or
                follow our <a class="inline-link" href="./complaints-procedure.php">complaints
                  procedure</a>. We will acknowledge your complaint within 30
                days (in practice we aim for 2 working days), look into it
                properly, keep you updated and tell you the outcome without
                undue delay.</p>
              <p>You can also complain to the Information Commissioner&rsquo;s
                Office (ICO) at <a class="inline-link" href="https://ico.org.uk/make-a-complaint/"
                  rel="noopener">ico.org.uk/make-a-complaint</a> or on 0303 123
                1113. The ICO will usually expect you to have raised the
                complaint with us first.</p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>