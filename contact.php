<?php

$kpPageTitle = 'Contact | Kingsbury Personnel Ltd.';
$captchaConfig = require __DIR__ . '/config/captcha.php';
include 'header.php';

$saleId = isset($_GET['ref']) ? trim($_GET['ref']) : '';
$url = $saleId === '' ? '' : 'http://192.168.110.15/sales/' . rawurlencode($saleId) . '/history';
?>
<main>
    <section id="contact" style="padding-top:150px;padding-bottom:150px" class="section contact-section">
        <div class="site-container contact-layout">
            <div class="contact-panel reveal">
                <div class="eyebrow eyebrow-light"><span></span>Care work that fits your life</div>
                <h2>Send us your CV. We&#8217;ll find your next care role</h2>
                <p>Share your details and upload your CV. A Kingsbury consultant will read it, then call you about care roles that match your experience. Free for carers, always.</p>
                <div class="contact-details">
                    <div><span>Speak to our recruitment team</span><a
                            href="tel:+441494211220">+44 (0) 1494 211220</a></div>
                    <div><span>Email</span><a
                            href="mailto:info@kingsburypersonnel.com">info@kingsburypersonnel.com</a></div>
                    <div><span>Address</span>
                        <p>124 City Road, London, England, EC1V 2NX</p>
                    </div>
                    <div><span>Coverage</span><strong>Recruitment support across the
                            UK</strong></div>
                </div>
                <div class="contact-note"><span>✓</span>
                    <p><strong>Responsive
                            candidate support.</strong> Submit your CV and a consultant
                        will follow up with suitable roles.</p>
                </div>
            </div>
<style>
    .visa-notice {
    background: #FFF8E8;
    border: 1px solid #F3D38A;
    border-left: 4px solid #D99A24;
    border-radius: 6px;
    padding: 14px 16px;
    margin-top: 18px;
    text-align: left;
}

.visa-notice-title {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #8A5A12;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 7px;
}

.notice-icon {
    font-size: 18px;
}

