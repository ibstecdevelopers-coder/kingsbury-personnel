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

  .employer-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    align-items: start;
    gap: clamp(2rem, 5vw, 4.5rem);
  }

  .employer-info-grid h2 {
    margin: 0 0 1rem;
    color: var(--navy);
    font-size: clamp(1.5rem, 2.2vw, 2rem);
  }

  .employer-info-grid ul {
    display: grid;
    gap: 0.55rem;
    padding-left: 1.25rem;
  }

  .employer-form fieldset {
    min-width: 0;
    margin: 0 0 1.5rem;
    padding: 0;
    border: 0;
  }

  .employer-form legend {
    margin-bottom: 1rem;
    color: var(--navy);
    font-weight: 700;
  }

  .employer-form .field-row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 18px;
  }

  @media (max-width: 900px) {
    .employer-info-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 600px) {
    .employer-form .field-row {
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
  <title>Staffing for care and healthcare employers | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">
  <section class="service-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>Employers</div>
      <h1>Recruitment for care and healthcare employers</h1>
      <p>Permanent introductions and temporary cover, with
        checks you can evidence to your regulator.</p>
    </div>
  </section>

  <section class="section">
    <div class="site-container employer-info-grid">
      <div class="policy-content">
        <h2>How we work with you</h2>
        <ol class="steps steps--stack">
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">01</span> We agree the brief and terms</h3>
            <p>We confirm the role,
              hours, pay, location and any required experience,
              qualifications and checks. We send our terms of business
              before we introduce any candidate.</p>
          </li>
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">02</span> We search and screen</h3>
            <p>We interview candidates, check
              that they want the role and complete the compliance
              checks.</p>
          </li>
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">03</span> We introduce with evidence</h3>
            <p>You receive the
              candidate&rsquo;s details with confirmation of each check. For
              temporary workers, we confirm the checks by the end of the
              third business day at the latest, as the Conduct Regulations
              require.</p>
          </li>
          <li style="margin-bottom: 1.5rem;">
            <h3><span class="policy-num">04</span> We stay in touch</h3>
            <p>We follow up after the start date
              and act quickly on any concern.</p>
          </li>
        </ol>
      </div>
      <div class="policy-content">
        <h2>What we need from you</h2>
        <p>The Conduct of Employment Agencies and Employment Businesses
          Regulations 2003 require us to get certain information from you
          before we supply or introduce a candidate:</p>
        <ul>
          <li>Your identity and the nature of your business</li>
          <li>The
            start date and likely duration of the work</li>
          <li>The position,
            type of work, location and hours</li>
          <li>Any risks to health and
            safety and the steps you take to control them</li>
          <li>The
            experience, training, qualifications and authorisations
            required</li>
          <li>Any expenses payable</li>
          <li>For permanent
            roles: minimum pay, benefits, payment intervals and notice
            periods</li>
        </ul>
        <p>Our <a href="recruitment-compliance.html">recruitment compliance
            statement</a> explains the checks we carry out.</p>
      </div>
    </div>
  </section>
  <section class="section contact-section" id="request"
    aria-labelledby="request-title">
    <div class="site-container contact-layout">
      <div class="contact-panel reveal">
        <div class="eyebrow eyebrow-light"><span></span>Employer enquiries</div>
        <h2 id="request-title">Request staff</h2>
        <p>Tell us about the role and a consultant will call you. There is
          no charge until a candidate is placed under our agreed terms of
          business.</p>
        <p>Prefer to talk? Call <a href="tel:+441494211220">+44 (0)1494
            211220</a>.</p>
      </div>
      <div class="form-wrap reveal">
        <form class="form employer-form" data-kp-form action="send-application.php" method="post"
          data-success-title="Thank you. We have your request."
          data-success-text="A consultant will call you to confirm the role, the checks you need and our terms of business before we introduce any candidate.">
          <input type="hidden" name="form_type" value="employer">
          <input type="hidden" name="csrf_token" value>
          <input type="hidden" name="form_started" value>
          <div class="hp-field" aria-hidden="true"><label
              for="employer-hp-field">Leave this field empty</label><input
              type="text" id="employer-hp-field" name="kp_hp" tabindex="-1"
              autocomplete="new-password" data-lpignore="true"
              data-1p-ignore="true"></div>
          <fieldset>
            <legend>About you</legend>
            <div class="field-row">
              <div class="field"><label for="full_name">Your
                  name</label><input type="text" id="full_name"
                  name="full_name" autocomplete="name" maxlength="120"
                  required data-required-message="Enter your name"></div>
              <div class="field"><label for="job_title">Your job title <span
                    class="optional">(optional)</span></label><input
                  type="text" id="job_title" name="job_title"
                  autocomplete="organization-title" maxlength="120"></div>
            </div>
            <div class="field">
              <label for="organisation">Organisation name</label>
              <input type="text" id="organisation"
                name="organisation" autocomplete="organization"
                maxlength="160" required
                data-required-message="Enter your organisation name">
            </div>
            <div class="field-row" style="margin-top: 1.2rem;">
              <div class="field"><label for="email">Work email
                  address</label><input type="email" id="email" name="email"
                  autocomplete="email" maxlength="160" required
                  data-required-message="Enter your work email address"></div>
              <div class="field"><label for="phone">Phone number</label><input
                  type="tel" id="phone" name="phone" autocomplete="tel"
                  maxlength="20" required
                  data-required-message="Enter your phone number"></div>
            </div>
          </fieldset>
          <fieldset>
            <legend>The staff you need</legend>
            <div class="field-row">
              <div class="field"><label for="role">Role</label><select
                  id="role" name="role" required
                  data-required-message="Select the role you need">
                  <option
                    value>Select an option</option>
                  <option
                    value="rgn">Registered General Nurse (RGN)</option>
                  <option
                    value="rmn">Registered Mental Health Nurse
                    (RMN)</option>
                  <option value="rnld">Registered Learning
                    Disability Nurse (RNLD)</option>
                  <option
                    value="nurse-other">Nurse, other
                    specialism</option>
                  <option value="clinical-lead">Clinical
                    lead or senior nurse</option>
                  <option
                    value="deputy-manager">Deputy manager</option>
                  <option
                    value="registered-manager">Registered
                    manager</option>
                  <option value="care-worker">Care or
                    support worker</option>
                  <option
                    value="senior-care-worker">Senior care worker or team
                    leader</option>
                  <option value="nursery">Nursery or early
                    years practitioner</option>
                  <option value="chef">Chef or
                    kitchen role</option>
                  <option
                    value="hospitality">Hospitality role</option>
                  <option
                    value="legal">Solicitor or legal
                    support</option>
                </select></div>
              <div class="field"><label for="work_type">Type of
                  supply</label><select id="work_type" name="work_type"
                  required
                  data-required-message="Select the type of supply">
                  <option
                    value>Select an option</option>
                  <option
                    value="permanent">Permanent introduction</option>
                  <option
                    value="temporary">Temporary or contract
                    worker</option>
                  <option value="either">Not sure
                    yet</option>
                </select></div>
            </div>
            <div class="field-row">
              <div class="field"><label for="location">Location of the
                  role</label><span class="hint" id="location-hint">Town or
                  postcode area.</span><input type="text" id="location"
                  name="location" aria-describedby="location-hint"
                  maxlength="120" required
                  data-required-message="Enter the location of the role"></div>
              <div class="field"><label for="setting">Setting</label><select
                  id="setting" name="setting" required
                  data-required-message="Select the setting">
                  <option
                    value>Select an option</option>
                  <option
                    value="nursing-home">Nursing home</option>
                  <option
                    value="residential-care">Residential care
                    home</option>
                  <option value="supported-living">Supported
                    living</option>
                  <option value="mental-health">Mental health
                    or learning disability service</option>
                  <option
                    value="community">Community or domiciliary
                    service</option>
                  <option value="nhs">NHS
                    organisation</option>
                  <option value="early-years">Nursery
                    or early years setting</option>
                  <option
                    value="other">Other</option>
                </select></div>
            </div>
            <div class="field"><label for="details">Tell us about the
                role</label><span class="hint" id="details-hint">Include the
                start date, hours, pay range and any specific experience or
                checks needed. Please do not include information about
                individual residents or patients.</span><textarea id="details"
                name="details" aria-describedby="details-hint"
                maxlength="3000" required
                data-required-message="Tell us about the role"></textarea></div>
          </fieldset>
          <p class="form-privacy">We will use your details to respond to your
            request and manage our business relationship, as explained in our
            <a class="inline-link" href="./employer-privacy-notice.php">employer privacy
              notice</a>.
          </p>
          <noscript>
            <p class="panel panel--warning">This form needs JavaScript
              to send securely. You can also email your CV to <a
                href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a>
              or call <a href="tel:+441494211220">+44 (0)1494
                211220</a>.</p>
          </noscript>
          <button type="submit" class="btn btn-primary" style="margin-top: 1.2rem">Send My
            Request</button>
          <div class="form-status" aria-live="polite"></div>
        </form>
      </div>
    </div>
  </section>
  <script>
    const employerRequestForm = document.querySelector('form[data-kp-form]');
    employerRequestForm?.addEventListener('submit', async (event) => {
      event.preventDefault();

      const status = employerRequestForm.querySelector('.form-status');
      const submitButton = employerRequestForm.querySelector('[type="submit"]');
      const submitLabel = submitButton.textContent;
      submitButton.disabled = true;
      submitButton.textContent = 'Sending request...';
      status.textContent = 'Sending your request...';
      status.className = 'form-status';

      try {
        const formData = new FormData(employerRequestForm);
        formData.set('kp_hp', '');
        formData.delete('website');

        const response = await fetch(employerRequestForm.action, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        });
        const result = await response.json();

        if (!response.ok || !result?.ok) {
          throw new Error(result?.message || 'We could not send your request right now.');
        }

        status.textContent = result.message || 'Your request has been sent.';
        status.className = 'form-status success';
        employerRequestForm.reset();
      } catch (error) {
        status.textContent = error?.message || 'We could not send your request right now.';
        status.className = 'form-status error';
      } finally {
        submitButton.disabled = false;
        submitButton.textContent = submitLabel;
      }
    });
  </script>
</main>

<?php include 'footer.php'; ?>