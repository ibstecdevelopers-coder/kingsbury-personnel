<?php

//echo $_SERVER['SERVER_ADDR'];
//exit();
$kpPageTitle = 'Contact | Kingsbury Personnel Ltd.';
include 'header.php';

$saleId = isset($_GET['ref']) ? trim($_GET['ref']) : '';
$url = $saleId === '' ? '' : 'http://192.168.110.15/sales/' . rawurlencode($saleId) . '/history';
?>
<main>
    <section id="contact" style="padding-top:150px;padding-bottom:150px" class="section contact-section">
        <div class="site-container contact-layout">
            <div class="contact-panel reveal">
                <div class="eyebrow eyebrow-light"><span></span>Candidate
                    enquiries</div>
                <h2>Looking for Your Next Role?</h2>
                <p>Tell us about yourself and your experience, and our recruitment
                    team will get back to you with suitable roles.</p>
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
                        <span>Candidate Profile</span>
                        <h3>Create your professional profile</h3>
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
                                autocomplete="tel" placeholder="Enter your phone number"
                                required />
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

                        <div class="field">
                            <label for="sponsorship">
                                Do you require sponsorship? <span class="red">*</span>
                            </label>

                            <select id="sponsorship"
                                name="sponsorship"
                                required>
                                <option value="">Select an option</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

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

                    <!-- SUBMIT -->
                    <button type="submit"
                        class="btn btn-primary btn-lg form-submit">

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
        document.addEventListener("DOMContentLoaded", function() {

            const popup = document.getElementById("wellbeingGuidePopup");
            const closeButton = document.getElementById("wellbeingPopupClose");

            if (!popup || !closeButton) {
                return;
            }

            /* =========================
               OPEN POPUP
            ========================= */
            function openWellbeingPopup() {
                popup.classList.add("active");
                popup.setAttribute("aria-hidden", "false");
                document.body.style.overflow = "hidden";
            }

            /* =========================
               CLOSE POPUP
            ========================= */
            function closeWellbeingPopup() {
                popup.classList.remove("active");
                popup.setAttribute("aria-hidden", "true");
                document.body.style.overflow = "";
            }

            /* =========================
               AUTO OPEN AFTER 3 SECONDS
            ========================= */
            setTimeout(function() {

                const lastShown = localStorage.getItem(
                    "kingsbury_wellbeing_popup"
                );

                const now = Date.now();
                const twentyFourHours = 24 * 60 * 60 * 1000;

                if (
                    !lastShown ||
                    now - parseInt(lastShown, 10) > twentyFourHours
                ) {
                    openWellbeingPopup();

                    localStorage.setItem(
                        "kingsbury_wellbeing_popup",
                        now.toString()
                    );
                }

            }, 3000);

            /* =========================
               CLOSE BUTTON
            ========================= */
            closeButton.addEventListener(
                "click",
                closeWellbeingPopup
            );

            /* =========================
               CLICK OUTSIDE
            ========================= */
            popup.addEventListener("click", function(event) {

                if (event.target === popup) {
                    closeWellbeingPopup();
                }

            });

            /* =========================
               ESC KEY
            ========================= */
            document.addEventListener("keydown", function(event) {

                if (
                    event.key === "Escape" &&
                    popup.classList.contains("active")
                ) {
                    closeWellbeingPopup();
                }

            });

        });
    </script>
</main>

<?php include 'footer.php'; ?>