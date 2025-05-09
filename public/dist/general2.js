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
  let inPicker, outPicker, disabledRanges = [];

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
    setTimeout(() => {
      document.getElementById('modal-content').classList.replace('opacity-0', 'opacity-100');
    }, 10);
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
  // PICKADAY SETUP
  // ----------------------------------
  function initPickers() {
    log('initPickers');
    const inEl    = document.getElementById('check-in');
    const outEl   = document.getElementById('check-out');
    const errIn   = document.getElementById('check-in-error');
    const errOut  = document.getElementById('check-out-error');
    const errRange= document.getElementById('date-range-error');

    // destroy old
    if (inPicker)  inPicker.destroy();
    if (outPicker) outPicker.destroy();

    // helper: disable if within any reserved range
    function isDisabled(date) {
      return disabledRanges.some(r => {
        const from = new Date(r.from),
              to   = new Date(r.to);
        return date >= from && date <= to;
      });
    }

    // IN datepicker
    inPicker = new Pikaday({
      field: inEl,
      format: 'YYYY-MM-DD',
      minDate: new Date(),
      disableDayFn: isDisabled,
      onSelect: d => {
        bookingData.checkIn = formatDateISO(d);
        errIn.classList.add('hidden');
        errRange.classList.add('hidden');
        // adjust OUT minDate
        const nxt = new Date(d.getTime() + 24*60*60*1000);
        outPicker.setMinDate(nxt);
        calcNights();
      }
    });

    // OUT datepicker
    outPicker = new Pikaday({
      field: outEl,
      format: 'YYYY-MM-DD',
      minDate: bookingData.checkIn ? new Date(bookingData.checkIn) : new Date(),
      disableDayFn: isDisabled,
      onSelect: d => {
        bookingData.checkOut = formatDateISO(d);
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

  async function loadReservedDates(villaId) {
    log('loadReservedDates', villaId);
    try {
      const res = await fetch(`http://127.0.0.1:8000/villa/${villaId}/reserved-dates`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      // ensure it's an array of { from, to }
      disabledRanges = Array.isArray(data)
        ? data.map(r => ({ from: r.from, to: r.to }))
        : [];
    } catch (e) {
      console.warn('Failed to load reserved-dates', e);
      disabledRanges = [];
    }
    console.log('→ applying disabledRanges:', disabledRanges);
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
    // TODO: add validation for guest info & payment steps
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
        onSuccess: res  => { log('success', res); goToStep(5); },
        onPending: res  => { log('pending', res); goToStep(5); },
        onError:   err  => { log('error', err); alert('Pembayaran gagal'); },
        onClose:   ()   => { log('closed'); }
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
    // mobile menu
    document.getElementById('mobile-menu-button').onclick = () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    };
    // scroll animations
    document.querySelectorAll('.animate-hidden').forEach(el => {
      new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) el.classList.add('animate-visible');
      }, { threshold: 0.1 }).observe(el);
    });
    // header shrink on scroll
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
    // Hero/CTA
    ['hero-book-btn','cta-book-btn'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('click', () => {
        document.querySelector('.book-now-btn').click();
      });
    });

    // modal controls
    document.getElementById('close-modal').onclick    = closeModal;
    document.getElementById('modal-backdrop').onclick = closeModal;
    document.getElementById('change-room-btn').onclick = e => {
      e.preventDefault();
      closeModal();
      document.getElementById('rooms').scrollIntoView({ behavior: 'smooth' });
    };

    // stepper nav
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
