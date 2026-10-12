<?php

include 'header.php';
require_once __DIR__ . '/includes/jobs-api.php';

/* ---------------- 1. Load ---------------- */
$result   = kp_open_jobs();
$allJobs  = $result['jobs'];
$apiError = $result['ok'] ? null : $result['error'];

/* ---------------- 2. Filter inputs ---------------- */
$q        = isset($_GET['q'])        ? trim($_GET['q'])        : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$sector   = isset($_GET['sector'])   ? trim($_GET['sector'])   : '';
$type     = isset($_GET['type'])     ? trim($_GET['type'])     : '';
$page     = max(1, (int) (isset($_GET['page']) ? $_GET['page'] : 1));
$perPage  = 9;

/* Build the dropdown options from the live data */
$sectorOptions = $typeOptions = $locationOptions = [];
foreach ($allJobs as $j) {
  if ($j['sector'] !== '') {
    $sectorOptions[$j['sector']] = true;
  }
  if ($j['type'] !== '') {
    $typeOptions[$j['type']] = true;
  }
  if ($j['location'] !== '') {
    $locationOptions[$j['location']] = true;
  }
}
$sectorOptions   = array_keys($sectorOptions);
sort($sectorOptions,   SORT_NATURAL | SORT_FLAG_CASE);
$typeOptions     = array_keys($typeOptions);
sort($typeOptions,     SORT_NATURAL | SORT_FLAG_CASE);
$locationOptions = array_keys($locationOptions);
sort($locationOptions, SORT_NATURAL | SORT_FLAG_CASE);

/* ---------------- 3. Apply filters ---------------- */
$jobs = array_values(array_filter($allJobs, function ($job) use ($q, $location, $sector, $type) {
  if ($q !== '') {
    $lower = function ($s) {
      return function_exists('mb_strtolower') ? mb_strtolower($s, 'UTF-8') : strtolower($s);
    };
    $haystack = $lower(implode(' ', [
      $job['title'],
      $job['sector'],
      $job['location'],
      $job['reference'],
      $job['summary'],
      strip_tags((string) $job['description']),
    ]));
    foreach (preg_split('/\s+/', $lower($q)) as $word) {
      if ($word !== '' && strpos($haystack, $word) === false) {
        return false;
      }
    }
  }
  if ($location !== '' && stripos($job['location'] . ' ' . $job['postcode'], $location) === false) {
    return false;
  }
  if ($sector !== '' && strcasecmp($job['sector'], $sector) !== 0) {
    return false;
  }
  if ($type !== '' && strcasecmp($job['type'], $type) !== 0) {
    return false;
  }
  return true;
}));

$total      = count($jobs);
$totalPages = max(1, (int) ceil($total / $perPage));
$page       = min($page, $totalPages);
$pageJobs   = array_slice($jobs, ($page - 1) * $perPage, $perPage);
$hasFilters = ($q !== '' || $location !== '' || $sector !== '' || $type !== '');
?>

