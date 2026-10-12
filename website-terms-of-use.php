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
    <title>Website Terms of Use | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>Terms & Policies</div>
      <h1>Website Terms of Use</h1>
      <p>Welcome to the Kingsbury Personnel website. These Terms of Use explain the rules for using our website, <a href="./index.php">www.kingsburypersonnel.com</a>. They apply to everyone who visits the site, whether you're searching for your next role, registering your CV or looking to recruit staff.</p>
      <p>Please read them carefully. By using our website, you agree to these terms and you acknowledge that no contractual relationship is formed between you and Kingsbury Personnel. If you don't agree, please don't use the site.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">About us</a></li>
          <li><a href="#types-of-cookies">Intellectual property</a></li>
          <li><a href="#how-we-use-cookies">Acceptable use</a></li>
          <li><a href="#why-we-process">No guarantee of job placement</a></li>
          <li><a href="#lawful-basis">Accuracy of job adverts</a></li>
          <li><a href="#sharing-information">Limitation of liability</a></li>
          <li><a href="#international-transfers">Third party links</a></li>
          <li><a href="#retention">Changes to these terms</a></li>
          <li><a href="#governing">Governing law</a></li>
          <li><a href="#complaints">Contact us</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>About us</h2>
          <p>This website is operated by <strong>Kingsbury Personnel Ltd</strong>, a company registered in <strong>England and Wales (Company No. 11804530)</strong>, you can find our contact details within Contact Us Section of our website.</p>
          <p>These Terms of Use cover your use of the website only. If you are an employer using our recruitment services, our <a class="inline-link" href="./terms-conditions.php">Terms & Conditions (Terms of Business)</a> will also apply. Our <a class="inline-link" href="./privacy-policy.php">Privacy Policy</a> explains how we handle your personal information.</p>
          <p>Our use of cookies and similar technologies is explained in our <a class="inline-link" href="./cookies-policy.php">Cookies Policy</a>.</p>
        </section>

        <section id="types-of-cookies">
    <h2><span class="policy-num">02</span>Intellectual property</h2>
<p>All content is owned by <strong>Kingsbury Personnel Ltd</strong> or licensed to us.</p>
<p>You may view and print content for personal use only. You must not reproduce, distribute, modify or commercially exploit any part of the website.</p>
<p>All rights not expressly granted are reserved.</p>
</section>


       <section id="how-we-use-cookies">
  <h2><span class="policy-num">03</span>Acceptable use</h2>
<p>You agree not to:</p>

  <ul>
    <li>Use the website unlawfully;</li>
    <li>Provide false or misleading information;</li>
    <li>Upload harmful or offensive content;</li>
    <li>Attempt unauthorised access;</li>
    <li>Use bots or scrapers;</li>
    <li>Send spam;</li>
  </ul>

  <p style="margin-top: 0.9rem;">
    You must not attempt to bypass or disable any security features or access controls on the website.
  </p>
</section>


        <section id="why-we-process">
          <h2><span class="policy-num">04</span>No guarantee of job placement</h2>
          <p>Registering your CV or applying for a role does not guarantee progression, interview or job offer.</p>
          <p>Nothing on this website constitutes a promise or guarantee of employment or engagement.</p>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Accuracy of job adverts</h2>
          <p>Job adverts are based on client information. We take reasonable care but cannot guarantee accuracy or availability.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Limitation of liability</h2>
          <p>The website is provided on an "as is" and "as available" basis.</p>

  <p>Content is general information only. You must not rely on any information on the website as a substitute for professional advice.</p>

  <p>We exclude liability for:</p>

  <ul>
    <li>Loss of income;</li>
    <li>Loss of business;</li>
    <li>Loss of data;</li>
    <li>Indirect or consequential loss;</li>
  </ul>

  <p style="margin-top: 0.9rem;">
    We exclude all implied conditions, warranties, representations or other terms that may apply to the website or any content on it.
  </p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>Third party links</h2>
          <p>We are not responsible for third party websites.</p>

  <p>We are not liable for any loss or damage arising from your use of third party websites.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>Changes to these terms</h2>
          <p>We may update these Terms.</p>
          <p>Your continued use of the website after changes are posted constitutes acceptance of the updated Terms.</p>
        </section>
        
        <section id="governing">
          <h2><span class="policy-num">09</span>Governing law</h2>
          <p>These Terms are governed by the law of England and Wales.</p>
          <p>The courts of England and Wales shall have exclusive jurisdiction over any dispute arising from or relating to these Terms or your use of the website.</p>
        </section>
        
        <section id="complaints">
          <h2><span class="policy-num">10</span>Contact us</h2>
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