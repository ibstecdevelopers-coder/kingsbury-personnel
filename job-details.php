<?php

include 'header.php';
require_once __DIR__ . '/includes/jobs-api.php';

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if ($id === '') {
  header('Location: search-job.php');
  exit;
}

$res      = kp_job_details($id);
$job      = $res['job'];
$apiError = $res['ok'] ? null : $res['error'];

if (!$job) {
  http_response_code(404);
}

/* A few similar roles for the sidebar (same specialism, different id) */
$similar = [];
if ($job) {
  $open = kp_open_jobs();
  foreach ($open['jobs'] as $candidate) {
    if ((string) $candidate['id'] === (string) $job['id']) {
      continue;
    }
    if ($job['sector'] !== '' && strcasecmp($candidate['sector'], $job['sector']) !== 0) {
      continue;
    }
    $similar[] = $candidate;
    if (count($similar) === 4) {
      break;
    }
  }
}

$pageTitle = $job
  ? $job['title'] . ($job['location'] !== '' ? ' in ' . $job['location'] : '')
  : 'Vacancy not found';
?>

<head>
  <title><?= e($pageTitle) ?> | Kingsbury Personnel Ltd.</title>
  <meta name="description" content="<?= e($job ? kp_teaser($job, 150) : 'Browse current vacancies with Kingsbury Personnel.') ?>">
</head>
<main id="main-content">

  <?php if (!$job): ?>

    <section class="kp-jobs-results">
      <div class="kp-container">
        <div class="kp-notice kp-notice--error">
          <h1>This vacancy isn't available</h1>
          <p>It may have been filled or withdrawn. Take a look at everything we currently have open.</p>
          <?php if ($apiError && ini_get('display_errors')): ?>
            <p class="kp-notice__debug">Debug: <?= e($apiError) ?></p>
          <?php endif; ?>
          <a class="kp-btn kp-btn--navy" href="search-job.php">Search all jobs</a>
        </div>
      </div>
    </section>

  <?php else: ?>

    <section class="section section-navy" style="padding: 150px 0 60px;">
      <div class="site-container">
        <nav class="kp-breadcrumb" aria-label="Breadcrumb">
          <a href="index.php">Home</a> <span aria-hidden="true">/</span>
          <a href="search-job.php">Search Jobs</a> <span aria-hidden="true">/</span>
          <span><?= e($job['title']) ?></span>
        </nav>

        <?php if ($job['sector'] !== ''): ?>
          <p class="kp-eyebrow kp-eyebrow--light"><?= e($job['sector']) ?></p>
        <?php endif; ?>
        <div class="section-heading light reveal">
        <h2><?= e($job['title']) ?></h2>
        </div>

        <ul class="kp-job-hero__facts">
          <?php if ($job['location'] !== ''): ?>
            <li><span aria-hidden="true">&#9906;</span><?= e($job['location']) ?></li>
          <?php endif; ?>
          <?php if ($job['salary'] !== ''): ?>
            <li><?= e($job['salary']) ?></li>
          <?php endif; ?>
          <?php if ($job['type'] !== ''): ?>
            <li><span aria-hidden="true">&#9635;</span><?= e(ucwords($job['type'])) ?></li>
          <?php endif; ?>
          <?php if ($label = kp_posted_label($job['posted'])): ?>
            <li><span aria-hidden="true">&#9201;</span><?= e($label) ?></li>
          <?php endif; ?>
        </ul>

        <div class="kp-job-hero__actions">
          <a class="kp-btn kp-btn--gold"
            href="contact.php?role=<?= urlencode($job['title']) ?>&amp;ref=<?= urlencode($job['reference'] ?: $job['id']) ?>">
            Apply for this role
          </a>
          <a class="kp-btn kp-btn--ghost"
            href="https://wa.me/447597019065?text=<?= rawurlencode("Hi, I'm interested in the " . $job['title'] . ' role' . ($job['reference'] !== '' ? ' (Ref ' . $job['reference'] . ')' : '')) ?>"
            target="_blank" rel="noopener">WhatsApp us</a>
        </div>
      </div>
    </section>

    <section class="kp-job-body">
      <div class="kp-container kp-job-layout">

        <div class="kp-job-main">
          <?php if ($job['summary'] !== '' && $job['description'] !== ''): ?>
            <p class="kp-job-lead"><?= e(strip_tags($job['summary'])) ?></p>
          <?php endif; ?>

          <?php if ($job['description'] !== ''): ?>
            <h2>About the role</h2>
            <div class="kp-rich"><?= kp_rich_text($job['description']) ?></div>
          <?php elseif ($job['summary'] !== ''): ?>
            <h2>About the role</h2>
            <div class="kp-rich"><?= kp_rich_text($job['summary']) ?></div>
          <?php else: ?>
            <div class="kp-rich">
              <p>Full details for this vacancy are available from our consultants
                &mdash; get in touch and we'll talk you through it.</p>
            </div>
          <?php endif; ?>

          <?php if ($job['requirements'] !== ''): ?>
            <h2>What we're looking for</h2>
            <div class="kp-rich"><?= kp_rich_text($job['requirements']) ?></div>
          <?php endif; ?>

          <?php if ($job['benefits'] !== ''): ?>
            <h2>What's on offer</h2>
            <div class="kp-rich"><?= kp_rich_text($job['benefits']) ?></div>
          <?php endif; ?>

          <div class="kp-apply-box">
            <h3>Interested in this role?</h3>
            <p>Send us your CV and a consultant will call you back to discuss it.</p>
            <a class="kp-btn kp-btn--gold"
              href="contact.php?role=<?= urlencode($job['title']) ?>&amp;ref=<?= urlencode($job['reference'] ?: $job['id']) ?>">
              Apply now
            </a>
          </div>
        </div>

        <aside class="kp-job-side">
          <div class="kp-side-card">
            <h3>Job overview</h3>
            <dl class="kp-side-list">
              <?php
              $rows = [
                'Reference'  => $job['reference'],
                'Specialism' => $job['sector'],
                'Location'   => $job['location'],
                //'Postcode'   => $job['postcode'],
                'Job type'   => ucwords($job['type']),
                'Hours'      => $job['hours'],
                'Salary'     => $job['salary'],
                'Start date' => $job['start_date'] ? (strtotime($job['start_date']) ? date('j M Y', strtotime($job['start_date'])) : $job['start_date']) : '',
                'Consultant' => $job['consultant'],
              ];
              foreach ($rows as $label => $value):
                if ($value === '') {
                  continue;
                } ?>
                <div>
                  <dt><?= e($label) ?></dt>
                  <dd><?= e($value) ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
            <a class="kp-btn kp-btn--navy kp-btn--block" href="search-job.php">&larr; Back to all jobs</a>
          </div>

          <?php if ($similar): ?>
            <div class="kp-side-card">
              <h3>Similar roles</h3>
              <ul class="kp-side-jobs">
                <?php foreach ($similar as $s): ?>
                  <li>
                    <a href="job-details.php?id=<?= urlencode($s['id']) ?>"><?= e($s['title']) ?></a>
                    <?php if ($s['location'] !== ''): ?><span><?= e($s['location']) ?></span><?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </aside>

      </div>
    </section>

  <?php endif; ?>

</main>

<?php include 'footer.php'; ?>