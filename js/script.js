(() => {
  // ---- Shared reCAPTCHA helper (contact form + lead modal) ----
  const kpCaptcha = (() => {
    const widgets = new Map(); // .g-recaptcha element -> widget id

    const insideClosedModal = el => {
      const modal = el.closest('#lead-magnet');
      return !!modal && !modal.classList.contains('is-open');
    };

    const render = el => {
      if (!el || widgets.has(el) || !window.grecaptcha?.render || insideClosedModal(el)) return;
      try {
        const id = window.grecaptcha.render(el, {
          sitekey: el.dataset.sitekey,
          theme: 'light'
        });
        widgets.set(el, id);
      } catch (error) {
        console.warn('reCAPTCHA render failed:', error);
      }
    };

    return {
      render,
      renderAll: () => document.querySelectorAll('.g-recaptcha').forEach(render),
      isRendered: el => widgets.has(el),
      getResponse: el => {
        if (!widgets.has(el)) return '';
        try {
          return window.grecaptcha.getResponse(widgets.get(el)) || '';
        } catch {
          return '';
        }
      },
      reset: el => {
        if (!widgets.has(el)) return;
        try {
          window.grecaptcha.reset(widgets.get(el));
        } catch {
          /* ignore */
        }
      }
    };
  })();
  window.kpCaptcha = kpCaptcha;
  // If the Google API finished loading before this file ran, render now.
  if (window.kpRecaptchaApiReady) kpCaptcha.renderAll();

  const LEAD_STORAGE_KEY = 'kpLeadMagnetSubmitted';

  const hasSubmittedLead = () => {
    try {
      return localStorage.getItem(LEAD_STORAGE_KEY) === '1';
    } catch {
      return false;
    }
  };

  const markLeadSubmitted = () => {
    try {
      localStorage.setItem(LEAD_STORAGE_KEY, '1');
    } catch {
      /* storage unavailable */
    }
  };

  const trackMetaEvent = (eventName, params = {}) => {
    const send = () => {
      if (typeof fbq !== 'function') return false;
      fbq('trackCustom', eventName, params);
      return true;
    };

    if (send()) return;

    let attempts = 0;
    const timer = window.setInterval(() => {
      attempts += 1;
      if (send() || attempts >= 20) {
        window.clearInterval(timer);
      }
    }, 100);
  };

  const LEAD_EVENT_KEY = 'kpLeadMagnetTracked';

  const trackLeadMagnetSubmit = () => {
    try {
      if (sessionStorage.getItem(LEAD_EVENT_KEY) === '1') return;
      sessionStorage.setItem(LEAD_EVENT_KEY, '1');
    } catch {
      /* storage unavailable */
    }
    trackMetaEvent('LeadMagnetSubmit', {
      content_name: 'Lead Magnet',
      content_category: 'Lead'
    });
  };

  const leadMagnet = document.getElementById('lead-magnet');
  const leadForm = document.getElementById('lead-magnet-form');
  const leadStatus = document.getElementById('lead-magnet-status');
  const leadSubmit = leadForm?.querySelector('.lead-magnet-submit');
  const leadSubmitLabel = leadSubmit?.innerHTML;
  const isContactPage = /(^|\/)contact\.php$/i.test(location.pathname || '');
  const REOPEN_DELAY_MS = 2 * 60 * 1000;
  const REOPEN_AT_KEY = 'kpLeadMagnetReopenAt';
  let reopenTimer = null;

  const getReopenAt = () => {
    try {
      const value = Number(sessionStorage.getItem(REOPEN_AT_KEY) || 0);
      return Number.isFinite(value) ? value : 0;
    } catch {
      return 0;
    }
  };

  const setReopenAt = timestamp => {
    try {
      if (timestamp) sessionStorage.setItem(REOPEN_AT_KEY, String(timestamp));
      else sessionStorage.removeItem(REOPEN_AT_KEY);
    } catch {
      /* storage unavailable */
    }
  };

  const clearReopenTimer = () => {
    if (reopenTimer) {
      window.clearTimeout(reopenTimer);
      reopenTimer = null;
    }
  };

  let leadMagnetWaiting = false;

function openLeadMagnetWhenAllowed() {
  // Cookie choice not made yet: do nothing now, open after the choice
  if (!window.kpHasCookieChoice || !window.kpHasCookieChoice()) {
    if (!leadMagnetWaiting) {
      leadMagnetWaiting = true;
      document.addEventListener('kp:cookie-choice-made', function () {
        leadMagnetWaiting = false;
        setTimeout(openLeadMagnet, 2000); // small delay so it doesn't feel abrupt
      }, { once: true });
    }
    return;
  }
  openLeadMagnet(); // your existing open function
}

  const openLeadMagnet = () => {
    if (!leadMagnet || isContactPage || hasSubmittedLead()) return;
    setReopenAt(0);
    leadMagnet.hidden = false;
    leadMagnet.classList.add('is-open');
    document.body.classList.add('lead-magnet-open');
    kpCaptcha.renderAll();
    window.setTimeout(() => {
      document.getElementById('lead-name')?.focus();
    }, 50);
  };

  const scheduleLeadMagnetReopen = delayMs => {
    clearReopenTimer();
    if (isContactPage || hasSubmittedLead() || !leadMagnet) return;
    reopenTimer = window.setTimeout(() => {
      reopenTimer = null;
      setReopenAt(0);
      if (!hasSubmittedLead()) openLeadMagnet();
    }, Math.max(0, delayMs));
  };

  const closeLeadMagnet = ({
    reschedule = false
  } = {}) => {
    if (!leadMagnet) return;
    leadMagnet.classList.remove('is-open');
    leadMagnet.hidden = true;
    document.body.classList.remove('lead-magnet-open');
    if (reschedule && !hasSubmittedLead()) {
      setReopenAt(Date.now() + REOPEN_DELAY_MS);
      scheduleLeadMagnetReopen(REOPEN_DELAY_MS);
    }
  };

  const dismissLeadMagnet = () => closeLeadMagnet({
    reschedule: true
  });

  leadMagnet?.querySelectorAll('[data-lead-close]').forEach(el => {
    el.addEventListener('click', dismissLeadMagnet);
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && leadMagnet?.classList.contains('is-open')) {
      dismissLeadMagnet();
    }
  });

  if (!isContactPage && !hasSubmittedLead()) {
    const remaining = getReopenAt() - Date.now();
    if (remaining > 0) {
      scheduleLeadMagnetReopen(remaining);
    } else {
      window.setTimeout(openLeadMagnet, 700);
    }
  }

  leadForm?.addEventListener('submit', async event => {
    event.preventDefault();
    if (!leadForm || !leadStatus) return;

    const requiredFields = [...leadForm.querySelectorAll('[required]')];
    let firstInvalid = null;

    requiredFields.forEach(field => {
      const invalid = !String(field.value || '').trim();
      field.setAttribute('aria-invalid', String(invalid));
      if (invalid && !firstInvalid) firstInvalid = field;
    });

    const email = leadForm.querySelector('#lead-email');
    if (email?.value && !email.validity.valid) {
      email.setAttribute('aria-invalid', 'true');
      firstInvalid||= email;
    }

    if (firstInvalid) {
      leadStatus.textContent = 'Please complete your name, email and employment type.';
      leadStatus.className = 'lead-magnet-status error';
      firstInvalid.focus();
      return;
    }

    const captchaWidget = leadForm.querySelector('.g-recaptcha');
    if (captchaWidget) kpCaptcha.render(captchaWidget);
    const captchaToken = captchaWidget ? kpCaptcha.getResponse(captchaWidget) : '';
    if (captchaWidget && !captchaToken) {
      leadStatus.textContent = kpCaptcha.isRendered(captchaWidget) ?
        'Please complete the CAPTCHA check before submitting.' :
        'The CAPTCHA could not load. Please refresh the page (and disable any ad-blocker) and try again.';
      leadStatus.className = 'lead-magnet-status error';
      captchaWidget.scrollIntoView({
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
        block: 'center'
      });
      return;
    }

    trackLeadMagnetSubmit();

    const payload = new FormData(leadForm);
    payload.set('formType', 'lead');
    payload.set('kp_hp', '');
    if (captchaToken) payload.set('g-recaptcha-response', captchaToken);
    payload.delete('website');

    if (leadSubmit) {
      leadSubmit.disabled = true;
      leadSubmit.textContent = 'Sending…';
    }
    leadStatus.textContent = '';
    leadStatus.className = 'lead-magnet-status';

    try {
      const response = await postApplication(payload);
      const raw = await response.text();
      let result = null;
      try {
        result = JSON.parse(raw);
      } catch {
        throw new Error('We could not send your details just now. Please try again.');
      }

      if (!response.ok || !result?.ok) {
        throw new Error(result?.message || 'We could not send your details just now.');
      }

      clearReopenTimer();
      setReopenAt(0);
      markLeadSubmitted();
      leadStatus.textContent = result.message;
      leadStatus.className = 'lead-magnet-status success';
      leadForm.reset();
      requiredFields.forEach(field => field.removeAttribute('aria-invalid'));
      window.setTimeout(() => closeLeadMagnet(), 1600);
    } catch (error) {
      if (captchaWidget) kpCaptcha.reset(captchaWidget);
      leadStatus.textContent = error.message || 'We could not send your details just now. Please try again.';
      leadStatus.className = 'lead-magnet-status error';
    } finally {
      if (leadSubmit) {
        leadSubmit.disabled = false;
        leadSubmit.innerHTML = leadSubmitLabel;
      }
    }
  });

  const header = document.getElementById('site-header');
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const mobileLinks = mobileMenu?.querySelectorAll('a') || [];

  const setHeaderState = () => {
    header?.classList.toggle('scrolled', window.scrollY > 20);
  };
  setHeaderState();
  window.addEventListener('scroll', setHeaderState, {
    passive: true
  });

  const closeMenu = () => {
    if (!menuToggle || !mobileMenu) return;
    menuToggle.classList.remove('active');
    mobileMenu.classList.remove('open');
    menuToggle.setAttribute('aria-expanded', 'false');
    menuToggle.setAttribute('aria-label', 'Open navigation');
    mobileMenu.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('menu-open');
  };

  menuToggle?.addEventListener('click', () => {
    const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.classList.toggle('active', !isOpen);
    mobileMenu?.classList.toggle('open', !isOpen);
    menuToggle.setAttribute('aria-expanded', String(!isOpen));
    menuToggle.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');
    mobileMenu?.setAttribute('aria-hidden', String(isOpen));
    document.body.classList.toggle('menu-open', !isOpen);
  });

  mobileLinks.forEach(link => link.addEventListener('click', closeMenu));
  window.addEventListener('resize', () => {
    if (window.innerWidth > 900) closeMenu();
  });

  const revealElements = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -30px'
    });
    revealElements.forEach(el => revealObserver.observe(el));
  } else {
    revealElements.forEach(el => el.classList.add('visible'));
  }

  const counters = document.querySelectorAll('.counter');
  if ('IntersectionObserver' in window && counters.length) {
    const counterObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = Number(el.dataset.target || 0);
        const suffix = el.dataset.suffix || '';
        const duration = 1500;
        const start = performance.now();
        const tick = now => {
          const progress = Math.min((now - start) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          el.textContent = `${Math.floor(target * eased)}${suffix}`;
          if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
        observer.unobserve(el);
      });
    }, {
      threshold: 0.65
    });
    counters.forEach(counter => counterObserver.observe(counter));
  }

  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const button = item.querySelector('.faq-question');
    button?.addEventListener('click', () => {
      const willOpen = !item.classList.contains('active');
      faqItems.forEach(other => {
        other.classList.remove('active');
        other.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
      });
      if (willOpen) {
        item.classList.add('active');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });

  const slider = document.querySelector('[data-slider]');
  if (slider) {
    const track = slider.querySelector('.testimonial-track');
    const cards = [...slider.querySelectorAll('.testimonial-card')];
    const dotsContainer = slider.querySelector('.slider-dots');
    const prevButton = slider.querySelector('.slider-prev');
    const nextButton = slider.querySelector('.slider-next');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let currentIndex = 0;
    let cardsPerView = getCardsPerView();
    let totalSlides = getTotalSlides();
    let autoPlay;

    function getCardsPerView() {
      if (window.innerWidth <= 767) return 1;
      if (window.innerWidth <= 991) return 2;
      return 3;
    }

    function getTotalSlides() {
      return Math.max(1, cards.length - cardsPerView + 1);
    }

    function createDots() {
      if (!dotsContainer) return;
      dotsContainer.innerHTML = '';
      totalSlides = getTotalSlides();

      for (let i = 0; i < totalSlides; i += 1) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Show testimonial group ${i + 1}`);
        if (i === currentIndex) dot.classList.add('active');
        dot.addEventListener('click', () => {
          goToSlide(i);
          restartAutoPlay();
        });
        dotsContainer.appendChild(dot);
      }
    }

    function updateSlider() {
      if (!track || !cards.length) return;

      cardsPerView = getCardsPerView();
      totalSlides = getTotalSlides();

      if (currentIndex >= totalSlides) currentIndex = totalSlides - 1;
      if (currentIndex < 0) currentIndex = 0;

      const cardWidth = cards[0].getBoundingClientRect().width;
      const styles = window.getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap) || 0;
      track.style.transform = `translateX(-${(cardWidth + gap) * currentIndex}px)`;

      dotsContainer?.querySelectorAll('button').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
      });
    }

    function goToSlide(index) {
      if (index < 0) index = totalSlides - 1;
      if (index >= totalSlides) index = 0;
      currentIndex = index;
      updateSlider();
    }

    prevButton?.addEventListener('click', () => {
      goToSlide(currentIndex - 1);
      restartAutoPlay();
    });

    nextButton?.addEventListener('click', () => {
      goToSlide(currentIndex + 1);
      restartAutoPlay();
    });

    let startX = 0;
    track?.addEventListener('touchstart', event => {
      startX = event.touches[0].clientX;
    }, {
      passive: true
    });

    track?.addEventListener('touchend', event => {
      const difference = startX - event.changedTouches[0].clientX;
      if (Math.abs(difference) < 50) return;
      goToSlide(currentIndex + (difference > 0 ? 1 : -1));
      restartAutoPlay();
    }, {
      passive: true
    });

    function startAutoPlay() {
      if (reduceMotion || cards.length <= cardsPerView) return;
      stopAutoPlay();
      autoPlay = setInterval(() => goToSlide(currentIndex + 1), 5000);
    }

    function stopAutoPlay() {
      clearInterval(autoPlay);
    }

    function restartAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);

    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        createDots();
        updateSlider();
      }, 150);
    });

    createDots();
    updateSlider();
    startAutoPlay();
  }

  const getApplicationUrl = () => {
    const apacheUrl = `${location.protocol === 'https:' ? 'https' : 'http'}://kingsburypersonnel.com/send-application.php`;

    const phpOnThisHost =
      (location.protocol === 'http:' || location.protocol === 'https:') &&
      (location.port === '' || location.port === '80' || location.port === '443');

    if (phpOnThisHost) {
      if (location.pathname.includes('/kingsburypersonnel')) {
        return `${location.origin}/kingsburypersonnel.com/send-application.php`;
      }

      return new URL('send-application.php', location.href).href;
    }

    return apacheUrl;
  };

  const postApplication = async (payload) => {
    const urls = [
      getApplicationUrl(),
      'https://kingsburypersonnel.com/send-application.php',
      'http://kingsburypersonnel.com/send-application.php'
    ];

    let lastError = null;

    for (const url of [...new Set(urls)]) {
      try {
        const response = await fetch(url, {
          method: 'POST',
          body: payload,
          mode: 'cors',
          credentials: 'include',
          cache: 'no-store'
        });

        return response;
      } catch (error) {
        console.error('Fetch failed:', url, error);
        lastError = error;
      }
    }

    throw lastError || new Error(
      'Failed to reach the mail server. Please open the website directly and try again.'
    );
  };

  const form = document.getElementById('candidate-form');
  const formStatus = document.getElementById('form-status');
  const submitButton = form?.querySelector('.form-submit');
  const selectedFile = document.getElementById('selected-file');
  const defaultSubmitLabel = submitButton?.innerHTML;

  // ---- Eligibility screening ----
  const NURSE_SPECIALISMS = ['Nurse', 'RGN', 'RMN', 'RNLD'];
  // Full postcode (TW15 1AB) or just the outward code (TW15, W1, B33); the CRM accepts both.
  const UK_POSTCODE_PATTERN = /^(GIR\s?0AA|[A-Z]{1,2}\d[A-Z\d]?(\s?\d[A-Z]{2})?)$/i;
  const specialismSelect = form?.querySelector('#specialism');
  const nmcField = form?.querySelector('#nmc-field');
  const nmcSelect = form?.querySelector('#nmc-registration');
  const ukResidentField = form?.querySelector('#uk-resident-field');

  // UK phone: returns national format (07700900123) or null. Mirrors normaliseUkPhone() in send-application.php.
  const normaliseUkPhone = value => {
    const raw = String(value || '').trim();
    if (!raw || !/^[\d\s().+\-]+$/.test(raw)) return null;
    const digits = raw.replace(/\D/g, '');
    let rest;
    if (digits.startsWith('0044') || digits.startsWith('44')) {
      rest = digits.slice(digits.startsWith('0044') ? 4 : 2);
      if (rest.startsWith('0')) rest = rest.slice(1); // "+44 (0) 7700 …"
    } else if (digits.startsWith('0')) {
      rest = digits.slice(1);
    } else {
      return /^[1-9]\d{9}$/.test(digits) ? `0${digits}` : null;
    }
    return /^[1-9]\d{8,9}$/.test(rest) ? `0${rest}` : null;
  };

  const isNurseRole = () =>NURSE_SPECIALISMS.includes(specialismSelect?.value || '');

  const syncNmcField = () => {
    if (!nmcField || !nmcSelect) return;
    const show = isNurseRole();
    nmcField.hidden = !show;
    nmcSelect.disabled = !show;
    nmcSelect.required = show;
    if (!show) {
      nmcSelect.value = '';
      clearFieldError(nmcSelect);
    }
    syncNmcPinField();
  };

  // NMC PIN: only shown and required when the applicant confirms NMC registration.
  const NMC_PIN_PATTERN = /^\d{2}[A-Z]\d{4}[A-Z]$/;
  const nmcPinField = form?.querySelector('#nmc-pin-field');
  const nmcPinInput = form?.querySelector('#nmc-pin');

  function syncNmcPinField() {
    if (!nmcPinField || !nmcPinInput) return;
    const show = isNurseRole() && nmcSelect?.value === 'Yes';
    nmcPinField.hidden = !show;
    nmcPinInput.disabled = !show;
    nmcPinInput.required = show;
    if (!show) {
      nmcPinInput.value = '';
      clearFieldError(nmcPinInput);
    }
  }

  // ---- Per-field error messages (shown under each field) ----
  const CV_EXTENSIONS = ['pdf', 'doc', 'docx'];
  const CV_MAX_BYTES = 10 * 1024 * 1024;
  const CAPTCHA_KEY = 'g-recaptcha-response';
  const fieldKey = el => (el.classList?.contains('g-recaptcha') ? CAPTCHA_KEY : el.name);

  const fieldByName = name => name === CAPTCHA_KEY ?
    form.querySelector('.g-recaptcha') :
    form.querySelector(`[name="${name}"]:not([disabled])`);

  const errorElementFor = (field, create) => {
    const key = fieldKey(field);
    let el = form.querySelector(`.field-error[data-error-for="${key}"]`);
    if (!el && create) {
      el = document.createElement('p');
      el.className = 'field-error';
      el.dataset.errorFor = key;
      el.id = `${key}-error`;
      if (field.classList.contains('g-recaptcha')) {
        field.after(el);
      } else {
        (field.closest('.field, .screening-radio, .cv-upload, .checkbox-row') || field.parentElement).appendChild(el);
      }
    }
    return el;
  };

  const groupOf = field => (field.type === 'radio' ? [...form.querySelectorAll(`[name="${field.name}"]`)] : [field]);

  const setFieldError = (field, message) => {
    if (!field) return;
    const el = errorElementFor(field, true);
    el.textContent = message;
    el.hidden = false;
    groupOf(field).forEach(t => {
      t.setAttribute('aria-invalid', 'true');
      t.setAttribute('aria-describedby', el.id);
    });
    field.closest('.screening-radio, .cv-upload')?.classList.add('is-invalid');
  };

  const clearFieldError = field => {
    if (!field) return;
    const el = errorElementFor(field, false);
    if (el) {
      el.textContent = '';
      el.hidden = true;
    }
    groupOf(field).forEach(t => {
      t.removeAttribute('aria-invalid');
      if (el && t.getAttribute('aria-describedby') === el.id) t.removeAttribute('aria-describedby');
    });
    field.closest('.screening-radio, .cv-upload')?.classList.remove('is-invalid');
  };

  const clearAllFieldErrors = () => {
    form.querySelectorAll('.field-error').forEach(el => {
      el.textContent = '';
      el.hidden = true;
    });
    form.querySelectorAll('[aria-invalid]').forEach(el => el.removeAttribute('aria-invalid'));
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    formStatus.textContent = '';
    formStatus.className = 'form-status';
  };

  const showFormErrorSummary = count => {
    formStatus.textContent = count === 1 ?
      'Please fix the highlighted field above.' :
      `Please fix the ${count} highlighted fields above.`;
    formStatus.className = 'form-status error';
  };

  const focusField = field => {
    field.scrollIntoView({
      behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
      block: 'center'
    });
    if (!field.classList.contains('g-recaptcha')) field.focus({ preventScroll: true });
  };

  // One entry per field name (first radio of a group), skipping hidden/disabled/honeypot fields.
  const candidateFields = () => {
    const byName = new Map();
    form.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
      if (el.disabled || el.type === 'hidden' || el.classList.contains('hp-field') || el.closest('.g-recaptcha')) return;
      if (!byName.has(el.name)) byName.set(el.name, el);
    });
    return [...byName.values()];
  };

  // Returns an error message for the field, or '' when it is valid.
  const validateCandidateField = field => {
    if (field.disabled) return '';
    const value = (field.value || '').trim();
    switch (field.name) {
      case 'fullName':
        return value ? '' : 'Please enter your full name.';
      case 'email':
        if (!value) return 'Please enter your email address.';
        return field.validity.valid ? '' : 'Please enter a valid email address (for example name@example.com).';
      case 'phone':
        if (!value) return 'Please enter your phone number.';
        return normaliseUkPhone(value) ? '' : 'Please enter a valid UK phone number (for example 07700 900123).';
      case 'experience':
        return value ? '' : 'Please select your years of experience.';
      case 'visaStatus':
        return value ? '' : 'Please select your visa status.';
      case 'postcode': {
        const postcode = value.toUpperCase().replace(/\s+/g, ' ');
        if (!postcode) return 'Please enter your UK postcode.';
        return UK_POSTCODE_PATTERN.test(postcode) ? '' : 'Please enter a valid UK postcode (for example TW15 or TW15 1AB).';
      }
      case 'specialism':
        return value ? '' : 'Please select your primary specialism.';
      case 'nmcRegistered':
        return value ? '' : 'Please tell us whether you have a valid NMC registration.';
      case 'nmcPin': {
        const pin = value.replace(/\s+/g, '').toUpperCase();
        if (!pin) return 'Please enter your NMC PIN.';
        return NMC_PIN_PATTERN.test(pin) ? '' : 'Please enter a valid NMC PIN (8 characters, for example 12A3456E).';
      }
      case 'ukResident':
        return form.querySelector('input[name="ukResident"]:checked') ? '' : 'Please tell us whether you currently live in the UK.';
      case 'cv': {
        const file = field.files?.[0];
        if (!file) return 'Please upload your CV (PDF, DOC or DOCX, up to 10MB).';
        const extension = file.name.split('.').pop().toLowerCase();
        if (!CV_EXTENSIONS.includes(extension)) return 'Please upload your CV as a PDF, DOC or DOCX file.';
        return file.size > CV_MAX_BYTES ? 'Your CV must be smaller than 10MB.' : '';
      }
      default:
        if (field.type === 'checkbox') return field.required && !field.checked ? 'Please tick this box to continue.' : '';
        return field.required && !value ? 'Please complete this field.' : '';
    }
  };

  // Shared with the CV drag-and-drop script in footer.php.
  window.kpFieldErrors = { set: setFieldError, clear: clearFieldError };

  // Clear an error as soon as the field is fixed; check a filled-in field when the user leaves it.
  const recheckField = (field, showNew) => {
    if (!field?.name || field.closest('.g-recaptcha') || field.classList.contains('hp-field')) return;
    const message = validateCandidateField(field);
    if (!message) clearFieldError(field);
    else if (showNew || field.getAttribute('aria-invalid') === 'true') setFieldError(field, message);
  };
  form?.addEventListener('input', event => {
    if (event.target.getAttribute('aria-invalid') === 'true') recheckField(event.target, false);
  });
  form?.addEventListener('change', event => recheckField(event.target, false));
  form?.addEventListener('focusout', event => {
    const field = event.target;
    if (['text', 'email', 'tel'].includes(field.type) && field.value.trim()) recheckField(field, true);
  });

  specialismSelect?.addEventListener('change', syncNmcField);
  nmcSelect?.addEventListener('change', syncNmcPinField);
  syncNmcField();

  form?.addEventListener('submit', async event => {
    event.preventDefault();
    syncNmcField();

    // Validate every field and show each problem under its own field.
    clearAllFieldErrors();
    const problems = [];
    candidateFields().forEach(field => {
      const message = validateCandidateField(field);
      if (message) problems.push([field, message]);
    });

    const captchaWidget = form.querySelector('.g-recaptcha');
    if (captchaWidget) kpCaptcha.render(captchaWidget);
    const captchaToken = captchaWidget ? kpCaptcha.getResponse(captchaWidget) : '';
    if (captchaWidget && !captchaToken) {
      problems.push([captchaWidget, kpCaptcha.isRendered(captchaWidget) ?
        'Please tick "I\'m not a robot" before submitting.' :
        'The CAPTCHA could not load. Please refresh the page (and disable any ad-blocker) and try again.']);
    }

    if (problems.length) {
      problems.forEach(([field, message]) => setFieldError(field, message));
      showFormErrorSummary(problems.length);
      focusField(problems[0][0]);
      return;
    }

    // Send the cleaned-up values the server expects.
    const postcode = form.querySelector('#postcode');
    if (postcode) postcode.value = postcode.value.trim().toUpperCase().replace(/\s+/g, ' ');
    if (nmcPinInput && !nmcPinInput.disabled) nmcPinInput.value = nmcPinInput.value.replace(/\s+/g, '').toUpperCase();

    // Disqualified applicants still submit: the server screens them, and the
    // thank-you page shows a different message and fires the disqualified_lead event.

    const payload = new FormData(form);
    payload.set('kp_hp', '');
    if (captchaToken) payload.set('g-recaptcha-response', captchaToken);
    payload.delete('website');

    const cvInput = form.querySelector('#cv-upload');
    const cvFile = cvInput?.files?.[0];
    if (cvFile) {
      payload.set('cv', cvFile, cvFile.name);
    }
    submitButton.disabled = true;
    submitButton.textContent = 'Sending application…';
    formStatus.textContent = '';
    formStatus.className = 'form-status';

    try {
      const response = await postApplication(payload);
      const raw = await response.text();
      let result = null;
      try {
        result = JSON.parse(raw);
      } catch {
        throw new Error('Open this site at https://kingsburypersonnel.com/ and submit again. Email cannot be sent from a Live Server or file preview.');
      }

      if (!response.ok || !result?.ok) {
        const serverErrors = Object.entries(result?.errors || {})
          .map(([name, message]) => [fieldByName(name), message])
          .filter(([field]) => field);
        if (serverErrors.length) {
          if (captchaWidget) kpCaptcha.reset(captchaWidget);
          serverErrors.forEach(([field, message]) => setFieldError(field, message));
          showFormErrorSummary(serverErrors.length);
          focusField(serverErrors[0][0]);
          return;
        }
        throw new Error(result?.message || 'We could not send your application just now.');
      }

      formStatus.textContent = result.message;
      formStatus.className = 'form-status success';
      markLeadSubmitted();
      form.reset();
      clearAllFieldErrors();
      if (selectedFile) {
        selectedFile.textContent = '';
        selectedFile.style.color = '';
      }

      // Redirect to the thank-you page after a successful submission.
      window.location.href = 'thank-you.php';
      return; // stop here so the `finally` block doesn't re-enable the button on an unloading page
    } catch (error) {
      if (captchaWidget) kpCaptcha.reset(captchaWidget);
      const failedToFetch = /failed to fetch/i.test(error.message || '');
      formStatus.textContent = failedToFetch ?
        'Open https://kingsburypersonnel.com/ in your browser and submit the form there. Previews and Live Server cannot send the email.' :
        (error.message || 'We could not send your application just now. Please try again.');
      formStatus.className = 'form-status error';
    } finally {
      submitButton.disabled = false;
      submitButton.innerHTML = defaultSubmitLabel;
    }
  });

  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', event => {
      const href = link.getAttribute('href');
      if (!href || href === '#') return;
      const target = document.querySelector(href);
      if (!target) return;
      event.preventDefault();
      target.scrollIntoView({
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
        block: 'start'
      });
    });
  });
})();