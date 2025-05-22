// public/js/general.js

// ----------------------------------
// STATE
// ----------------------------------
const bookingData = {
    roomId: null,
    room: null,
    checkIn: '',
    checkOut: '',
    nights: 0,
    guestName: '',
    guestEmail: '',
    guestAddress: '',
    totalAmount: '',
    guestPhone: '',
    paymentMethod: 'midtrans',
  };

  let currentStep = 1;
  const totalSteps = 5;
  let inPicker = null, outPicker = null, disabledRanges = [];

  // ----------------------------------
  // HELPERS
  // ----------------------------------
  /**
   * Memformat tanggal ke format ISO (YYYY-MM-DD)
   * @param {Date} d - Objek Date yang akan diformat
   * @returns {string} Tanggal dalam format ISO
   */
  function formatDateISO(d) {
    return d.toISOString().slice(0, 10);
  }

  /**
   * Menghitung jumlah malam dari tanggal check-in dan check-out
   * dan menyimpannya ke state bookingData
   */
  function calcNights() {
    const a = new Date(bookingData.checkIn);
    const b = new Date(bookingData.checkOut);
    const diff = (b - a) / (1000 * 60 * 60 * 24);
    bookingData.nights = diff > 0 ? diff : 1;
  }

  /**
   * Memformat angka menjadi format mata uang Indonesia
   * @param {number} v - Nilai yang akan diformat
   * @returns {string} Nilai yang sudah diformat
   */
  function formatCurrency(v) {
    return new Intl.NumberFormat('id-ID').format(v);
  }

  /**
   * Memuat informasi tamu dari server berdasarkan ID tamu
   * dan mengisi form dengan data tersebut
   */
  async function loadGuestInfo() {
    if (!window.guestId) return;
    try {
      const res = await fetch(`/guestbyID/${window.guestId}`);
      if (!res.ok) throw new Error(res.status);
      const g = await res.json();
      // simpan ke state
      bookingData.guestName = g.full_name;
      bookingData.guestEmail = g.email;
      bookingData.guestAddress = g.address;
      bookingData.guestPhone = g.phone_number;
      // isi input
      document.getElementById('guest-name').value = g.full_name;
      document.getElementById('guest-email').value = g.email;
      document.getElementById('guest-address').value = g.address;
      document.getElementById('guest-phone').value = g.phone_number;
      // kalau ada country field, isi juga
    } catch (e) {
      // Error handling tanpa console.warn
    }
  }

  // ----------------------------------
  // STEP NAVIGATION
  // ----------------------------------
  /**
   * Berpindah ke langkah tertentu dalam proses booking
   * @param {number} step - Nomor langkah yang dituju
   */
  function goToStep(step) {
    document.getElementById(`step-${currentStep}`).classList.add('hidden');
    document.getElementById(`step-${step}`).classList.remove('hidden');
    const pct = ((step - 1) / (totalSteps - 1)) * 100;
    document.getElementById('progress-bar').style.width = pct + '%';
    currentStep = step;
    document.getElementById('prev-step').classList.toggle('hidden', step === 1 || step === 5);
    const nxt = document.getElementById('next-step');
    nxt.innerHTML = step === totalSteps
      ? `<div class="flex items-center"><span>Finish</span><i class="fas fa-check ml-2"></i></div>`
      : `<div class="flex items-center"><span>Next</span><i class="fas fa-arrow-right ml-2"></i></div>`;

    // ← Tambahan: render Step 2 saat pindah ke step 2
    if (step === 2) renderStep2();
    if (step === 3) {
      renderStep3();
    }
    if (step === 4) renderStep4();
  }

  /**
   * Mengatur ulang stepper ke langkah pertama
   */
  function resetStepper() {
    goToStep(1);
  }

  // ----------------------------------
  // MODAL CONTROL
  // ----------------------------------
  /**
   * Membuka modal booking dengan animasi
   */
  function openModal() {
    document.getElementById('booking-stepper-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() =>
      document.getElementById('modal-content').classList.replace('opacity-0', 'opacity-100'),
    10);
    resetStepper();
  }

  /**
   * Menutup modal booking dengan animasi
   */
  function closeModal() {
    document.getElementById('modal-content').classList.replace('opacity-100', 'opacity-0');
    setTimeout(() => {
      document.getElementById('booking-stepper-modal').classList.add('hidden');
      document.body.style.overflow = '';
      // reset everything setelah modal benar‑benar tersembunyi
      resetModalState();
    }, 300);
  }

  // ----------------------------------
  // ROOM DATA & UI
  // ----------------------------------
  /**
   * Memuat detail kamar/villa dari server dan menampilkannya di UI
   * @param {string|number} id - ID kamar/villa yang akan dimuat
   */
  async function loadRoomDetails(id) {
    const res = await fetch(`/villa/${id}`);
    bookingData.room = await res.json();
    document.getElementById('selected-room-name').textContent = bookingData.room.name;

  }

  // ----------------------------------
  // FLATPICKR SETUP
  // ----------------------------------
  /**
   * Menginisialisasi date picker untuk check-in dan check-out
   * dengan tanggal yang tidak tersedia (sudah dipesan)
   */
  function initPickers() {
    const inEl = document.getElementById('check-in');
    const outEl = document.getElementById('check-out');
    const errIn = document.getElementById('check-in-error');
    const errOut = document.getElementById('check-out-error');
    const errRange = document.getElementById('date-range-error');

    // destroy existing
    if (inPicker) inPicker.destroy();
    if (outPicker) outPicker.destroy();

    // convert disabledRanges to Flatpickr format: [{ from, to }, ...]
    const fpDisabled = disabledRanges.map(r => ({
      from: r.from,
      to: r.to
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

        // hitung jumlah malam
        calcNights();

        // ─── real-time price calculation ───
        // jika checkOut sudah diisi dan valid, langsung hitung biaya
        if (bookingData.checkIn && bookingData.checkOut) {
        const inDate  = new Date(bookingData.checkIn);
        const outDate = new Date(bookingData.checkOut);
        if (outDate > inDate) {
            calculateCost();
        }
        }
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
        const inD = new Date(bookingData.checkIn),
          outD = new Date(bookingData.checkOut);
        if (outD <= inD) {
          errRange.classList.remove('hidden');
        } else {
          errRange.classList.add('hidden');
        }
        calcNights();
        // ─── real‑time price calculation ───
        if (bookingData.checkIn && bookingData.checkOut && outD > inD) {
          calculateCost();
        }
      }
    });
  }

  // ----------------------------------
  // LOAD RESERVED DATES
  // ----------------------------------
  /**
   * Memuat tanggal-tanggal yang sudah dipesan untuk villa tertentu
   * @param {string|number} villaId - ID villa yang akan dicek tanggal pesanannya
   */
  async function loadReservedDates(villaId) {
    try {
      const res = await fetch(`/villa/${villaId}/reserved-dates`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      disabledRanges = Array.isArray(data)
        ? data.map(r => ({ from: r.from, to: r.to }))
        : [];
    } catch (e) {
      // Error handling tanpa console.warn
      disabledRanges = [];
    }
  }

  // ----------------------------------
  // REAL‑TIME PRICE CALCULATION
  // ----------------------------------
  /**
   * Menghitung total biaya pemesanan berdasarkan tanggal check-in dan check-out
   */
  async function calculateCost() {
    const statusEl = document.getElementById('calc-status');
    const wrapEl = document.getElementById('calc-total');
    const amtEl = document.getElementById('calc-amount');

    statusEl.textContent = 'Calculating price…';
    wrapEl.classList.add('hidden');

    try {
      const res = await fetch(
        `/villa/${bookingData.roomId}/calculate?start=${bookingData.checkIn}&end=${bookingData.checkOut}`
      );
      if (!res.ok) throw new Error(res.status);
      const { total } = await res.json();
      bookingData.totalAmount = total;
      amtEl.textContent = 'Rp ' + formatCurrency(total);
      statusEl.textContent = '';
      wrapEl.classList.remove('hidden');
    } catch (err) {
      // Error handling tanpa console.error
      statusEl.textContent = 'Failed to calculate price.';
    }
  }

  // ----------------------------------
  // VALIDATION
  // ----------------------------------
  /**
   * Memvalidasi input pada langkah tertentu
   * @param {number} step - Nomor langkah yang akan divalidasi
   * @returns {boolean} Hasil validasi (true jika valid)
   */
  function validateStep(step) {
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
    }
    return ok;
  }

