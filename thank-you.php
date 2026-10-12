<?php

session_start();

$submittedApplication = $_SESSION['submitted_application'] ?? null;
if (!is_array($submittedApplication) || empty($_SESSION['form_submitted'])) {
  header('Location: index.php');
  exit;
}

$submittedName = htmlspecialchars((string) ($submittedApplication['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$submittedEmail = htmlspecialchars((string) ($submittedApplication['email'] ?? ''), ENT_QUOTES, 'UTF-8');
$submittedSpecialism = htmlspecialchars((string) ($submittedApplication['specialism'] ?? ''), ENT_QUOTES, 'UTF-8');

// Delete session data immediately
unset($_SESSION['submitted_application']);
unset($_SESSION['form_submitted']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Thank You | Kingsbury Personnel Ltd.</title>
  <meta name="robots" content="noindex, nofollow">

  <style>
    :root {
      --kp-primary: #0d6efd;
      --kp-primary-dark: #084298;
      --kp-bg: #08172b;
      --kp-card-bg: #ffffff;
      --kp-text: #1c2536;
      --kp-muted: #667085;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background:
        radial-gradient(circle at top,
          var(--kp-bg) 0%,
          var(--kp-bg) 60%);
      color: var(--kp-text);
      padding: 24px;
      overflow: hidden;
    }


    /* =========================================
   PARTY CONFETTI CONTAINER
========================================= */

    .party-container {
      position: fixed;
      inset: 0;

      pointer-events: none;

      overflow: hidden;

      z-index: 100;
    }


    /* =========================================
   PARTY POPPER
========================================= */

    .party-popper {
      position: fixed;

      left: 50%;
      top: 50%;

      width: 70px;
      height: 70px;

      transform:
        translate(-50%, -50%) scale(0);

      z-index: 110;

      animation:
        popper-appear 0.7s cubic-bezier(.17, .89, .32, 1.49) 0.4s forwards;
    }


    /* Popper opening animation */

    @keyframes popper-appear {

      0% {
        transform:
          translate(-50%, -50%) scale(0) rotate(-20deg);

        opacity: 0;
      }

      60% {
        transform:
          translate(-50%, -50%) scale(1.25) rotate(8deg);

        opacity: 1;
      }

      100% {
        transform:
          translate(-50%, -50%) scale(1) rotate(0);

        opacity: 0;
      }
    }


    /* =========================================
   CONFETTI PIECES
========================================= */

    .confetti {
      position: fixed;

      left: 50%;
      top: 50%;

      width: 10px;
      height: 18px;

      opacity: 0;

      z-index: 105;

      animation:
        confetti-explode 2.4s cubic-bezier(.15, .75, .35, 1) forwards;
    }


    /* Different confetti shapes */

    .confetti.circle {
      border-radius: 50%;
    }

    .confetti.square {
      border-radius: 2px;
    }

    .confetti.ribbon {
      width: 7px;
      height: 24px;

      border-radius: 5px;
    }


    /* Explosion */

    @keyframes confetti-explode {

      0% {
        transform:
          translate(-50%, -50%) translate(0, 0) rotate(0deg) scale(0.3);

        opacity: 1;
      }

      20% {
        opacity: 1;
      }

      65% {
        opacity: 1;
      }

      100% {
        transform:
          translate(-50%, -50%) translate(var(--x),
            var(--y)) rotate(var(--rotation)) scale(1);

        opacity: 0;
      }
    }




    /* =========================================
   THANK YOU CARD
========================================= */

    .thank-you-card {

      position: relative;

      z-index: 10;

      background:
        var(--kp-card-bg);

      border-radius: 20px;

      box-shadow:
        0 20px 60px rgba(13, 110, 253, 0.12);

      padding: 56px 40px;

      max-width: 520px;

      width: 100%;

      text-align: center;

      animation:
        card-in 0.7s ease-out both;
    }

    @keyframes card-in {

      from {
        opacity: 0;

        transform:
          translateY(30px) scale(.95);
      }

      to {
        opacity: 1;

        transform:
          translateY(0) scale(1);
      }
    }


    /* =========================================
   CHECK BADGE
========================================= */

    .check-badge {
      position: relative;
      width: 84px;
      height: 84px;
      margin: 0 auto 24px;
      border-radius: 50%;
      border: 2px solid #34d399;
      background: transparent;
      display: flex;
      align-items: center;
      justify-content: center;

      box-shadow:
        0 12px 30px rgba(13, 110, 253, .25);

      animation:
        badge-pop .7s cubic-bezier(.34, 1.56, .64, 1) .3s both;
    }

    @keyframes badge-pop {

      0% {
        opacity: 0;

        transform:
          scale(0);
      }

      70% {
        transform:
          scale(1.15);
      }

      100% {
        opacity: 1;

        transform:
          scale(1);
      }
    }

    .check-badge svg {

      width: 40px;
      height: 40px;

      stroke: #34d399;

      stroke-width: 3;

      fill: none;

      stroke-linecap: round;
      stroke-linejoin: round;
    }


    /* =========================================
   HEADING
========================================= */

    .thank-you-heading {

      font-size:
        clamp(2.2rem,
          5vw,
          3rem);

      font-weight: 800;

      margin:
        0 0 12px;

      line-height: 1.1;

      color:
        var(--kp-text);
    }


    /* =========================================
   MESSAGE
========================================= */

    .thank-you-message {

      color:
        var(--kp-muted);

      font-size:
        1.05rem;

      line-height:
        1.6;

      margin:
        0 0 32px;
    }


    /* =========================================
   BUTTONS
========================================= */

    .thank-you-actions {

      display: flex;

      flex-direction: column;

      gap: 12px;

      align-items: center;
    }

    .btn-download {

      display: inline-flex;

      align-items: center;

      justify-content: center;

      gap: 10px;

      background:
        var(--kp-primary);

      color: #fff;

      text-decoration: none;

      font-weight: 600;

      font-size: 1rem;

      padding:
        14px 28px;

      border-radius:
        999px;

      box-shadow:
        0 10px 24px rgba(13, 110, 253, .28);

      transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
    }

    .btn-download:hover,
    .btn-download:focus-visible {

      background:
        var(--kp-primary-dark);

      transform:
        translateY(-2px);

      box-shadow:
        0 14px 30px rgba(13, 110, 253, .35);
    }

    .btn-download svg {

      width: 18px;
      height: 18px;

      stroke: currentColor;

      fill: none;

      stroke-width: 2;

      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .btn-secondary {

      color:
        var(--kp-muted);

      text-decoration:
        none;

      font-size:
        .95rem;

      padding:
        8px 12px;

      border-radius:
        8px;

      transition:
        color .2s ease,
        background .2s ease;
    }

    .btn-secondary:hover,
    .btn-secondary:focus-visible {

      color:
        var(--kp-primary-dark);

      background:
        #eef3ff;
    }


    /* =========================================
   MOBILE
========================================= */

    @media (max-width: 600px) {

      body {
        padding: 18px;
      }

      .thank-you-card {

        padding:
          44px 24px;

        border-radius:
          18px;
      }

      .check-badge {

        width: 76px;
        height: 76px;
      }

      .check-badge svg {

        width: 36px;
        height: 36px;
      }

      .thank-you-heading {

        font-size:
          2.35rem;
      }

      .thank-you-message {

        font-size:
          1rem;
      }

      .btn-download {

        width: 100%;

        max-width:
          280px;
      }

      .party-popper::before {

        font-size:
          55px;
      }
    }


    /* =========================================
   REDUCED MOTION
========================================= */

    @media (prefers-reduced-motion: reduce) {

      *,
      *::before,
      *::after {

        animation-duration:
          .01ms !important;

        animation-iteration-count:
          1 !important;
      }
    }

    .disabled {
      pointer-events: none;
      opacity: 0.5;
    }

    .socials {
      display: flex;
      gap: 8px;
    }

    .socials {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
      padding-top: 18px;
      border-top: 1px solid #eef0f4;
    }

    .socials a {
      width: 36px;
      height: 36px;
      display: grid;
      place-items: center;
      border-radius: 50%;
      color: #fff;
      background: var(--kp-primary);
      text-decoration: none;
      transition: all .2s ease;
    }

    .socials a svg {
      width: 16px;
      height: 16px;
      display: block;
    }

    .socials a:hover,
    .socials a:focus-visible {
      background: var(--kp-primary-dark);
      transform: translateY(-2px);
    }
  </style>
</head>

<body>
  <!-- ========================================
     PARTY POPPER + CONFETTI
========================================= -->

  <div
    class="party-container"
    id="partyContainer">

    <div
      class="party-popper">
    </div>

  </div>


  <!-- ========================================
     THANK YOU CARD
========================================= -->

  <div class="thank-you-card">

    <div
      class="check-badge"
      aria-hidden="true">

      <svg viewBox="0 0 24 24">

        <polyline
          points="20 6 9 17 4 12">
        </polyline>

      </svg>

    </div>


    <h1 class="thank-you-heading">
      Thank You!
    </h1>


    <p class="thank-you-message">

      Your application has been received.
      One of our recruitment consultants
      will be in touch shortly.

      In the meantime, feel free
      to download our candidate guide below.

    </p>


    <div class="thank-you-actions">

      <a
        class="btn-download"
        href="assets/pdfs/Kingsbury Personnel Wellbeing Guide.pdf"
        download>

        <svg viewBox="0 0 24 24">

          <path d="M12 3v12"></path>

          <path d="M7 10l5 5 5-5"></path>

          <path d="M5 21h14"></path>

        </svg>

        Download PDF

      </a>


      <a
        class="btn-secondary"
        href="index.php">

        Back to home

      </a>

    </div>

    <!-- Social Media -->
    <div class="socials">
      <a href="https://www.linkedin.com/company/kingsburypersonnel/"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="LinkedIn">

        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor"
            d="M20.45 20.45h-3.55v-5.57c0-1.33 0-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45z" />
        </svg>
      </a>

      <a href="https://www.facebook.com/Kingsburypersonnelltd"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Facebook">

        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor"
            d="M14.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.5 1.6-1.5h1.7V4.9c-.3 0-1.4-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V11H8.4v3h2.7v8h3.4z" />
        </svg>
      </a>

      <a href="https://www.instagram.com/kingsburyperssonel"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Instagram">

        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor"
            d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 2A3.8 3.8 0 0 0 4 7.8v8.4A3.8 3.8 0 0 0 7.8 20h8.4A3.8 3.8 0 0 0 20 16.2V7.8A3.8 3.8 0 0 0 16.2 4H7.8zm9.65 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
        </svg>
      </a>
    </div>
  </div>


  <script>
    document.addEventListener(
      "DOMContentLoaded",
      function() {

        const container =
          document.getElementById(
            "partyContainer"
          );


        /* ======================================
           PARTY POPPER EXPLOSION
        ====================================== */

        const colors = [
          "#0d6efd",
          "#34d399",
          "#fbbf24",
          "#f43f5e",
          "#8b5cf6",
          "#06b6d4",
          "#fb7185"
        ];


        for (
          let i = 0; i < 90; i++
        ) {

          const confetti =
            document.createElement("span");


          const shapes = [
            "circle",
            "square",
            "ribbon"
          ];


          confetti.className =
            "confetti " +
            shapes[
              Math.floor(
                Math.random() *
                shapes.length
              )
            ];


          confetti.style.background =
            colors[
              Math.floor(
                Math.random() *
                colors.length
              )
            ];


          /*
           * Explosion direction
           */

          const angle =
            Math.random() *
            Math.PI *
            2;


          const distance =
            180 +
            Math.random() * 420;


          const x =
            Math.cos(angle) *
            distance;


          const y =
            Math.sin(angle) *
            distance;


          const rotation =
            Math.random() *
            900 -
            450;


          confetti.style.setProperty(
            "--x",
            x + "px"
          );


          confetti.style.setProperty(
            "--y",
            y + "px"
          );


          confetti.style.setProperty(
            "--rotation",
            rotation + "deg"
          );


          confetti.style.animationDelay =
            (
              Math.random() * .35
            ) + "s";


          container.appendChild(
            confetti
          );

        }




        /* ======================================
           CLEAN UP AFTER ANIMATION
        ====================================== */

        setTimeout(
          function() {

            const elements =
              container.querySelectorAll(
                ".confetti, .falling-confetti, .balloon"
              );


            elements.forEach(
              function(element) {

                setTimeout(
                  function() {
                    element.remove();
                  },
                  500
                );

              }
            );

          },
          10000
        );

      }
    );

    document.addEventListener("DOMContentLoaded", function() {
      const downloadButton = document.querySelector(".btn-download");

      if (downloadButton) {
        downloadButton.addEventListener("click", function() {
          const consent = typeof ccGetConsent === "function" ? ccGetConsent() : null;
          if (consent && consent.marketing === true && typeof fbq === "function") {
            fbq("trackCustom", "LeadMagnetDownloadFile", {
              content_name: "Kingsbury Personnel Wellbeing Guide",
              content_category: "Lead Magnet"
            });
          }
        });
      }
    });
  </script>

  <?php include 'cookie-consent.html'; ?>
  <script>
    function trackCandidateProfile() {
      var consent = typeof ccGetConsent === 'function' ? ccGetConsent() : null;
      if (consent && consent.marketing === true && !window.__kpSubmitCandidateProfileSent && typeof fbq === 'function') {
        window.__kpSubmitCandidateProfileSent = true;
        fbq('track', 'SubmitCandidateProfile');
      }
    }

    if (window.__kpMetaMarketingReady) {
      trackCandidateProfile();
    } else {
      document.addEventListener('kp:marketing-consent', trackCandidateProfile, {
        once: true
      });
    }
  </script>

</body>

</html>


<?php
// include __DIR__ . '/partials/footer.php';