.visa-notice p {
    color: #684C20;
    font-size: 13px;
    line-height: 1.6;
    margin: 0;
}
</style>
            <div class="form-wrap reveal">
                <form id="candidate-form"
                    action="send-application.php"
                    method="post"
                    enctype="multipart/form-data"
                    novalidate>
                    <input type="hidden" name="saleUrl" value="<?= htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />
                    <input type="text"
                        name="kp_hp"
                        class="hp-field"
                        value=""
                        tabindex="-1"
                        autocomplete="off"
                        data-lpignore="true"
                        data-1p-ignore="true"
                        aria-hidden="true" />

                    <div class="form-heading">
                        <span>TAKES 2 MINUTES</span>
                        <h3>Tell us what you're looking for</h3>

                        <div class="visa-notice">
                            <div class="visa-notice-title">
                                <span class="notice-icon">ⓘ</span>
                                Important – Right to Work in the UK
                            </div>
                            <p>
                                Please note that we are unable to offer visa sponsorship.
                                To be considered for this opportunity, applicants must
                                already have the legal right to work in the UK.
                            </p>
                        </div>
                    </div>

                    <div class="form-grid">

                        <div class="field">
                            <label for="full-name">Full Name <small style="color:#c6831d;">(Legal Name)</small><span class="red">*</span></label>
                            <input id="full-name"
                                name="fullName"
                                type="text"
                                autocomplete="given-name" placeholder="Enter Full Name"
                                required />
                        </div>

                        <div class="field">
                            <label for="email">
                                Email Address <span class="red">*</span>
                            </label>

                            <input id="email"
                                name="email"
                                type="email"
                                autocomplete="email" placeholder="Enter your email address"
                                required />
                        </div>

                        <div class="field">
                            <label for="phone">
                                Phone <span class="red">*</span>
                            </label>

                            <input id="phone"
                                name="phone"
                                type="tel"
                                autocomplete="tel" placeholder="e.g. 07700 900123"
                                required />
                        </div>

                        <div class="field">
                            <label for="experience">
                                Years of Experience
                            </label>

                            <select id="experience"
                                name="experience"
                                required>

                                <option value>Select experience</option>
                                <option value="0-1 Year">0-1 Year</option>
                                <option value="1-3 Years">1-3 Years</option>
                                <option value="3-5 Years">3-5 Years</option>
                                <option value="5-10 Years">5-10 Years</option>
                                <option value="10+ Years">10+ Years</option>

                            </select>
                        </div>

                        <div class="field field-full">
                            <label for="visa-status">
                                What is your current visa status? <span class="red">*</span>
                            </label>
                            <!-- <small class="field-hint">British Citizen, Indefinite Leave to Remain (ILR), or another visa with permanent/unrestricted right to work is acceptable.</small> -->
                            <select id="visa-status"
                                name="visaStatus"
                                required>
                                <option value="">Select your visa status</option>
                                <option value="British Citizen">British Citizen</option>
                                <option value="Indefinite Leave to Remain (ILR)">Indefinite Leave to Remain (ILR)</option>
                                <option value="Other visa with permanent/unrestricted right to work">Other visa with permanent/unrestricted right to work</option>
                                <option value="Visa with restricted right to work">Visa with restricted right to work</option>
                                <option value="I require visa sponsorship">I require visa sponsorship</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="postcode">
                                What is your current UK postcode? <span class="red">*</span>
                            </label>
                            <input id="postcode"
                                name="postcode"
                                type="text"
                                maxlength="8"
                                autocomplete="postal-code"
                                placeholder="e.g. TW15 or TW15 1AB"
                                required />
                            <!-- <small class="field-hint">This is required to assess your location and suitability for available vacancies.</small> -->
                        </div>

                        <div class="field">
                            <label for="specialism">
                                Primary Specialism <span class="red">*</span>
                            </label>
                            <select id="specialism"
                                name="specialism"
                                required>
                                <option value>Select Specialism</option>
                                <option value="Care / Support Worker">Care / Support Worker</option>
                                <option value="Chef">Chef</option>
                                <option value="Chef Hotel">Chef Hotel</option>
                                <option value="Head Chef">Head Chef</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Registered Manager">Registered Manager</option>
                                <option value="RGN">RGN</option>
                                <option value="RMN">RMN</option>
                                <option value="RNLD">RNLD</option>
                                <option value="Solicitor">Solicitor</option>
                                <option value="Senior Chef">Senior Chef</option>
                                <option value="Sous Chef">Sous Chef</option>

                            </select>
                        </div>

                        <div class="field" id="nmc-field" hidden>
                            <label for="nmc-registration">
                                Do you have a valid NMC registration? <span class="red">*</span>
                            </label>
                            <select id="nmc-registration"
                                name="nmcRegistered"
                                disabled>
                                <option value="">Select an option</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <small class="field-hint">This is required to assess your eligibility for nursing roles.</small>
                        </div>

                        <div class="field" id="nmc-pin-field" hidden>
                            <label for="nmc-pin">
                                NMC PIN <span class="red">*</span>
                            </label>
                            <input id="nmc-pin"
                                name="nmcPin"
                                type="text"
                                maxlength="8"
                                autocomplete="off"
                                placeholder="e.g. 12A3456E"
                                disabled />
                            <small class="field-hint">Your 8-character NMC Personal Identification Number.</small>
                        </div>

                        <!-- ELIGIBILITY SCREENING -->
                        <fieldset class="field field-full screening-radio" id="uk-resident-field">
                            <legend>
                                Are you currently residing in the UK? <span class="red">*</span>
                            </legend>
                            <div class="radio-options">
                                <label><input type="radio" name="ukResident" value="Yes" required /> Yes</label>
                                <label><input type="radio" name="ukResident" value="No" /> No</label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- CV UPLOAD -->
                    <div class="cv-upload">

                        <label class="cv-label">
                            Upload Curriculum Vitae (CV) <span class="red">*</span>
                        </label>

                        <label class="cv-dropzone" for="cv-upload">

                            <input type="file"
                                id="cv-upload"
                                name="cv"
                                accept=".pdf,.doc,.docx"
                                required />

                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 16V4m0 0L7 9m5-5 5 5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />

                                    <path d="M5 14v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <div class="upload-text">
                                <strong>
                                    Drag and drop your CV here, or click to browse
                                </strong>

                                <span>
                                    PDF, DOC or DOCX up to 10MB
                                </span>
                            </div>

                            <div class="selected-file" id="selected-file"></div>

                        </label>

                    </div>

                    <!-- PRIVACY -->
                    <label class="checkbox-row" for="privacy">

                        <span>
                            By submitting you agree to our
                            <a href="/privacy-policy.php">Privacy Policy</a>.
                        </span>

                    </label>

                    <?php if ($captchaConfig['site_key'] !== ''): ?>
                        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($captchaConfig['site_key'], ENT_QUOTES, 'UTF-8') ?>"></div>
                    <?php endif; ?>

                    <!-- SUBMIT -->
                    <button type="submit"
                        class="btn btn-primary mt-2 btn-lg form-submit">

                        Submit My Application
                        <span>→</span>

                    </button>

                    <p id="form-status"
                        class="form-status"
                        role="status"
                        aria-live="polite">
                    </p>

                </form>
            </div>
        </div>
    </section>
    <!-- =========================================================
     KINGSBURY PERSONNEL - WELLBEING GUIDE POPUP