<head>
  <title>Search Jobs | Kingsbury Personnel Ltd.</title>
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
</head>
<main id="main-content">

  <!-- ============ HERO + SEARCH ============ -->
  <section class="policy-hero" style="padding: 150px 0 60px;">
    <div class="site-container">
      <div class="section-heading light reveal">
        <div class="eyebrow eyebrow-light"><span></span>Live vacancies &middot; UK wide</div>
        <h2>Find Your Next Care or Nursing Role</h2>
        <p>Every role below is open right now. Search by job title, location or
          specialism and apply in a couple of clicks.</p>
      </div>

      <form class="kp-searchbar" action="search-job.php" method="get" role="search">
        <div class="kp-searchbar__field">
          <label for="q">Keyword</label>
          <input type="text" id="q" name="q" value="<?= e($q) ?>"
            placeholder="e.g. RGN, Care Assistant, Registered Manager">
        </div>
        <div class="kp-searchbar__field">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" value="<?= e($location) ?>"
            placeholder="Town, city or postcode" list="kp-locations">
          <datalist id="kp-locations">
            <?php foreach ($locationOptions as $opt): ?>
              <option value="<?= e($opt) ?>"></option>
            <?php endforeach; ?>
          </datalist>
        </div>
        <div class="kp-searchbar__field kp-searchbar__field--select">
          <label for="sector">Specialism</label>
          <select id="sector" name="sector">
            <option value="">All specialisms</option>
            <?php foreach ($sectorOptions as $opt): ?>
              <option value="<?= e($opt) ?>" <?= strcasecmp($opt, $sector) === 0 ? 'selected' : '' ?>><?= e($opt) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="kp-searchbar__field kp-searchbar__field--select">
          <label for="type">Job type</label>
          <select id="type" name="type">
            <option value="">Any type</option>
            <?php foreach ($typeOptions as $opt): ?>
              <option value="<?= e($opt) ?>" <?= strcasecmp($opt, $type) === 0 ? 'selected' : '' ?>><?= e(ucwords($opt)) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="kp-btn kp-btn--gold kp-searchbar__submit">Search jobs</button>
      </form>

      <div class="kp-jobs-hero__meta">
        <span><strong><?= (int) count($allJobs) ?></strong> vacancies</span>
        <span><strong><?= (int) count($locationOptions) ?></strong> locations</span>
        <span><strong><?= (int) count($sectorOptions) ?></strong> specialisms</span>
        <span><strong><?= (int) count($typeOptions) ?></strong> job types</span>
      </div>
    </div>
  </section>

  <!-- ============ RESULTS ============ -->
  <section class="kp-jobs-results">
    <div class="kp-container">

      <div class="kp-results-head">
        <h2>
          <?php if ($hasFilters): ?>
            <?= (int) $total ?> <?= $total === 1 ? 'matching role' : 'matching roles' ?>
          <?php else: ?>
            All roles
          <?php endif; ?>
        </h2>
        <?php if ($hasFilters): ?>
          <div class="kp-chips">
            <?php
            $chips = ['q' => $q, 'location' => $location, 'sector' => $sector, 'type' => $type];
            foreach ($chips as $key => $val):
              if ($val === '') {
                continue;
              } ?>
              <a class="kp-chip" href="<?= e(kp_url_with([$key => '', 'page' => ''])) ?>">
                <?= e($val) ?><span aria-hidden="true">&times;</span>
                <span class="kp-sr">Remove filter</span>
              </a>
            <?php endforeach; ?>
            <a class="kp-chip kp-chip--clear" href="search-job.php">Clear all</a>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($apiError): ?>
        <div class="kp-notice kp-notice--error">
          <h3>We can't load our vacancies right now</h3>
          <p>
            Please try again in a few minutes, or
            <a href="contact.php">register your CV</a> and a consultant will send you
            suitable roles directly.
          </p>
          <?php if (ini_get('display_errors')): ?>
            <p class="kp-notice__debug">Debug: <?= e($apiError) ?></p>
          <?php endif; ?>
        </div>

      <?php elseif (!$pageJobs): ?>
        <div class="kp-notice">
          <h3>No roles match that search</h3>
          <p>
            Try a broader keyword or a nearby location. New vacancies are added
            regularly &mdash; or <a href="contact.php">register your CV</a> and we'll
            get in touch when something suitable comes in.
          </p>
          <a class="kp-btn kp-btn--navy" href="search-job.php">View all open roles</a>
        </div>

      <?php else: ?>
        <div class="kp-job-grid">
          <?php foreach ($pageJobs as $job):
            $link = 'job-details.php?id=' . urlencode($job['id']); ?>
            <article class="kp-job-card">
              <div class="kp-job-card__top">
                <?php if ($job['sector'] !== ''): ?>
                  <span class="kp-tag"><?= e($job['sector']) ?></span>
                <?php endif; ?>
                <?php if ($label = kp_posted_label($job['posted'])): ?>
                  <span class="kp-job-card__posted"><?= e($label) ?></span>
                <?php endif; ?>
              </div>

              <h3 class="kp-job-card__title">
                <a href="<?= e($link) ?>"><?= e($job['title']) ?></a>
              </h3>

              <ul class="kp-job-card__facts">
                <?php if ($job['location'] !== ''): ?>
                  <li><span class="kp-ico" aria-hidden="true">&#9906;</span><?= e($job['location']) ?></li>
                <?php endif; ?>
                <?php if ($job['salary'] !== ''): ?>
                  <li><span class="kp-ico" aria-hidden="true">&#163;</span><?= e($job['salary']) ?></li>
                <?php endif; ?>
                <?php if ($job['type'] !== ''): ?>
                  <li><span class="kp-ico" aria-hidden="true">&#9635;</span><?= e(ucwords($job['type'])) ?></li>
                <?php endif; ?>
                <?php if ($job['hours'] !== ''): ?>
                  <li><span class="kp-ico" aria-hidden="true">&#9201;</span><?= e($job['hours']) ?></li>
                <?php endif; ?>
              </ul>

              <?php if ($teaser = kp_teaser($job)): ?>
                <p class="kp-job-card__teaser"><?= e($teaser) ?></p>
              <?php endif; ?>

              <div class="kp-job-card__foot">
                <a class="kp-btn kp-btn--navy kp-btn--sm" href="<?= e($link) ?>">View details</a>
                <?php if ($job['reference'] !== ''): ?>
                  <span class="kp-job-card__ref">Ref <?= e($job['reference']) ?></span>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
          <nav class="kp-pagination" aria-label="Job results pages">
            <?php if ($page > 1): ?>
              <a href="<?= e(kp_url_with(['page' => $page - 1])) ?>" class="kp-page">&larr; Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++):
              if ($totalPages > 7 && $i > 2 && $i < $totalPages - 1 && abs($i - $page) > 1) {
                if ($i === 3) {
                  echo '<span class="kp-page kp-page--gap">…</span>';
                }
                continue;
              } ?>
              <a href="<?= e(kp_url_with(['page' => $i])) ?>"
                class="kp-page <?= $i === $page ? 'is-current' : '' ?>"
                <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
              <a href="<?= e(kp_url_with(['page' => $page + 1])) ?>" class="kp-page">Next &rarr;</a>
            <?php endif; ?>
          </nav>
        <?php endif; ?>
      <?php endif; ?>

    </div>
  </section>

  <!-- ============ CTA ============ -->
  <section class="section section-navy">
    <div class="section-heading light centered" style="margin-bottom: 0;">
      <div class="eyebrow eyebrow-light justify-center"><span></span>Can't see the right role?</div>
      <h2>Register Your CV &amp; we'll come to you</h2>
      <p>Our consultants hear about many roles before they reach a job board. Tell us what you're looking for and we'll match you.</p>
      <a class="kp-btn kp-btn--gold" style="margin-top:60px" href="contact.php">Register Your CV</a>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>