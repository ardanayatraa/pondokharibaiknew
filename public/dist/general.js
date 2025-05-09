// public/js/general.js

// ----------------------------------
// STATE
// ----------------------------------
const bookingData = {
    roomId: null,
    room: null,
    checkIn: '',
    checkOut: '',
    adults: 2,
    children: 0,
    nights: 0,
    guestName: '',
    guestEmail: '',
    guestPhone: '',
    guestCountry: '',
    specialRequests: '',
    paymentMethod: 'credit',
    cardName: '',
    cardNumber: '',
    cardMonth: '',
    cardYear: '',
    cardCVV: ''
  };

  let currentStep = 1;
  const totalSteps = 5;
  let inPicker = null, outPicker = null, disabledRanges = [];

  // ----------------------------------
  // HELPERS
  // ----------------------------------
  function log(stage, ...args) {
    console.log(`🚀 [${stage}]`, ...args);
  }
  function formatDateISO(d) {
    return d.toISOString().slice(0, 10);
  }
  function calcNights() {
    const a = new Date(bookingData.checkIn);
    const b = new Date(bookingData.checkOut);
    const diff = (b - a) / (1000 * 60 * 60 * 24);
    bookingData.nights = diff > 0 ? diff : 1;
  }
  function formatCurrency(v) {
    return new Intl.NumberFormat('id-ID').format(v);
  }

  // ----------------------------------
  // STEP NAVIGATION
  // ----------------------------------
  function goToStep(step) {
    log('goToStep', step);
    document.getElementById(`step-${currentStep}`).classList.add('hidden');
    document.getElementById(`step-${step}`).classList.remove('hidden');
    const pct = ((step - 1) / (totalSteps - 1)) * 100;
    document.getElementById('progress-bar').style.width = pct + '%';
    currentStep = step;
    document.getElementById('prev-step').classList.toggle('hidden', step === 1);
    const nxt = document.getElementById('next-step');
    nxt.innerHTML = step === totalSteps
      ? `<div class="flex items-center"><span>Finish</span><i class="fas fa-check ml-2"></i></div>`
      : `<div class="flex items-center"><span>Next</span><i class="fas fa-arrow-right ml-2"></i></div>`;
  }
  function resetStepper() {
    goToStep(1);
  }

  // ----------------------------------
  // MODAL CONTROL
  // ----------------------------------
  function openModal() {
    log('openModal');
    document.getElementById('booking-stepper-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() =>
      document.getElementById('modal-content').classList.replace('opacity-0', 'opacity-100'),
    10);
    resetStepper();
  }
  function closeModal() {
    log('closeModal');
    document.getElementById('modal-content').classList.replace('opacity-100', 'opacity-0');
    setTimeout(() => {
      document.getElementById('booking-stepper-modal').classList.add('hidden');
      document.body.style.overflow = '';
    }, 300);
  }

  // ----------------------------------
  // ROOM DATA & UI
  // ----------------------------------
  async function loadRoomDetails(id) {
    log('loadRoomDetails', id);
    const res = await fetch(`/villa/${id}`);
    bookingData.room = await res.json();
    document.getElementById('selected-room-name').textContent = bookingData.room.name;
    document.getElementById('selected-room-price').textContent =
      `Rp ${formatCurrency(bookingData.room.price)} / night`;
  }

  // ----------------------------------
  // FLATPICKR SETUP
  // ----------------------------------
  function initPickers() {
    log('initPickers');

    const inEl    = document.getElementById('check-in');
    const outEl   = document.getElementById('check-out');
    const errIn   = document.getElementById('check-in-error');
    const errOut  = document.getElementById('check-out-error');
    const errRange= document.getElementById('date-range-error');

    // destroy existing
    if (inPicker)  inPicker.destroy();
    if (outPicker) outPicker.destroy();

    // convert disabledRanges to Flatpickr format: [{ from, to }, ...]
    const fpDisabled = disabledRanges.map(r => ({
      from: r.from,
      to:   r.to
    }));

    // IN picker
    inPicker = flatpickr(inEl, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      disable: fpDisabled,
      onChange: (selectedDates, dateStr) => {
        bookingData.checkIn = dateStr;
        errIn.classList.add('hidden');
        errRange.classList.add('hidden');
        // update outPicker minDate to day after checkIn
        const nextDay = new Date(selectedDates[0].getTime() + 86400000);
        outPicker.set('minDate', nextDay);
        calcNights();
      }
    });

    // OUT picker
    outPicker = flatpickr(outEl, {
      dateFormat: 'Y-m-d',
      minDate: bookingData.checkIn || 'today',
      disable: fpDisabled,
      onChange: (selectedDates, dateStr) => {
        bookingData.checkOut = dateStr;
        errOut.classList.add('hidden');
        const inD  = new Date(bookingData.checkIn),
              outD = new Date(bookingData.checkOut);
        if (outD <= inD) {
          errRange.classList.remove('hidden');
        } else {
          errRange.classList.add('hidden');
        }
        calcNights();
      }
    });
  }

  // ----------------------------------
  // LOAD RESERVED DATES
  // ----------------------------------
  async function loadReservedDates(villaId) {
    log('loadReservedDates', villaId);
    try {
      const res = await fetch(`/villa/${villaId}/reserved-dates`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      disabledRanges = Array.isArray(data)
        ? data.map(r => ({ from: r.from, to: r.to }))
        : [];
    } catch (e) {
      console.warn('Failed to load reserved-dates', e);
      disabledRanges = [];
    }
    log('→ disabledRanges', disabledRanges);
  }

  // ----------------------------------
  // VALIDATION
  // ----------------------------------
  function validateStep(step) {
    log('validateStep', step);
    let ok = true;
    if (step === 1) {
      if (!bookingData.checkIn) {
        document.getElementById('check-in-error').classList.remove('hidden');
        ok = false;
      }
      if (!bookingData.checkOut) {
        document.getElementById('check-out-error').classList.remove('hidden');
        ok = false;
      }
      if (new Date(bookingData.checkOut) <= new Date(bookingData.checkIn)) {
        document.getElementById('date-range-error').classList.remove('hidden');
        ok = false;
      }
      bookingData.adults   = +document.getElementById('adults').value;
      bookingData.children = +document.getElementById('children').value;
    }
    // TODO: validation for guest info & payment steps
    return ok;
  }

  // ----------------------------------
  // MIDTRANS PAYMENT
  // ----------------------------------
  async function payWithMidtrans() {
    log('payWithMidtrans');
    const payload = {
      villa_id:     bookingData.roomId,
      check_in:     bookingData.checkIn,
      check_out:    bookingData.checkOut,
      adults:       bookingData.adults,
      children:     bookingData.children,
      total_amount: Math.round(bookingData.room.price * bookingData.nights * 1.1),
      guest_name:   bookingData.guestName,
      guest_email:  bookingData.guestEmail,
      guest_phone:  bookingData.guestPhone,
    };
    try {
      const res = await fetch('/api/payment/token', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
      });
      const { snap_token } = await res.json();
      window.snap.pay(snap_token, {
        onSuccess: r  => { log('success', r); goToStep(5); },
        onPending: r  => { log('pending', r); goToStep(5); },
        onError:   e  => { log('error', e); alert('Pembayaran gagal'); },
        onClose:      () => log('closed')
      });
    } catch (e) {
      console.error(e);
      alert('Error saat menghubungi server pembayaran.');
    }
  }

  // ----------------------------------
  // INITIALIZATION
  // ----------------------------------
  document.addEventListener('DOMContentLoaded', () => {
    // STATIC TEST: disable 9–23 bulan ini
    const today = new Date();
    const yyyy  = today.getFullYear();
    const mm    = String(today.getMonth() + 1).padStart(2, '0');
    disabledRanges = [{ from: `${yyyy}-${mm}-09`, to: `${yyyy}-${mm}-23` }];

    // init pickers now that disabledRanges is set
    initPickers();

    // Mobile menu
    document.getElementById('mobile-menu-button').onclick = () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    };
    // Scroll animations
    document.querySelectorAll('.animate-hidden').forEach(el => {
      new IntersectionObserver(([e]) => {
        if (e.isIntersecting) el.classList.add('animate-visible');
      }, { threshold: 0.1 }).observe(el);
    });
    // Header shrink
    window.addEventListener('scroll', () => {
      const hdr = document.getElementById('header');
      hdr.classList.toggle('py-2', window.scrollY > 50);
      hdr.classList.toggle('py-4', window.scrollY <= 50);
    });

    // Book Now
    document.querySelectorAll('.book-now-btn').forEach(btn => {
      btn.addEventListener('click', async e => {
        e.preventDefault();
        bookingData.roomId = btn.dataset.roomId;
        await loadRoomDetails(bookingData.roomId);
        await loadReservedDates(bookingData.roomId);
        initPickers();
        openModal();
      });
    });

    // Hero & CTA buttons open same modal
    ['hero-book-btn','cta-book-btn'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('click', () =>
        document.querySelector('.book-now-btn').click()
      );
    });

    // Modal controls
    document.getElementById('close-modal').onclick    = closeModal;
    document.getElementById('modal-backdrop').onclick = closeModal;
    document.getElementById('change-room-btn').onclick = e => {
      e.preventDefault();
      closeModal();
      document.getElementById('rooms').scrollIntoView({ behavior: 'smooth' });
    };

    // Stepper nav
    document.getElementById('next-step').onclick = () => {
      if (currentStep < totalSteps) {
        if (currentStep === 4) {
          if (validateStep(4)) payWithMidtrans();
        } else {
          if (validateStep(currentStep)) goToStep(currentStep + 1);
        }
      } else {
        closeModal();
      }
    };
    document.getElementById('prev-step').onclick = () => {
      if (currentStep > 1) goToStep(currentStep - 1);
    };
  });