========================================================= -->

    <style>
        /* =========================
       POPUP OVERLAY
    ========================= */
        .wellbeing-popup-overlay {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background: rgba(2, 18, 31, 0.78);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 999999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        .wellbeing-popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* =========================
       IMAGE MODAL
    ========================= */
        .wellbeing-popup {
            position: relative;
            width: min(650px, 100%);
            max-height: 90vh;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
            transform: translateY(30px) scale(0.96);
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .wellbeing-popup-overlay.active .wellbeing-popup {
            transform: translateY(0) scale(1);
        }

        /* =========================
       IMAGE
    ========================= */
        .wellbeing-popup-image {
            width: 100%;
            max-height: 90vh;
            overflow: hidden;
        }

        .wellbeing-popup-image img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 90vh;
            object-fit: contain;
        }

        /* =========================
       CLOSE BUTTON
    ========================= */
        .wellbeing-popup-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50%;
            background: rgba(3, 20, 30, 0.75);
            color: #ffffff;
            font-size: 25px;
            line-height: 1;
            cursor: pointer;
            z-index: 10;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        .wellbeing-popup-close:hover {
            background: rgba(3, 20, 30, 0.95);
            transform: rotate(90deg);
        }

        /* =========================
       MOBILE
    ========================= */
        @media (max-width: 767px) {
            .wellbeing-popup-overlay {
                padding: 12px;
            }

            .wellbeing-popup {
                width: 100%;
                max-height: 94vh;
                border-radius: 12px;
            }

            .wellbeing-popup-image img {
                max-height: 94vh;
            }

            .wellbeing-popup-close {
                top: 8px;
                right: 8px;
                width: 36px;
                height: 36px;
                font-size: 21px;
            }
        }
    </style>


    <!-- =========================================================
     IMAGE ONLY POPUP
========================================================= -->

    <div
        class="wellbeing-popup-overlay"
        id="wellbeingGuidePopup"
        aria-hidden="true">

        <div
            class="wellbeing-popup"
            role="dialog"
            aria-modal="true"
            aria-label="Kingsbury Personnel Wellbeing Guide">

            <!-- CLOSE -->
            <button
                type="button"
                class="wellbeing-popup-close"
                id="wellbeingPopupClose"
                aria-label="Close popup">
                &times;
            </button>

            <!-- IMAGE ONLY -->
            <div class="wellbeing-popup-image">
                <img
                    src="assets/images/hint-for-pdf-2.png"
                    alt="Kingsbury Personnel Wellbeing Guide">
            </div>

        </div>
    </div>


    <script>
        //     document.addEventListener("DOMContentLoaded", function() {

        //         const popup = document.getElementById("wellbeingGuidePopup");
        //         const closeButton = document.getElementById("wellbeingPopupClose");

        //         if (!popup || !closeButton) {
        //             return;
        //         }

        //         /* =========================
        //            OPEN POPUP
        //         ========================= */
        //         function openWellbeingPopup() {
        //             popup.classList.add("active");
        //             popup.setAttribute("aria-hidden", "false");
        //             document.body.style.overflow = "hidden";
        //         }

        //         /* =========================
        //            CLOSE POPUP
        //         ========================= */
        //         function closeWellbeingPopup() {
        //             popup.classList.remove("active");
        //             popup.setAttribute("aria-hidden", "true");
        //             document.body.style.overflow = "";
        //         }

        //         /* =========================
        //            AUTO OPEN AFTER 3 SECONDS
        //         ========================= */
        //         setTimeout(function() {

        //             const lastShown = localStorage.getItem(
        //                 "kingsbury_wellbeing_popup"
        //             );

        //             const now = Date.now();
        //             const twentyFourHours = 24 * 60 * 60 * 1000;

        //             if (
        //                 !lastShown ||
        //                 now - parseInt(lastShown, 10) > twentyFourHours
        //             ) {
        //                 openWellbeingPopup();

        //                 localStorage.setItem(
        //                     "kingsbury_wellbeing_popup",
        //                     now.toString()
        //                 );
        //             }

        //         }, 3000);

        //         /* =========================
        //            CLOSE BUTTON
        //         ========================= */
        //         closeButton.addEventListener(
        //             "click",
        //             closeWellbeingPopup
        //         );

        //         /* =========================
        //            CLICK OUTSIDE
        //         ========================= */
        //         popup.addEventListener("click", function(event) {

        //             if (event.target === popup) {
        //                 closeWellbeingPopup();
        //             }

        //         });

        //         /* =========================
        //            ESC KEY
        //         ========================= */
        //         document.addEventListener("keydown", function(event) {

        //             if (
        //                 event.key === "Escape" &&
        //                 popup.classList.contains("active")
        //             ) {
        //                 closeWellbeingPopup();
        //             }

        //         });

        //     });
        // 
    </script>
</main>

<?php include 'footer.php'; ?>