/**
 * Menampilkan detail kamar dan ringkasan pemesanan pada langkah 2
 * — sekarang sudah pakai totalAmount yang dihitung oleh calculateCost()
 */
async function renderStep2() {
  // Room Details
  document.getElementById('room-detail-name').textContent = bookingData.room.name;
  document.getElementById('room-description').textContent = bookingData.room.description;
  document.getElementById('room-capacity').textContent = `Up to ${bookingData.room.capacity} people`;
  document.getElementById('room-image').src = bookingData.room.picture;

  // Booking Summary — Stay Details
  document.getElementById('summary-checkin').textContent = bookingData.checkIn;
  document.getElementById('summary-checkout').textContent = bookingData.checkOut;
  document.getElementById('summary-nights').textContent = bookingData.nights;

  // — jika totalAmount belum dihitung, panggil calculateCost()
  if (!bookingData.totalAmount) {
    await calculateCost();
  }

  // Booking Summary — Price Details
  const roomTotal = bookingData.totalAmount;
  // tampilkan label yang sesuai
  document.getElementById('room-rate-label').textContent =
    `Total Rate for ${bookingData.nights} night${bookingData.nights > 1 ? 's' : ''}:`;
  document.getElementById('room-rate-total').textContent =
    'Rp ' + formatCurrency(roomTotal);

  // jika kamu juga punya summary‐total terpisah
  document.getElementById('summary-total').textContent =
    'Rp ' + formatCurrency(roomTotal);
}

  /**
   * Memuat informasi tamu saat masuk ke langkah 3
   */
  function renderStep3() {
    // saat pindah ke step 3, loadGuestInfo dan simpan state
    loadGuestInfo();
  }

  /**
   * Menampilkan ringkasan pembayaran pada langkah 4
   */
  function renderStep4() {
    // fill summary
    document.getElementById('payment-villa-name').textContent = bookingData.room.name;
    document.getElementById('payment-checkin').textContent = bookingData.checkIn;
    document.getElementById('payment-checkout').textContent = bookingData.checkOut;
    document.getElementById('payment-nights').textContent = bookingData.nights + ' nights';
    document.getElementById('payment-nights-label').textContent = bookingData.nights + ' nights';

    // total was calculated in calculateCost() and stored:
    const total = bookingData.totalAmount || (bookingData.room.price * bookingData.nights);
    document.getElementById('payment-room-rate').textContent = 'Rp ' + formatCurrency(total);
    document.getElementById('payment-total').textContent = 'Rp ' + formatCurrency(total);
  }

  // ----------------------------------
  // RESET MODAL STATE
  // ----------------------------------
  /**
   * Mengatur ulang semua state dan UI modal ke kondisi awal
   */
  function resetModalState() {
    // 1) Reset bookingData
    Object.assign(bookingData, {
      roomId: null, room: null,
      checkIn: '', checkOut: '', nights: 0,
      guestName: '', guestEmail: '', guestPhone: '',
      guestCountry: '', specialRequests: '',
      paymentMethod: 'credit',
      cardName: '', cardNumber: '', cardMonth: '', cardYear: '', cardCVV: ''
    });

    // 2) Clear all inputs in modal
    const fields = [
      'check-in', 'check-out',
      'guest-name', 'guest-email', 'guest-phone', 'guest-country', 'special-requests',
      'card-name', 'card-number', 'card-expiry-month', 'card-expiry-year', 'card-cvv'
    ];
    fields.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        if (el.tagName === 'SELECT' || el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
          el.value = '';
        }
      }
    });

    // 3) Destroy pickers and clear their input
    if (inPicker) { inPicker.destroy(); inPicker = null; }
    if (outPicker) { outPicker.destroy(); outPicker = null; }

    // 4) Reset stepper UI back to step 1
    resetStepper();

    // 5) Hide any validation errors and calculation UI
    document.querySelectorAll('.error-message, #check-in-error, #check-out-error, #date-range-error')
      .forEach(e => e.classList.add('hidden'));

    const calcStatus = document.getElementById('calc-status');
    const calcWrap = document.getElementById('calc-total');
    if (calcStatus) calcStatus.textContent = '';
    if (calcWrap) calcWrap.classList.add('hidden');
  }

  // ----------------------------------
  // INITIALIZATION
  // ----------------------------------
  document.addEventListener('DOMContentLoaded', () => {
    // STATIC TEST: disable 9–23 bulan ini
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
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
        if (!window.guestId) {
          window.location.href = `/login`;
          return;
        }
        bookingData.roomId = btn.dataset.roomId;
        await loadRoomDetails(bookingData.roomId);
        await loadReservedDates(bookingData.roomId);
        initPickers();
        openModal();
      });
    });

    // Hero & CTA buttons open same modal
    ['hero-book-btn', 'cta-book-btn'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('click', () =>
        document.querySelector('.book-now-btn').click()
      );
    });

    // Modal controls
    document.getElementById('close-modal').onclick = closeModal;
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
          payWithMidtrans();
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

    document.getElementById('btn-paynow').addEventListener('click', async function(e) {
      e.preventDefault();

      // siapkan payload
      const payload = {
        villa_id: bookingData.roomId,
        check_in: bookingData.checkIn,
        check_out: bookingData.checkOut,
        total_amount: bookingData.totalAmount,
        guest_name: bookingData.guestName,
        guest_email: bookingData.guestEmail,
        guest_phone: bookingData.guestPhone
      };

      try {
        const res = await fetch('/payment/token', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(payload)
        });

        // kalau bukan 200–299, tangani error
        if (!res.ok) {
          const contentType = res.headers.get('content-type') || '';
          let errMsg;
          if (contentType.includes('application/json')) {
            const err = await res.json();
            errMsg = JSON.stringify(err);
          } else {
            errMsg = await res.text();
          }
          alert('Error saat generate token. Cek console.');
          return;
        }

        // parse JSON
        const { snap_token } = await res.json();

        // panggil Midtrans Snap
        window.snap.pay(snap_token, {
            onSuccess: async r => {
              await pushReservationToApi();
              goToStep(5);
            },
            onPending: async r => {

              goToStep(5);
            },
            onError: e => {
              alert('Payment failed');
            },
            onClose: () => { /* ... */ }
          });

      } catch (e) {
        alert('Gagal menghubungi server. Cek koneksi atau console.');
      }
    });
  });

  async function payWithMidtrans() {
    document.getElementById('btn-paynow').click();
  }



  /**
 * Mengirim data reservasi ke API internal setelah pembayaran sukses/pending
 *
 * @async
 * @function pushReservationToApi
 * @returns {Promise<void>} Tidak mengembalikan apa pun; hanya log status
 */
async function pushReservationToApi() {
    const payload = {
      villa_id: bookingData.roomId,
      start_date: bookingData.checkIn,
      end_date: bookingData.checkOut,
      total_amount: bookingData.totalAmount,
      guest_id: window.guestId,
      cek_ketersediaan_id: null,
      villa_pricing_id: null
    };

    try {
      const res = await fetch('/reservation/store', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-API-TOKEN': window.apiToken,
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
      });

      if (!res.ok) {
        // console.error('❌ Gagal push ke API:', await res.text());
      } else {
        // console.log('✅ Reservasi berhasil dikirim ke API');
      }

    } catch (err) {
    //   console.error('❌ Error saat push reservasi ke API:', err);
    }
  }
