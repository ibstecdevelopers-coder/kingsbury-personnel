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
    <title>Complaint Procedure | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>POLICIES & PROCEDURES</div>
      <h1>Complaint Procedure</h1>
      <p>At Kingsbury Personnel Ltd, we aim to give every candidate, client and temporary worker a professional, fair and respectful service. If we haven't met that standard, we want to know so we can put it right. This procedure explains how to raise a complaint, what happens next, and where you can go if you're not satisfied with our response.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">Who can use this procedure?</a></li>
          <li><a href="#types-of-cookies">What can you complain about?</a></li>
          <li><a href="#how-we-use-cookies">How to make a complaint</a></li>
          <li><a href="#why-we-process">What happens next</a></li>
          <li><a href="#lawful-basis">If you're still not satisfied</a></li>
          <li><a href="#sharing-information">Urgent safeguarding or safety concerns</a></li>
          <li><a href="#international-transfers">Confidentiality and fair treatment</a></li>
          <li><a href="#retention">Learning from complaints</a></li>
          <li><a href="#complaints">Contact us</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>Who can use this procedure?</h2>
          <p>You can make a complaint if you are:</p>
          <ul>
          	<li>A candidate or work-seeker who has registered with us;</li>
            <li>A temporary or agency worker we have placed;</li>
            <li>A client or employer who uses our recruitment services; or</li>
            <li>Anyone else affected by how we have handled your personal data or conducted our business.</li>
          </ul>
        </section>

        <section id="types-of-cookies">
    <h2><span class="policy-num">02</span>What can you complain about?</h2>
    <p>For example, you may wish to complain about:</p>
		<ul>
        	<li>The standard of service or communication you received;</li>
            <li>The conduct or behaviour of a member of our team;</li>
            <li>How we have handled your application, CV or registration;</li>
            <li>Pay, fees or terms relating to a placement arranged by us;</li>
            <li>How we have collected, used or stored your personal data; or</li>
            <li>Discrimination, unfair treatment or any other concern about how we operate.</li>
            
         </ul>
</section>


       <section id="how-we-use-cookies">
  <h2><span class="policy-num">03</span>How to make a complaint</h2>

  <p>Please contact us in writing where possible, so we have a clear record of your concerns. Mark your message <strong>"Complaint"</strong> and send it to:</p>
  <div class="policy-contact-card" style="margin-top: 1.25rem;">
  <div><strong>Email:</strong> <a class="inline-link"
                href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a></div>
                 <div><strong>Telephone:</strong> <a class="inline-link"
                href="tel:+441494211220">+44 (0) 1494 211220</a> (we will ask you to confirm the details in writing)</div>
            <div><strong>Post:</strong> Kingsbury Personnel Ltd, 124 City Road, London, England, EC1V 2NX (marked "Complaint")</div>
          </div>
         <p></p>
         <p></p>
            <p>To help us investigate quickly, please include:</p>
            <ul>
            	<li>Your full name and contact details;</li>
                <li>The name of the consultant or team member involved, if known;</li>
                <li>What happened, with dates and any relevant emails, messages or documents; and</li>
                <li>What outcome you would like.</li>
               </ul>
            <p>If you need us to make reasonable adjustments to help you raise a complaint, such as accepting it in a different format, please tell us and we will do our best to help.</p>
</section>


        <section id="why-we-process">
          <h2><span class="policy-num">04</span>What happens next</h2>
          <h3>Stage 1: Acknowledgement and investigation</h3>
          <ul>
          	<li>We will acknowledge your complaint within 2 working days of receiving it.</li>
            <li>Your complaint will be passed to a manager who was not involved in the matter, who will look into it fairly and impartially.</li>
            <li>We may contact you for more information, and we will speak to the people involved.</li>
            <li>We will send you a written response within 10 working days, explaining what we found, what we have decided, and any action we will take.</li>
            <li>If we need longer, for example because we are waiting on a third party, we will tell you why and let you know when to expect our response.</li>
            </ul>
            
            <h3 style="margin-top:10px">Stage 2: Review by a director</h3>
            <p>If you're not satisfied with our Stage 1 response, you can ask for it to be reviewed. Please reply within 20 working days of receiving our response, explaining why you feel the matter hasn't been resolved. A director who was not involved in Stage 1 will review your complaint and the original investigation, and will send you a final written response within 15 working days.</p>
        </section>

        <section id="lawful-basis">
  <h2><span class="policy-num">05</span>If you're still not satisfied</h2>

  <p>
    We hope to resolve your complaint ourselves. If you remain unhappy after
    going through our procedure, you may be able to take the matter further:
  </p>

  <ul>
    <li>
      <strong>Concerns about how a recruitment agency has acted:</strong>
      You can complain to the Fair Work Agency, the government body that
      enforces the rules for employment agencies and employment businesses in
      Great Britain. See
      <a class="inline-link" href="https://www.gov.uk/government/organisations/fair-work-agency/about/complaints-procedure">making a complaint to the Fair Work Agency about your recruitment agency</a>.
    </li>

    <li>
      <strong>Concerns about your personal data:</strong>
      You can contact the Information Commissioner's Office (ICO), the UK's
      data protection regulator, at
      <a class="inline-link" href="https://ico.org.uk/make-a-complaint/">ico.org.uk/make-a-complaint</a>.
      Kingsbury Personnel Ltd is registered with the ICO (Reg. No. ZB196377).
    </li>

    <li>
      <strong>Pay and employment rights:</strong>
      Free, impartial advice is available from Acas.
    </li>
  </ul>

  <p style="margin-top: 0.9rem;">
    You may also have the right to bring a claim to an employment tribunal or
    a court. Time limits can apply, so if you're considering this, we recommend
    seeking advice early.
  </p>
</section>


        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Urgent safeguarding or safety concerns</h2>
          <p>If you have a concern about the immediate safety or welfare of a person in a care or nursing setting, please don't wait for this procedure. Contact the emergency services on 999 or the relevant local authority safeguarding team straight away, and then let us know so we can act on it too.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>Confidentiality and fair treatment</h2>
          <ul>
          <li>We will treat your complaint confidentially and share it only with the people who need to know in order to investigate and resolve it.</li>
          <li>Making a complaint will never affect how we treat you, including your registration with us or the roles we put you forward for.</li>
          <li>We will keep a record of your complaint and our response, and handle it in line with our <a class="inline-link" href="./privacy-policy.php">Privacy Policy</a>.</li>
          </ul>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Learning from complaints</h2>
          <p>We review the complaints we receive to spot trends and improve our service, our training and the way we work.</p>
        </section>
        
        <section id="complaints">
          <h2><span class="policy-num">09</span>Contact us</h2>
          <div class="policy-contact-card" style="margin-top: 1.25rem;">
            <div><strong>Company:</strong> Kingsbury Personnel Ltd (Company No. 11804530)</div>
            <div><strong>Registered office:</strong> 124 City Road, London, England, EC1V 2NX</div>
            <div><strong>Telephone:</strong> <a class="inline-link"
                href="tel:+441494211220">+44 (0) 1494 211220</a></div>
            <div><strong>Email:</strong> <a class="inline-link"
                href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a></div>
          </div>
         
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>