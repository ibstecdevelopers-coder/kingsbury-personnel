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
</style>
<head>
    <title>Terms & Conditions | Kingsbury Personnel Ltd.</title>
</head>
<main id="main-content">

  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="eyebrow eyebrow-light"><span></span>UK GDPR &amp; Data Protection Act 2018</div>
      <h1>Terms &amp; Conditions</h1>
      <p>These Terms of Business set out the contract between Kingsbury
        Personnel Ltd (the Agency) and any Client for the introduction of
        permanent or contract staff to be engaged directly by the Client.</p>
      <div class="policy-version"><span></span>Company No. 11804530 · ICO Reg. No. ZB196377 ·  England &amp; Wales</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="site-container policy-layout">

      <aside class="policy-toc" aria-label="Terms and conditions sections">
        <h2>On this page</h2>
        <ol>
          <li><a href="#definitions">Definitions</a></li>
          <li><a href="#the-contract">The Contract</a></li>
          <li><a href="#notification-and-fees">Notification and Fees</a></li>
          <li><a href="#refunds">Refunds</a></li>
          <li><a href="#introductions-third-parties">Introductions to Third Parties</a></li>
          <li><a href="#suitability-checks">Suitability Checks</a></li>
          <li><a href="#exclusivity-term">Exclusivity Term</a></li>
          <li><a href="#information-to-be-provided">Information to be Provided</a></li>
          <li><a href="#confidentiality-data-protection">Confidentiality</a></li>
          <li><a href="#international-data-transfer">International Data Transfer</a></li>
          <li><a href="#liability">Liability</a></li>
          <li><a href="#notices">Notices</a></li>
          <li><a href="#severability">Severability</a></li>
          <li><a href="#governing-law">Governing Law and Jurisdiction</a></li>
        </ol>
      </aside>

      <article class="policy-content">

        <section id="definitions">
          <h2><span class="policy-num">01</span>Definitions</h2>
          <p>In these Terms the following definitions apply:</p>
          <dl class="policy-definitions">
            <div>
              <dt>Agency</dt>
              <dd>Kingsbury Personnel Ltd, registered company no. 11804530, of 124 City Road, London, England, EC1V 2NX (the Agency).</dd>
            </div>
            <div>
              <dt>Cancellation Fee</dt>
              <dd>The fee payable by the Client to the Agency when the Client withdraws an offer of Engagement made to the Candidate before the Candidate has accepted the offer, calculated in accordance with these Terms.</dd>
            </div>
            <div>
              <dt>Candidate</dt>
              <dd>The person Introduced by the Agency to the Client for an Engagement, including any officer, employee or other representative of the Candidate if the Candidate is a corporate body, and members of the Agency's own staff.</dd>
            </div>
            <div>
              <dt>Client</dt>
              <dd>The person, firm or corporate body together with any subsidiary or associated person, firm or corporate body (as the case may be) to which the Candidate is introduced.</dd>
            </div>
            <div>
              <dt>Data Protection Laws</dt>
              <dd>The Data Protection Act 2018, UK General Data Protection Regulation (UK GDPR), or any applicable statutory or regulatory provisions in force from time to time relating to the protection and transfer of personal data.</dd>
            </div>
            <div>
              <dt>Engagement</dt>
              <dd>The engagement (including the Candidate's acceptance of the Client's offer), employment or use of the Candidate by the Client or by any third party to whom the Candidate has been introduced by the Client, on a permanent or temporary basis, whether under a contract of service or for services; under an agency, licence, franchise or partnership agreement; or any other engagement; or through a limited company of which the Candidate is an officer, employee or other representative. "Engage", "Engages" and "Engaged" are construed accordingly.</dd>
            </div>
            <div>
              <dt>Introduction</dt>
              <dd>(i) The passing to the Client of a curriculum vitae or information which identifies the Candidate, or (ii) the Client's interview of a Candidate (in person, by telephone or by any other means), following the Client's instruction to the Agency to search for a Candidate, which in either case leads to an Engagement of the Candidate. "Introduces" and "Introduced" are construed accordingly.</dd>
            </div>
            <div>
              <dt>Introduction Fee</dt>
              <dd>The fee payable by the Client to the Agency for an Introduction resulting in an Engagement.</dd>
            </div>
            <div>
              <dt>Losses</dt>
              <dd>All losses, liabilities, damages, costs, expenses, fines, penalties or interest, whether direct, indirect, special or consequential (including, without limitation, any economic loss or other loss of profits, business or goodwill, management time and reasonable legal fees) and charges, including such items arising out of or resulting from actions, proceedings, claims, and demands.</dd>
            </div>
            <div>
              <dt>Remuneration</dt>
              <dd>Gross base salary or fees, guaranteed and/or anticipated bonus and commission earnings, allowances, inducement payments, the benefit of a company car and all other payments and taxable (and, where applicable, non-taxable) emoluments payable to or receivable by the Candidate for services rendered to or on behalf of the Client or any third party. Where the Client provides a company car, a notional amount will be added to the salary to calculate the Agency's fee.</dd>
            </div>
            <div>
              <dt>Replacement Candidate</dt>
              <dd>Any Candidate Introduced by the Agency to the Client to fill the Engagement following the Introduction of another Candidate whose Engagement either did not commence or was terminated during the first 10 weeks of the Engagement.</dd>
            </div>
          </dl>
          <p style="margin-top: 1.1rem;">Unless the context requires otherwise, references to the singular include the plural and the masculine includes the feminine and vice versa. The headings in these Terms are for convenience only and do not affect their interpretation.</p>
        </section>

        <section id="the-contract">
          <h2><span class="policy-num">02</span>The Contract</h2>
          <ul>
            <li>These Terms and the attached Schedule(s) constitute the contract between the Agency and the Client for the Introduction of permanent or contract staff (to be engaged directly by the Client), and are deemed accepted by the Client by virtue of an Introduction, the Engagement of a Candidate, or the passing by the Client of any information about a Candidate to a third party following an Introduction.</li>
            <li>This agreement does not need to be signed to become binding on the parties. These Terms of business can be sent to the Client electronically.</li>
            <li>These Terms contain the entire agreement between the parties and, unless otherwise agreed in writing by a director of the Agency, prevail over any other terms of business or purchase conditions put forward by the Client.</li>
            <li>No variation or alteration to these Terms is valid unless agreed between a director of the Agency and the Client, set out in writing, with a copy of the varied terms given to the Client stating the date from which the varied terms apply.</li>
            <li>The Agency acts as an employment agency (as defined in Section 13(2) of the Employment Agencies Act 1973) when Introducing Candidates to the Client for direct Engagement by that Client.</li>
          </ul>
        </section>

        <section id="notification-and-fees">
          <h2><span class="policy-num">03</span>Notification and Fees</h2>
          <p>The Client agrees to:</p>
          <ul>
            <li>Notify the Agency immediately of the terms of any offer of Engagement it makes to the Candidate;</li>
            <li>Notify the Agency immediately when its offer of Engagement to the Candidate has been accepted, and provide details of the Remuneration agreed with the Candidate, together with any documentary evidence requested by the Agency; and</li>
            <li>Pay the Introduction Fee, calculated in accordance with this clause, by the due date for payment.</li>
          </ul>

          <p>The Introduction Fee is payable if the Client Engages the Candidate within 6 calendar months from the date of (a) the Introduction, (b) the Client's withdrawal of an offer of Engagement, or (c) the Candidate's rejection of an offer of Engagement — whichever is the later. The Introduction Fee is payable within 7 days of the date of the Agency's invoice, which is rendered once the Candidate commences the Engagement, unless different payment terms have been agreed.</p>

          <p>The Introduction Fee is calculated in accordance with the Fee Structure Schedule below, based on the Remuneration applicable during the first 12 months of the Engagement:</p>

          <div class="policy-table-wrap">
            <table class="policy-table">
              <thead>
                <tr>
                  <th>Remuneration</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>£0 – £20,000</td>
                </tr>
                <tr>
                  <td>£20,001 – £30,000</td>
                </tr>
                <tr>
                  <td>£30,001 – £40,000</td>
                </tr>
                <tr>
                  <td>£40,001 – £50,000</td>
                </tr>
                <tr>
                  <td>£50,001+</td>
                </tr>
              </tbody>
            </table>
          </div>

          <p>Where the actual Remuneration is not known, the Agency will charge an Introduction Fee <strong>for care/domestic/kitchen/housekeeping staff</strong>, based on its determination of the market-rate remuneration for the position, having regard to any information supplied by the Client and comparable positions in the market generally.</p>

          <h3>Additional terms</h3>
          <ul>
            <li>Where the Engagement is agreed on a fixed-term basis of less than 12 months, the Introduction Fee applies pro-rata. If the Client extends the Engagement beyond the initial fixed term, or re-Engages the Candidate within 6 calendar months of termination of the fixed term, a further Introduction Fee applies based on the additional Remuneration capped so the Client never pays more in total than the full 12-month fee under these Terms.</li>
            <li>The Client's payment obligations under this clause are performed without any right of set-off, deduction, withholding or other similar rights.</li>
            <li>VAT is charged at the standard rate on all fees where applicable.</li>
            <li>The Agency reserves the right to charge interest under the Late Payment of Commercial Debts (Interest) Act 1998 on invoiced amounts unpaid by the due date, at 8% per annum above the Bank of England base rate, from the due date until payment.</li>
            <li>If, after an offer of Engagement has been made, the Client withdraws it for any reason before the Candidate accepts, the Client is liable to pay the Agency a <strong>Cancellation Fee of £500</strong>.</li>
            <li>If any Agency staff with whom the Client has had personal dealings accepts an Engagement with the Client while employed by the Agency (or within 3 months of leaving the Agency), the Client is liable to pay a fee equivalent to the Introduction Fee. No refund is available for any fee due under this provision, in any circumstances.</li>
          </ul>
        </section>

        <section id="refunds">
          <h2><span class="policy-num">04</span>Refunds</h2>
          <p>If, after an offer has been made and accepted, the Engagement (a) does not commence because the Candidate withdraws their acceptance, or (b) once commenced is terminated by either the Candidate or the Client (except where the Candidate is made redundant) before the expiry of 10 weeks from commencement, the Agency will refund the Introduction Fee in accordance with the Scale of Refunds below, subject to the conditions in this clause.</p>

          <div class="policy-table-wrap">
            <table class="policy-table">
              <caption>Scale of Refunds — week in which the Engagement terminates</caption>
              <thead>
                <tr>
                  <th>Week</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Non-commencement</td>
                </tr>
                <tr>
                  <td>Weeks 1 – 4</td>
                </tr>
                <tr>
                  <td>Weeks 5 – 6</td>
                </tr>
                <tr>
                  <td>Weeks 7 – 8</td>
                </tr>
                <tr>
                  <td>Weeks 9 – 10</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="note-callout">No refund is payable where the Candidate's Engagement is terminated (or would have terminated but for garden leave or payment in lieu of notice) during or after the 10th week of the Engagement.</div>

          <ul>
            <li>To qualify for a refund, the Client must comply with the notification requirements above and must notify the Agency in writing of the termination or non-commencement within 7 days of it occurring.</li>
            <li>The Client must exclusively give the Agency 4 to 8 weeks from the date of that notice to find one suitable Replacement Candidate based on the original specification. If no suitable Replacement Candidate is found in that window, or the Replacement Candidate's Engagement is also terminated before the expiry of 10 weeks, the Client becomes eligible for a refund, subject to the rest of this clause.</li>
            <li>The date of termination is the date the Candidate ceases (or would have ceased) working for the Client, but for any period of garden leave or payment in lieu of notice — whichever is the later.</li>
            <li>Where the fixed-term pro-rata provision applies, the full Introduction Fee is payable and there is no entitlement to a refund.</li>
            <li>If, after the Client receives a refund, the Candidate is re-Engaged within 6 calendar months of termination, the refund must be repaid to the Agency, and the Client is not entitled to any further refunds in relation to that re-Engagement.</li>
          </ul>
        </section>

        <section id="introductions-third-parties">
          <h2><span class="policy-num">05</span>Introductions to Third Parties</h2>
          <p>Introductions of Candidates are confidential. If a Client discloses a Candidate's details to a third party, this is deemed a "Third Party Introduction". If that Third Party Introduction results in an Engagement of the Candidate by the third party within 6 months of the Agency's original Introduction, the Client is liable to the Agency for an Introduction Fee. Neither the Client nor the third party is entitled to a refund of that fee in any circumstances.</p>
        </section>

        <section id="suitability-checks">
          <h2><span class="policy-num">06</span>Suitability Checks</h2>
          <p>The Agency endeavours to ensure the suitability of Candidates Introduced to the Client by taking reasonably practicable steps to:</p>
          <ul>
            <li>Ensure it would not be detrimental to the interests of either the Client or the Candidate;</li>
            <li>Ensure both the Client and Candidate are aware of any requirements imposed by law or a professional body; and</li>
            <li>Confirm that the Candidate is willing to work in the position.</li>
          </ul>

          <p>Notwithstanding the above, the Client must satisfy itself as to the suitability of the Candidate. The Client is responsible for:</p>
          <ul>
            <li>Taking up any references provided by the Candidate before Engaging them;</li>
            <li>Checking the Candidate's right to work and obtaining any permission to work required by law;</li>
            <li>Arranging any medical examinations or investigations into the Candidate's medical history; and</li>
            <li>Satisfying any medical, qualification or other requirements needed for the Candidate to work in the Engagement.</li>
          </ul>

          <p>To enable the Agency to meet these obligations, the Client undertakes to provide details of the position, including:</p>
          <ul>
            <li>The type of work required;</li>
            <li>The location and hours of work;</li>
            <li>The experience, training, qualifications and authorisation required by the Client, law or a professional body;</li>
            <li>Any known health and safety risks and the steps taken to prevent or control them;</li>
            <li>The date the Candidate is required to commence;</li>
            <li>The duration or likely duration of the Engagement;</li>
            <li>The minimum rate of Remuneration, expenses and other benefits offered;</li>
            <li>The intervals of payment of Remuneration; and</li>
            <li>The notice period the Candidate would be entitled to give and receive.</li>
          </ul>
        </section>

        <section id="exclusivity-term">
          <h2><span class="policy-num">07</span>Exclusivity Term (If Applicable)</h2>
          <ul>
            <li>The Agency agrees to Introduce Candidates to the Client for direct Engagement for the duration of the Exclusivity Term.</li>
            <li>During the Exclusivity Term, the Client agrees to use only the Agency's services for the Introduction of permanent or contract staff, except where the Agency is unable to Introduce a suitable Candidate, or in the circumstances set out below.</li>
            <li>Nothing in these Terms prevents the Client from responding to unsolicited approaches from third-party agencies (by referring them to the Agency as a sub-contractor), responding to unsolicited approaches from work-seekers directly, or directly approaching work-seekers using its own resources.</li>
            <li>Subject to earlier termination rights, the Exclusivity Term ends when either party gives the other 3 months' written notice.</li>
            <li>Either party may immediately terminate the Exclusivity Term by notice if the other commits an unremedied breach of these Terms (14 days to remedy after notice), or is unable to pay its debts or enters compulsory or voluntary liquidation (other than for a genuine reconstruction or amalgamation where the resulting entity assumes the contract and liabilities).</li>
            <li>For the avoidance of doubt, if the Exclusivity Term is terminated by either party, the Client remains obligated to pay any fees owed to the Agency, whether relating to an Introduction made before or after termination.</li>
          </ul>
        </section>

        <section id="information-to-be-provided">
          <h2><span class="policy-num">08</span>Information to Be Provided</h2>
          <p>When the Agency Introduces a Candidate, it will inform the Client that it has obtained confirmation of the suitability matters set out in clause 6. Where this information is not given in paper or electronic form at the time, it will be confirmed by such means by the end of the third business day following (excluding weekends and public/bank holidays) — save where the Candidate is being Introduced for an Engagement the same as one they worked within the previous 5 business days, and that information has already been given to the Client.</p>
        </section>

        <section id="confidentiality-data-protection">
          <h2><span class="policy-num">09</span>Confidentiality</h2>
          <p>All information relating to a Candidate is confidential and must be handled in accordance with applicable <strong>UK data protection legislation, including the UK General Data Protection Regulation (UK GDPR), the Data Protection Act 2018, the Data (Use and Access) Act 2025</strong>, and any other applicable data protection and privacy legislation.</p>
          <p>Candidate information is provided to the Client solely for the purposes of recruitment, candidate assessment, placement and the provision of work-finding services. The Client must only use such information for lawful and specified purposes, must keep it secure, and must not disclose or make it available to any third party unless permitted by applicable law or otherwise authorised by the Agency.</p>
          <p>The Client must comply with all applicable data protection obligations when receiving, accessing, storing, using or sharing Candidate information and must take appropriate technical and organisational measures to protect such information against unauthorised or unlawful processing, accidental loss, destruction, damage or disclosure.</p>
          <p>The Client must notify the Agency without undue delay if it becomes aware of any actual or suspected personal data breach, unauthorised disclosure, or other incident affecting Candidate information supplied by the Agency.</p>
          <p>Information relating to the Agency's business that is confidential must also be kept confidential and must not be disclosed to any third party, except where the information is already lawfully in the public domain or disclosure is required by law.</p>
       <!--   <p>The Agency is registered with the <strong>Information Commissioner's Office (ICO)</strong>, under registration number <strong>ZB196377</strong>. For enquiries relating to the processing of personal data, exercising data protection rights, or raising a data protection complaint, please contact the Agency's Data Protection contact, <strong>Bilal Sheikh</strong>, at <a class="inline-link"  href="mailto:mbs@kingsburypersonnel.com">mbs@kingsburypersonnel.com</a> or <a class="inline-link" href="tel:+441494211220">+44 (0) 1494 211220</a>.</p> -->
        </section>
        
        <section id="international-data-transfer">
          <h2><span class="policy-num">10</span>International Data Transfer</h2>
          <p>Where it is necessary to transfer Candidate or Client information outside the United Kingdom (including to any country not covered by UK adequacy regulations), the Agency will only do so in accordance with the UK General Data Protection Regulation (UK GDPR), the Data Protection Act 2018, the Data (Use and Access) Act 2025, and any other applicable data protection legislation in force from time to time.</p>
          <p>Any such transfer will only take place where:</p>
          <ul>
            <li>the destination country, territory or organisation is covered by UK adequacy regulations; or</li>
            <li>appropriate safeguards are in place, such as the UK International Data Transfer Agreement (IDTA), the UK Addendum to the EU Standard Contractual Clauses, or Binding Corporate Rules approved by the Information Commissioner's Office; or</li>
            <li>a specific statutory exception (derogation) applies, such as the explicit consent of the individual concerned, or where the transfer is necessary for the performance of a contract with the individual.</li>
          </ul>
          <p>Where appropriate safeguards are relied upon, the Agency will carry out a Transfer Risk Assessment to evaluate whether the data protection laws and practices of the destination country undermine the protections being relied upon, and will implement any additional technical or organisational measures identified as necessary.</p>
          <p>The Agency maintains a record of any international transfers of personal data, including the recipient, the categories of data transferred, and the legal mechanism relied upon. This record is reviewed periodically and is available to the Information Commissioner's Office on request.</p>
        </section>

        <section id="liability">
          <h2><span class="policy-num">10</span>Liability</h2>
          <p>The Agency is not liable under any circumstances for any loss, expense, damage, delay, costs or compensation (whether direct, indirect or consequential) suffered or incurred by the Client arising from or connected with the Agency seeking a Candidate, the Introduction or Engagement of any Candidate, or the Agency's failure to introduce a Candidate. For the avoidance of doubt, the Agency does not exclude liability for death or personal injury arising from its own negligence, or for any other loss it is not permitted to exclude under law.</p>
          <p>The Client shall indemnify and keep indemnified the Agency against any Losses incurred by the Agency arising out of any non-compliance with the Data Protection Laws and/or as a result of any breach of these Terms by the Client.</p>
        </section>

        <section id="notices">
          <h2><span class="policy-num">11</span>Notices</h2>
          <p>All notices required under these Terms must be in writing, and may be delivered personally, by first-class prepaid post to the registered office of the party being served, or to any other address the party has notified in writing, by email or by facsimile transmission. A notice is deemed served: if by hand, when delivered; if by first-class post, 48 hours after posting; and if by email or facsimile, when sent.</p>
        </section>

        <section id="severability">
          <h2><span class="policy-num">12</span>Severability</h2>
          <p>If any provision of these Terms is determined by a competent authority to be unenforceable to any extent, that provision shall be severed to that extent, and the remaining terms shall continue to be valid to the fullest extent permitted by applicable law.</p>
        </section>

        <section id="governing-law">
          <h2><span class="policy-num">13</span>Governing Law and Jurisdiction</h2>
          <p>These Terms are governed by the law of England &amp; Wales and are subject to the exclusive jurisdiction of the Courts of England &amp; Wales.</p>

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