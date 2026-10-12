<?php include 'header.php'; ?>

<style>
  /* ---- Terms & Conditions page-specific styling ----
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
    max-height: calc(100vh - 140px);
    overflow-y: auto;
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

  /* --- Additive: definitions list + tables for the Terms page --- */
  .policy-content dl.policy-definitions {
    display: grid;
    gap: 1.1rem;
    margin: 0.5rem 0 0;
  }

  .policy-content dl.policy-definitions div {
    display: grid;
    grid-template-columns: 200px minmax(0, 1fr);
    gap: 0.5rem 1.25rem;
  }

  @media (max-width: 640px) {
    .policy-content dl.policy-definitions div {
      grid-template-columns: 1fr;
    }
  }

  .policy-content dl.policy-definitions dt {
    font-weight: 700;
    color: #0b1f3a;
    font-size: 0.95rem;
  }

  .policy-content dl.policy-definitions dd {
    margin: 0;
    color: #475569;
    line-height: 1.7;
    font-size: 0.975rem;
  }

  .policy-content h3 {
    font-family: 'Playfair Display', 'Popins', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #0b1f3a;
    margin: 1.5rem 0 0.75rem;
  }

  .policy-content .clause-list {
    display: grid;
    gap: 0.9rem;
    margin: 0 0 0.9rem;
    counter-reset: none;
  }

  .policy-content .clause-list>li {
    list-style: none;
    position: relative;
    padding-left: 2.6rem;
    color: #475569;
    line-height: 1.75;
    font-size: 1rem;
  }

  .policy-content .clause-list>li::before {
    content: attr(data-num);
    position: absolute;
    left: 0;
    top: 0;
    font-weight: 700;
    color: #7c3aed;
    font-size: 0.875rem;
  }

  .policy-content .clause-list ol,
  .policy-content .clause-sublist {
    list-style: none;
    margin: 0.6rem 0 0;
    padding: 0;
    display: grid;
    gap: 0.6rem;
  }

  .policy-content .clause-sublist>li {
    position: relative;
    padding-left: 2.4rem;
    color: #475569;
    line-height: 1.7;
    font-size: 0.975rem;
  }

  .policy-content .clause-sublist>li::before {
    content: attr(data-num);
    position: absolute;
    left: 0;
    top: 0;
    font-weight: 600;
    color: #0b1f3a;
    font-size: 0.85rem;
  }

  .policy-table-wrap {
    overflow-x: auto;
    margin: 0.75rem 0 1.1rem;
    border: 1px solid #ececf4;
    border-radius: 12px;
  }

  table.policy-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.925rem;
  }

  table.policy-table caption {
    text-align: left;
    font-weight: 600;
    color: #0b1f3a;
    padding: 0.75rem 1rem 0;
    font-size: 0.85rem;
  }

  table.policy-table thead th {
    background: #f7f7fb;
    color: #0b1f3a;
    text-align: left;
    font-weight: 700;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #ececf4;
  }

  table.policy-table tbody td {
    padding: 0.65rem 1rem;
    border-bottom: 1px solid #f1f1f7;
    color: #475569;
  }

  table.policy-table tbody tr:last-child td {
    border-bottom: none;
  }

  .policy-content .note-callout {
    background: #f7f7fb;
    border-left: 3px solid #7c3aed;
    border-radius: 8px;
    padding: 0.9rem 1.1rem;
    color: #334155;
    font-size: 0.925rem;
    line-height: 1.65;
    margin: 0.5rem 0 0.9rem;
  }

  .data-rights-form-wrap {
    background: #ffffff;
    border: 1px solid #e7eaf0;
    border-radius: 18px;
    box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
    padding: 1.5rem;
    max-width: 760px;
  }

  .data-rights-form {
    display: grid;
    gap: 1.25rem;
  }

  .data-rights-form .field {
    display: grid;
    gap: 0.5rem;
  }

  .data-rights-form .field-row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
  }

  .data-rights-form label {
    color: #243b53;
    font-size: 0.8rem;
    font-weight: 700;
    line-height: 1.4;
  }

  .data-rights-form .optional {
    color: #64748b;
    font-weight: 500;
  }

  .data-rights-form .hint {
    color: #64748b;
    font-size: 0.75rem;
    line-height: 1.55;
    margin-top: -0.2rem;
  }

  .data-rights-form input,
  .data-rights-form select,
  .data-rights-form textarea,
  .data-rights-form button {
    font: inherit;
  }

  .data-rights-form input,
  .data-rights-form select,
  .data-rights-form textarea {
    width: 100%;
    min-height: 48px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #ffffff;
    padding: 0.75rem 0.9rem;
    color: #0f172a;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .data-rights-form textarea {
    min-height: 150px;
    resize: vertical;
  }

  .data-rights-form input:focus,
  .data-rights-form select:focus,
  .data-rights-form textarea:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
  }

  .data-rights-form .field--inline {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    padding: 0.85rem 0.95rem;
    border: 1px solid #ececf4;
    border-radius: 12px;
    background: #f8f7fc;
  }

  .data-rights-form .field--inline input {
    width: 18px;
    min-height: 18px;
    margin: 0.15rem 0 0;
    accent-color: #7c3aed;
  }

  .data-rights-form .field--inline label {
    color: #334155;
    font-size: 0.8rem;
    line-height: 1.6;
    font-weight: 500;
  }

  .data-rights-form .form-privacy {
    margin: 0;
    color: #475569;
    font-size: 0.82rem;
    line-height: 1.7;
  }

  .data-rights-form .form-privacy a {
    color: #7c3aed;
    text-decoration: underline;
    text-underline-offset: 2px;
  }

  .data-rights-form .btn {
    justify-self: start;
    min-height: 48px;
    padding: 0.9rem 1.5rem;
    border: none;
    border-radius: 999px;
    background: linear-gradient(135deg, #0b1f3a 0%, #1d3557 100%);
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 700;
    letter-spacing: 0.01em;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 12px 25px rgba(11, 31, 58, 0.16);
  }

  .data-rights-form .btn:hover {
    transform: translateY(-1px);
  }

  .data-rights-form .form-status {
    min-height: 1.1rem;
    font-size: 0.8rem;
    font-weight: 700;
    color: #334155;
  }

  .data-rights-form .form-status.success {
    color: #2d7d4f;
  }

  .data-rights-form .form-status.error {
    color: #b42318;
  }

  @media (max-width: 640px) {
    .data-rights-form-wrap {
      padding: 1rem;
    }

    .data-rights-form .field-row {
      grid-template-columns: 1fr;
    }
  }
</style>

<head>
  <title>Your Data Rights | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">

  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>Your data rights</div>
      <h1>Your Data Rights</h1>
      <p>Your rights under UK data protection law, and how to use them.</p>
      <div class="policy-version"><span></span>Last updated: September 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Terms and conditions sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#definitions">Your rights</a></li>
          <li><a href="#the-contract">How to make a request</a></li>
          <li><a href="#request">Make a request online</a></li>
          <li><a href="#refunds">Complaints about how we use your data</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="definitions">
          <h2><span class="policy-num">01</span>Your rights</h2>

          <dl class="policy-definitions">
            <div>
              <dt>Right to be informed</dt>
              <dd>You have the right
                to be told how we use your data. Our privacy notices do
                this.</dd>
            </div>
            <div>
              <dt>Right of access</dt>
              <dd>You have the right to
                get a copy of your personal data and information about how we
                use it. This is usually called a subject access
                request.</dd>
            </div>
            <div>
              <dt>Right to rectification</dt>
              <dd>You have the
                right to have inaccurate data corrected and incomplete data
                completed.</dd>
            </div>
            <div>
              <dt>Right to erasure</dt>
              <dd>You have the right
                to have your data deleted in some circumstances. We may need
                to keep some records by law, for example payroll records and
                records we must keep under the Conduct Regulations
                2003.</dd>
            </div>
            <div>
              <dt>Right to restrict processing</dt>
              <dd>You have
                the right to ask us to limit how we use your data, for example
                while we check whether it is accurate.</dd>
            </div>
            <div>
              <dt>Right to data
                portability</dt>
              <dd>You have the right to receive data you
                gave us in a commonly used electronic format, or have it sent
                to another organisation, where we use it on the basis of
                consent or contract.</dd>
            </div>
            <div>
              <dt>Right to object</dt>
              <dd>You have
                the right to how we use your data on the basis of legitimate
                interests, and to stop direct marketing at any
                time.</dd>
            </div>
            <div>
              <dt>Right to withdraw consent</dt>
              <dd>You have the
                right where we rely on consent, such as job alerts or cookies,
                at any time. This does not affect anything we did before you
                withdrew it.</dd>
            </div>
            <div>
              <dt>Rights about automated
                decisions</dt>
              <dd>You have the right not to be subject to
                significant decisions made solely by automated means. We do
                not make such decisions.</dd>
            </div>
            <div>
              <dt>Right to complain</dt>
              <dd>You
                have the right to us, and to the Information
                Commissioner&rsquo;s Office.</dd>
            </div>
          </dl>

        </section>

        <section id="the-contract">
          <h2><span class="policy-num">02</span>How to make a request</h2>
          <p>You can make a request in any way, including by
            phone, email, letter or social media. The quickest way is our
            online form below, or email <a class="inline-link"
              href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a>.
            You do not need to use the words &ldquo;subject access
            request&rdquo;.</p>
          <ul>
            <li><strong>It is free.</strong> We may only charge a
              reasonable fee if a request is clearly unfounded or
              excessive.</li>
            <li><strong>We may need to confirm your
                identity</strong> before we release any data. We will ask
              for no more than we need.</li>
            <li><strong>We will respond
                within one month</strong> of receiving your request, or of
              confirming your identity. If your request is complex, we may
              extend this by up to two further months and will tell you why
              within the first month.</li>
            <li><strong>We will carry out
                reasonable and proportionate searches</strong> for the
              information you ask for.</li>
          </ul>
        </section>

        <section id="request">
          <h2>
            <span class="policy-num">03</span>
            Make a request online
          </h2>

          <div class="data-rights-form-wrap">
            <form
              class="data-rights-form"
              id="data-rights-form"
              data-kp-form
              action="./send-application.php"
              method="post"
              data-success-title="We have received your request."
              data-success-text="We will confirm receipt of your request and, if we need to verify your identity, explain what we need. We will normally respond within one month of receiving your request, or let you know if we need more time and why.">
              <input type="hidden" name="formType" value="data_rights">
              <input type="hidden" name="form_type" value="data_rights">
              <input type="hidden" name="csrf_token" value="">
              <input type="hidden" name="form_started" value="">

              <!-- Honeypot field -->
              <div class="hp-field" aria-hidden="true">
                <label for="website-data-rights">
                  Leave this field empty
                </label>

                <input
                  type="text"
                  id="website-data-rights"
                  name="website"
                  tabindex="-1"
                  autocomplete="off">
              </div>

              <!-- Request type -->
              <div class="field">
                <label for="request_type">
                  What would you like to do?
                </label>

                <select
                  id="request_type"
                  name="request_type"
                  required
                  data-required-message="Select what you would like to do">
                  <option value="">Select an option</option>

                  <option value="access">
                    Get a copy of my personal data (subject access request)
                  </option>

                  <option value="rectification">
                    Correct my personal data
                  </option>

                  <option value="erasure">
                    Request deletion of my personal data
                  </option>

                  <option value="restriction">
                    Restrict how my personal data is used
                  </option>

                  <option value="objection">
                    Object to how my personal data is used
                  </option>

                  <option value="portability">
                    Request transfer of my personal data
                  </option>

                  <option value="withdraw-consent">
                    Withdraw my consent
                  </option>

                  <option value="complaint">
                    Make a data protection complaint
                  </option>
                </select>
              </div>

              <!-- Name and email -->
              <div class="field-row">

                <div class="field">
                  <label for="full_name">
                    Full name
                  </label>

                  <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    autocomplete="name"
                    maxlength="120"
                    required
                    data-required-message="Enter your full name">
                </div>

                <div class="field">
                  <label for="email">
                    Email address
                  </label>

                  <input
                    type="email"
                    id="email"
                    name="email"
                    autocomplete="email"
                    maxlength="160"
                    required
                    data-required-message="Enter your email address">
                </div>

              </div>

              <!-- Phone -->
              <div class="field">
                <label for="phone">
                  Phone number
                  <span class="optional">(optional)</span>
                </label>

                <span class="hint" id="phone-hint">
                  Providing your phone number may help us verify your identity
                  if we already hold it on our records.
                </span>

                <input
                  type="tel"
                  id="phone"
                  name="phone"
                  aria-describedby="phone-hint"
                  autocomplete="tel"
                  maxlength="20">
              </div>

              <!-- Relationship -->
              <div class="field">
                <label for="relationship">
                  Your relationship with Kingsbury Personnel
                </label>

                <select
                  id="relationship"
                  name="relationship"
                  required
                  data-required-message="Select your relationship with us">
                  <option value="">Select an option</option>

                  <option value="candidate">
                    Candidate or former candidate
                  </option>

                  <option value="worker">
                    Temporary worker we have placed
                  </option>

                  <option value="client">
                    Client or employer contact
                  </option>

                  <option value="referee">
                    Referee
                  </option>

                  <option value="website-visitor">
                    Website visitor
                  </option>

                  <option value="other">
                    Other
                  </option>
                </select>
              </div>

              <!-- Request details -->
              <div class="field">
                <label for="details">
                  Details of your request
                </label>

                <span class="hint" id="details-hint">
                  Please tell us what information or records your request relates
                  to. Include any relevant dates or other details that may help us
                  locate the information.
                </span>

                <textarea
                  id="details"
                  name="details"
                  aria-describedby="details-hint"
                  maxlength="3000"
                  required
                  data-required-message="Enter the details of your request"></textarea>
              </div>

              <!-- Acting on behalf of someone -->
              <div class="field field--inline">
                <input
                  type="checkbox"
                  id="on_behalf"
                  name="on_behalf"
                  value="yes">

                <label for="on_behalf">
                  I am making this request on behalf of someone else. Kingsbury
                  Personnel may contact me to confirm my authority to act on
                  their behalf.
                </label>
              </div>

              <!-- Privacy notice -->
              <p class="form-privacy">
                We will use the information you provide to handle your request,
                verify your identity where necessary, and keep a record of how we
                dealt with your request. For more information, please see our
                <a href="privacy-policy.php">Privacy Policy</a>.
              </p>

              <!-- No JavaScript -->
              <noscript>
                <p class="panel panel--warning">
                  JavaScript is required to submit this form securely online.
                  If you cannot use the online form, please contact us at
                  <a href="mailto:info@kingsburypersonnel.com">
                    info@kingsburypersonnel.com
                  </a>
                  or call
                  <a href="tel:+441494211220">
                    +44 (0)1494 211220
                  </a>.
                </p>
              </noscript>

              <button type="submit" class="btn btn--primary">
                Send my request
              </button>

              <div
                class="form-status"
                aria-live="polite"
                aria-atomic="true"></div>

              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  const form = document.getElementById('data-rights-form');
                  if (!form) return;

                  form.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    const payload = new FormData(form);
                    const fullName = (payload.get('full_name') || '').toString().trim();
                    const email = (payload.get('email') || '').toString().trim();
                    const phone = (payload.get('phone') || '').toString().trim();
                    const requestType = (payload.get('request_type') || '').toString().trim();
                    const relationship = (payload.get('relationship') || '').toString().trim();
                    const details = (payload.get('details') || '').toString().trim();

                    payload.set('formType', 'data_rights');
                    payload.set('form_type', 'data_rights');
                    payload.set('fullName', fullName);
                    payload.set('specialism', requestType || 'Data rights request');
                    payload.set('experience', relationship || 'Not specified');
                    payload.set('email', email);
                    payload.set('phone', phone);
                    payload.set('sponsorship', payload.get('on_behalf') ? 'Yes' : 'No');
                    payload.set('message', details);
                    payload.set('details', details);

                    const status = form.querySelector('.form-status');
                    if (status) {
                      status.textContent = 'Sending your request...';
                      status.className = 'form-status';
                    }

                    try {
                      const response = await fetch('send-application.php', {
                        method: 'POST',
                        body: payload,
                        credentials: 'same-origin'
                      });

                      const result = await response.json();
                      if (!response.ok || !result?.ok) {
                        throw new Error(result?.message || 'We could not send your request right now.');
                      }

                      if (status) {
                        status.textContent = result.message || 'Your request has been sent.';
                        status.className = 'form-status success';
                      }

                      form.reset();
                    } catch (error) {
                      if (status) {
                        status.textContent = error?.message || 'We could not send your request right now.';
                        status.className = 'form-status error';
                      }
                    }
                  });
                });
              </script>

            </form>
          </div>
        </section>

        <section id="refunds">
          <h2><span class="policy-num">04</span>Complaints about how we use your data</h2>
          <p>If you are unhappy with how we have
            used your personal data, you have the right to complain to us.
            Email <a class="inline-link"
              href="mailto:complaints@kingsburypersonnel.com">complaints@kingsburypersonnel.com</a>,
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