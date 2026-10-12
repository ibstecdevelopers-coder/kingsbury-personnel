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
    <title>Cookies Policy | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>LEGAL NOTICE</div>
      <h1>Cookies Policy</h1>
      <p>Which cookies we use, why, how long they last, and how to change your choice.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Privacy notice sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#introduction">What are cookies?</a></li>
          <li><a href="#types-of-cookies">Your choice</a></li>
          <li><a href="#how-we-use-cookies">Cookies we use</a></li>
          <li><a href="#why-we-process">Strictly necessary cookies</a></li>
          <li><a href="#lawful-basis">Analytics cookies</a></li>
          <li><a href="#sharing-information">Marketing cookies</a></li>
          <li><a href="#international-transfers">Other ways to control cookies</a></li>
          <li><a href="#retention">More information</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="introduction">
          <h2><span class="policy-num">01</span>What are cookies?</h2>
          <p>Cookies are small files stored on your device when you visit a website. We also use similar technology, such as the Meta Pixel, which we treat in the same way as cookies. This policy explains which ones we use and how you control them.</p>
        </section>

        <section id="types-of-cookies">
    <h2><span class="policy-num">02</span>Your choice</h2>
<!-- <ul>
    <li>
        <h3>Strictly necessary cookies</h3>
        <p>
            These are essential for the Website to work, for example to keep it secure,
            remember your cookie choices, or make forms and job application features
            function. Under PECR these do not require consent, so they cannot be switched
            off through our cookie banner.
        </p>
    </li>

    <li>
        <h3>Preference (functional) cookies</h3>
        <p>
            These remember choices you make, such as saved job searches or display
            settings. We only set them with your consent unless they are strictly
            necessary for a feature you have asked for.
        </p>
    </li>

    <li>
        <h3>Analytics and performance cookies</h3>
        <p>
            These help us understand how visitors use the Website, such as which pages
            and vacancies are viewed most. We use analytics tools to collect this
            information. We set these cookies only with your consent.
        </p>
    </li>

    <li>
        <h3>Marketing and advertising cookies</h3>
        <p>
            These may be set by us or our advertising partners to show relevant job
            adverts and measure campaign performance. We set these cookies only with
            your consent.
        </p>
    </li>

    <li>
        <h3>Third-party cookies</h3>
        <p>
            Some cookies may be set by services embedded in our Website, such as
            analytics, mapping, video, social media or advertising services. These
            third-party providers may have their own privacy and cookie policies,
            which apply to their use of your information.
        </p>
    </li>
</ul> -->
<p>When you first visit, we ask whether you accept analytics and marketing cookies. You can accept all, reject all non-essential cookies, or choose by category. Rejecting is as easy as accepting. <strong>No analytics or marketing cookies are set, and no tracking scripts load, until you choose to allow them.</strong></p>
<div class="policy-contact-card" style="margin-top: 1.25rem;">
Your current choice (saved 25/09/2026): analytics off, marketing off. Consent ID: 9ca87ea5-a230-436a-9933-3335abc6f30e.
          </div>
          <button class="btn btn-primary" style="margin: 15px 0px"
                onclick="openCookieSettings(); return false;">Change my cookie settings</button>
          <p>We ask you again after 12 months, or sooner if we add new cookies.</p>
</section>


       <section id="how-we-use-cookies">
  <h2><span class="policy-num">03</span>Cookies we use</h2>

  <div class="cookie-table-wrapper">
    <table class="cookie-table">
    <h3>Cookies used on this website</h3>

    <thead>
        <tr>
            <th scope="col">Cookie</th>
            <th scope="col">Provider</th>
            <th scope="col">Purpose</th>
            <th scope="col">Category</th>
            <th scope="col">Expires</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th scope="row">kp_consent</th>
            <td>kingsburypersonnel.com</td>
            <td>
                Stores your cookie choices, a random consent ID and the date
            </td>
            <td>Strictly necessary</td>
            <td>12 months</td>
        </tr>

        <tr>
            <th scope="row">KPSESSID</th>
            <td>kingsburypersonnel.com</td>
            <td>
                Keeps form submissions secure (protects against cross-site
                request forgery). Set only when you use a form
            </td>
            <td>Strictly necessary</td>
            <td>When you close your browser</td>
        </tr>

        <tr>
            <th scope="row">_ga</th>
            <td>Google Analytics</td>
            <td>
                Distinguishes visitors so we can count them
            </td>
            <td>Analytics</td>
            <td>2 years</td>
        </tr>

        <tr>
            <th scope="row">_ga_&lt;ID&gt;</th>
            <td>Google Analytics</td>
            <td>
                Keeps track of your visit session
            </td>
            <td>Analytics</td>
            <td>2 years</td>
        </tr>

        <tr>
            <th scope="row">_fbp</th>
            <td>Meta (Facebook and Instagram)</td>
            <td>
                Measures visits from our social media job adverts
            </td>
            <td>Marketing</td>
            <td>90 days</td>
        </tr>

        <tr>
            <th scope="row">_fbc</th>
            <td>Meta (Facebook and Instagram)</td>
            <td>
                Records that you arrived by clicking one of our adverts
            </td>
            <td>Marketing</td>
            <td>90 days</td>
        </tr>
    </tbody>
</table>
<p>We will update this table before we start using any new cookie.</p>
  </div>
</section>

        <section id="why-we-process">
          <h2><span class="policy-num">04</span>Strictly necessary cookies</h2>
          <p>These are needed for the website to work and for your choices to be remembered. The Privacy and Electronic Communications Regulations 2003 (PECR) allow us to use them without consent. You can block them in your browser, but forms may then not work.</p>
        </section>

        <section id="lawful-basis">
          <h2><span class="policy-num">05</span>Analytics cookies</h2>
          <p>Google Analytics tells us which pages and vacancies are used most. We use Google Consent Mode so that Google Analytics does not run unless you allow analytics cookies. Google may process this data in the United States under the UK Extension to the EU-US Data Privacy Framework.</p>
        </section>

        <section id="sharing-information">
          <h2><span class="policy-num">06</span>Marketing cookies</h2>
          <p>The Meta Pixel helps us see whether our Facebook and Instagram job adverts lead to visits. We only send page view events. We never send your CV, form answers, profession or health information to Meta.</p>
        </section>

        <section id="international-transfers">
          <h2><span class="policy-num">07</span>Other ways to control cookies</h2>
          <p>Most browsers let you block or delete
                cookies. <a class="inline-link"
                  href="https://ico.org.uk/for-the-public/online/cookies/"
                  rel="noopener">The ICO explains how</a>. You can also install
                the <a class="inline-link" href="https://tools.google.com/dlpage/gaoptout"
                  rel="noopener">Google Analytics opt-out browser
                  add-on</a>.</p>
        </section>

        <section id="retention">
          <h2><span class="policy-num">08</span>More information</h2>
          <p>See our <a class="inline-link" href="./privacy-policy.php">privacy
                  policy</a> for how we use personal data, including your rights
                and how to complain. Contact <a class="inline-link"             href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a>
                with any questions.</p>
        </section>

        <a href="#main-content" class="policy-back-top">↑ Back to top</a>

      </article>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>