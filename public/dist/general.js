// General functionality
document.addEventListener("DOMContentLoaded", () => {
  // Global variables
  window.disabledRanges = []
  window.flatpickr = window.flatpickr || {} // Declare flatpickr variable

  // Booking data
  const bookingData = {
    roomId: null,
    room: null,
    checkIn: "",
    checkOut: "",
    nights: 0,
    totalAmount: 0,
    guestUsername: "",
    guestFullName: "",
    guestEmail: "",
    guestAddress: "",
    guestPhone: "",
    guestIdCard: "",
    guestPassport: "",
    guestBirthdate: "",
    guestGender: "",
    paymentMethod: "midtrans",
  }

  let inPicker = null
  let outPicker = null

  // Helper functions
  function formatCurrency(amount) {
    return new Intl.NumberFormat("id-ID").format(amount)
  }

  function calcNights() {
    if (bookingData.checkIn && bookingData.checkOut) {
      const inDate = new Date(bookingData.checkIn)
      const outDate = new Date(bookingData.checkOut)
      const diff = (outDate - inDate) / (1000 * 60 * 60 * 24)
      bookingData.nights = diff > 0 ? diff : 1
    }
  }

  // Load guest info
  async function loadGuestInfo() {
    if (!window.guestId) return

    try {
      const res = await fetch(`/guestbyID/${window.guestId}`)
      if (!res.ok) throw new Error(res.status)

      const guest = await res.json()

      // Update booking data
      bookingData.guestUsername = guest.username || ""
      bookingData.guestFullName = guest.full_name || ""
      bookingData.guestEmail = guest.email || ""
      bookingData.guestAddress = guest.address || ""
      bookingData.guestPhone = guest.phone_number || ""
      bookingData.guestIdCard = guest.id_card_number || ""
      bookingData.guestPassport = guest.passport_number || ""
      bookingData.guestBirthdate = guest.birthdate || ""
      bookingData.guestGender = guest.gender || ""

      // Update form fields in booking modal
      const fields = {
        "guest-username": guest.username,
        "guest-name": guest.full_name,
        "guest-email": guest.email,
        "guest-address": guest.address,
        "guest-phone": guest.phone_number,
        "guest-id-card": guest.id_card_number,
        "guest-passport": guest.passport_number,
        "guest-birthdate": guest.birthdate,
        "guest-gender": guest.gender,
      }

      Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id)
        if (el) el.value = value || ""
      })
    } catch (error) {
      console.warn("Failed to load guest info:", error)
    }
  }

  // Save guest profile
  async function saveGuestProfileViaAPI() {
    if (!window.guestId) {
      alert("Anda belum login sebagai guest.")
      return false
    }

    const payload = {
      username: document.getElementById("guest-username").value.trim(),
      full_name: document.getElementById("guest-name").value.trim(),
      email: document.getElementById("guest-email").value.trim(),
      phone_number: document.getElementById("guest-phone").value.trim(),
      address: document.getElementById("guest-address").value.trim(),
      id_card_number: document.getElementById("guest-id-card").value.trim(),
      passport_number: document.getElementById("guest-passport").value.trim(),
      birthdate: document.getElementById("guest-birthdate").value,
      gender: document.getElementById("guest-gender").value,
    }

    try {
      const res = await fetch("/api/guest/profile", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      })

      if (res.status === 422) {
        const data = await res.json()
        console.error("Validation errors:", data.errors)
        alert("Validasi gagal. Cek console untuk detail.")
        return false
      }

      if (!res.ok) {
        const txt = await res.text()
        throw new Error(`Error: HTTP ${res.status} → ${txt}`)
      }

      const json = await res.json()

      // Update bookingData with new values
      Object.assign(bookingData, {
        guestUsername: json.guest.username,
        guestFullName: json.guest.full_name,
        guestEmail: json.guest.email,
        guestPhone: json.guest.phone_number,
        guestAddress: json.guest.address,
        guestIdCard: json.guest.id_card_number,
        guestPassport: json.guest.passport_number,
        guestBirthdate: json.guest.birthdate,
        guestGender: json.guest.gender,
      })

      return true
    } catch (err) {
      console.error("[saveGuestProfileViaAPI] Error:", err)
      alert("Gagal menghubungi server: " + err.message)
      return false
    }
  }

  // Modal control functions
  window.openModal = () => {
    const modal = document.getElementById("booking-stepper-modal")
    const content = document.getElementById("modal-content")

    if (modal && content) {
      modal.classList.remove("hidden")
      document.body.style.overflow = "hidden"
      setTimeout(() => {
        content.classList.remove("opacity-0", "scale-95")
        content.classList.add("opacity-100", "scale-100")
      }, 10)
      window.resetStepper()
    }
  }

  window.closeModal = () => {
    const modal = document.getElementById("booking-stepper-modal")
    const content = document.getElementById("modal-content")

    if (modal && content) {
      content.classList.remove("opacity-100", "scale-100")
      content.classList.add("opacity-0", "scale-95")
      setTimeout(() => {
        modal.classList.add("hidden")
        document.body.style.overflow = ""
        resetModalState()
      }, 300)
    }
  }

  // Load room details
  window.loadRoomDetails = async (id) => {
    try {
      const res = await fetch(`/villa/${id}`)
      if (!res.ok) throw new Error("Failed to load room details")

      bookingData.room = await res.json()
      bookingData.roomId = id

      const nameEl = document.getElementById("selected-room-name")
      if (nameEl) nameEl.textContent = bookingData.room.name
    } catch (error) {
      console.error("Error loading room details:", error)
    }
  }

  // Load reserved dates
  window.loadReservedDates = async (villaId) => {
    try {
      const res = await fetch(`/villa/${villaId}/reserved-dates`)
      if (!res.ok) throw new Error(`HTTP ${res.status}`)

      const data = await res.json()
      window.disabledRanges = Array.isArray(data) ? data.map((r) => ({ from: r.from, to: r.to })) : []
    } catch (e) {
      console.warn("Failed to load reserved dates:", e)
      window.disabledRanges = []
    }
  }

  // Initialize date pickers
  function initPickers() {
    const inEl = document.getElementById("check-in")
    const outEl = document.getElementById("check-out")

    if (!inEl || !outEl) return

    // Destroy existing pickers
    if (inPicker) inPicker.destroy()
    if (outPicker) outPicker.destroy()

    // Convert disabled ranges
    const fpDisabled = window.disabledRanges.map((r) => ({
      from: r.from,
      to: r.to,
    }))

    // Check-in picker
    inPicker = window.flatpickr(inEl, {
      dateFormat: "Y-m-d",
      minDate: "today",
      disable: fpDisabled,
      onChange: (selectedDates, dateStr) => {
        bookingData.checkIn = dateStr
        const errorEl = document.getElementById("check-in-error")
        if (errorEl) errorEl.classList.add("hidden")

        if (selectedDates[0]) {
          const nextDay = new Date(selectedDates[0].getTime() + 86400000)
          if (outPicker) outPicker.set("minDate", nextDay)
        }

        calcNights()

        if (bookingData.checkIn && bookingData.checkOut) {
          const inDate = new Date(bookingData.checkIn)
          const outDate = new Date(bookingData.checkOut)
          if (outDate > inDate) {
            calculateCost()
          }
        }
      },
    })

    // Check-out picker
    outPicker = window.flatpickr(outEl, {
      dateFormat: "Y-m-d",
      minDate: bookingData.checkIn || "today",
      disable: fpDisabled,
      onChange: (selectedDates, dateStr) => {
        bookingData.checkOut = dateStr
        const errorEl = document.getElementById("check-out-error")
        if (errorEl) errorEl.classList.add("hidden")

        const inDate = new Date(bookingData.checkIn)
        const outDate = new Date(bookingData.checkOut)

        if (outDate <= inDate) {
          const rangeError = document.getElementById("date-range-error")
          if (rangeError) rangeError.classList.remove("hidden")
        } else {
          const rangeError = document.getElementById("date-range-error")
          if (rangeError) rangeError.classList.add("hidden")
        }

        calcNights()

        if (bookingData.checkIn && bookingData.checkOut && outDate > inDate) {
          calculateCost()
        }
      },
    })
  }

  // Calculate cost
  async function calculateCost() {
    const statusEl = document.getElementById("calc-status")
    const wrapEl = document.getElementById("calc-total")
    const amtEl = document.getElementById("calc-amount")

    if (!statusEl || !wrapEl || !amtEl) return

    statusEl.textContent = "Calculating price…"
    wrapEl.classList.add("hidden")

    try {
      const res = await fetch(
        `/villa/${bookingData.roomId}/calculate?start=${bookingData.checkIn}&end=${bookingData.checkOut}`,
      )
      if (!res.ok) throw new Error(res.status)

      const { total } = await res.json()
      bookingData.totalAmount = total
      amtEl.textContent = "Rp " + formatCurrency(total)
      statusEl.textContent = ""
      wrapEl.classList.remove("hidden")
    } catch (err) {
      statusEl.textContent = "Failed to calculate price."
    }
  }

  // Render step functions
  window.renderStep2 = async () => {
    if (!bookingData.room) return

    // Room Details
    const elements = {
      "room-detail-name": bookingData.room.name,
      "room-description": bookingData.room.description,
      "room-capacity": `Up to ${bookingData.room.capacity} people`,
    }

    Object.entries(elements).forEach(([id, value]) => {
      const el = document.getElementById(id)
      if (el) el.textContent = value
    })

    const imgEl = document.getElementById("room-image")
    if (imgEl) imgEl.src = bookingData.room.picture

    // Booking Summary
    const summaryElements = {
      "summary-checkin": bookingData.checkIn,
      "summary-checkout": bookingData.checkOut,
      "summary-nights": bookingData.nights,
    }

    Object.entries(summaryElements).forEach(([id, value]) => {
      const el = document.getElementById(id)
      if (el) el.textContent = value
    })

    if (!bookingData.totalAmount) {
      await calculateCost()
    }

    const roomTotal = bookingData.totalAmount
    const rateLabel = document.getElementById("room-rate-label")
    const rateTotal = document.getElementById("room-rate-total")
    const summaryTotal = document.getElementById("summary-total")

    if (rateLabel) {
      rateLabel.textContent = `Total Rate for ${bookingData.nights} night${bookingData.nights > 1 ? "s" : ""}:`
    }
    if (rateTotal) rateTotal.textContent = "Rp " + formatCurrency(roomTotal)
    if (summaryTotal) summaryTotal.textContent = "Rp " + formatCurrency(roomTotal)

    if (bookingData.room && bookingData.room.facility_names) {
      if (window.renderRoomFacilities) {
        window.renderRoomFacilities(bookingData.room.facility_names, 'room-facilities');
        window.renderRoomFacilities(bookingData.room.facility_names, 'summary-facilities');
      }
    }
  }

  window.renderStep3 = () => {
    loadGuestInfo()
  }

  window.renderStep4 = () => {
    if (!bookingData.room) return

    const elements = {
      "payment-villa-name": bookingData.room.name,
      "payment-checkin": bookingData.checkIn,
      "payment-checkout": bookingData.checkOut,
      "payment-nights": bookingData.nights + " nights",
      "payment-nights-label": `Room Rate (${bookingData.nights} nights):`,
    }

    Object.entries(elements).forEach(([id, value]) => {
      const el = document.getElementById(id)
      if (el) el.textContent = value
    })

    const total = bookingData.totalAmount || bookingData.room.price * bookingData.nights
    const rateEl = document.getElementById("payment-room-rate")
    const totalEl = document.getElementById("payment-total")

    if (rateEl) rateEl.textContent = "Rp " + formatCurrency(total)
    if (totalEl) totalEl.textContent = "Rp " + formatCurrency(total)
  }

  // Reset modal state
  function resetModalState() {
    // Reset bookingData
    Object.assign(bookingData, {
      roomId: null,
      room: null,
      checkIn: "",
      checkOut: "",
      nights: 0,
      totalAmount: 0,
      guestFullName: "",
      guestEmail: "",
      guestPhone: "",
      paymentMethod: "midtrans",
    })

    // Clear inputs
    const fields = [
      "check-in",
      "check-out",
      "guest-name",
      "guest-email",
      "guest-phone",
      "guest-address",
      "guest-id-card",
      "guest-passport",
      "guest-birthdate",
      "guest-gender",
    ]

    fields.forEach((id) => {
      const el = document.getElementById(id)
      if (el && (el.tagName === "SELECT" || el.tagName === "INPUT" || el.tagName === "TEXTAREA")) {
        el.value = ""
      }
    })

    // Destroy pickers
    if (inPicker) {
      inPicker.destroy()
      inPicker = null
    }
    if (outPicker) {
      outPicker.destroy()
      outPicker = null
    }

    // Hide errors
    document
      .querySelectorAll(".error-message, #check-in-error, #check-out-error, #date-range-error")
      .forEach((e) => e.classList.add("hidden"))

    const calcStatus = document.getElementById("calc-status")
    const calcWrap = document.getElementById("calc-total")
    if (calcStatus) calcStatus.textContent = ""
    if (calcWrap) calcWrap.classList.add("hidden")
  }

  // Push reservation to API
  async function pushReservationToApi() {
    const payload = {
      villa_id: bookingData.roomId,
      start_date: bookingData.checkIn,
      end_date: bookingData.checkOut,
      total_amount: bookingData.totalAmount,
      guest_id: window.guestId,
    }

    try {
      const res = await fetch("/reservation/store", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-API-TOKEN": window.apiToken,
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify(payload),
      })

      if (!res.ok) {
        console.error("❌ Gagal push ke API:", await res.text())
        return false;
      } else {
        const data = await res.json();
        console.log("✅ Reservasi berhasil dikirim ke API", data);

        // Simpan ID reservasi ke sessionStorage untuk digunakan saat update status pembayaran
        if (data && data.data && data.data.reservasi && data.data.reservasi.id_reservation) {
          const reservationId = data.data.reservasi.id_reservation;
          sessionStorage.setItem('current_reservation_id', reservationId);
          console.log("✅ ID Reservasi disimpan ke sessionStorage:", reservationId);
        }

        return true;
      }
    } catch (err) {
      console.error("❌ Error saat push reservasi ke API:", err)
      return false;
    }
  }

  // Initialize everything
  initPickers()

  // Mobile menu
  const mobileMenuBtn = document.getElementById("mobile-menu-button")
  const mobileMenu = document.getElementById("mobile-menu")
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.onclick = () => mobileMenu.classList.toggle("hidden")
  }

  // Scroll animations
  document.querySelectorAll(".animate-hidden").forEach((el) => {
    new IntersectionObserver(
      ([e]) => {
        if (e.isIntersecting) el.classList.add("animate-visible")
      },
      { threshold: 0.1 },
    ).observe(el)
  })

  // Header shrink
  window.addEventListener("scroll", () => {
    const hdr = document.getElementById("header")
    if (hdr) {
      hdr.classList.toggle("py-2", window.scrollY > 50)
      hdr.classList.toggle("py-4", window.scrollY <= 50)
    }
  })

  // Book Now buttons
  document
    .querySelectorAll(".book-now-btn")
    .forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        e.preventDefault()
        if (!window.guestId) {
          window.location.href = "/login"
          return
        }
        bookingData.roomId = btn.dataset.roomId
        await window.loadRoomDetails(bookingData.roomId)
        await window.loadReservedDates(bookingData.roomId)
        initPickers()
        window.openModal()
      })
    })

  // Hero & CTA buttons
  ;["hero-book-btn", "cta-book-btn"].forEach((id) => {
    const el = document.getElementById(id)
    const firstBookBtn = document.querySelector(".book-now-btn")
    if (el && firstBookBtn) {
      el.addEventListener("click", () => firstBookBtn.click())
    }
  })

  // Modal controls
  const closeBtn = document.getElementById("close-modal")
  const backdrop = document.getElementById("modal-backdrop")
  const changeRoomBtn = document.getElementById("change-room-btn")

  if (closeBtn) closeBtn.onclick = window.closeModal
  if (backdrop) backdrop.onclick = window.closeModal
  if (changeRoomBtn) {
    changeRoomBtn.onclick = (e) => {
      e.preventDefault()
      window.closeModal()
      const roomsSection = document.getElementById("rooms")
      if (roomsSection) roomsSection.scrollIntoView({ behavior: "smooth" })
    }
  }

  // Stepper navigation
  const nextBtn = document.getElementById("next-step")
  const prevBtn = document.getElementById("prev-step")

  if (nextBtn) {
    nextBtn.onclick = async () => {
      if (window.currentStep < 5) {
        if (window.currentStep === 3) {
          if (!window.validateStep(3)) return
          try {
            const ok = await saveGuestProfileViaAPI()
            if (!ok) return

            // Simpan data reservasi setelah profil guest berhasil disimpan
            try {
              await pushReservationToApi()
              console.log("✅ Reservasi berhasil dikirim ke API pada step 3")
            } catch (err) {
              console.error("❌ Error saat push reservasi ke API pada step 3:", err)
              alert("Gagal menyimpan data reservasi. Silakan coba lagi.")
              return
            }
          } catch (e) {
            alert(e.message)
            return
          }
          window.goToStep(4)
          return
        }

        if (window.currentStep === 4) {
          // Trigger payment
          const payBtn = document.getElementById("btn-paynow")
          if (payBtn) payBtn.click()
          return
        }

        if (window.validateStep(window.currentStep)) {
          window.goToStep(window.currentStep + 1)
        }
      } else {
        window.closeModal()
      }
    }
  }

  if (prevBtn) {
    prevBtn.onclick = () => {
      if (window.currentStep > 1) window.goToStep(window.currentStep - 1)
    }
  }

  // Payment button
  const btnPaynow = document.getElementById("btn-paynow")
  if (btnPaynow) {
    btnPaynow.addEventListener("click", async (e) => {
      e.preventDefault()

      // Tampilkan loading spinner
      btnPaynow.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
      btnPaynow.disabled = true;

      try {
        // Ambil token pembayaran (reservasi sudah dibuat di step 3)
        const payload = {
          villa_id: bookingData.roomId,
          check_in: bookingData.checkIn,
          check_out: bookingData.checkOut,
          total_amount: bookingData.totalAmount,
          guest_name: bookingData.guestFullName,
          guest_email: bookingData.guestEmail,
          guest_phone: bookingData.guestPhone,
        }

        const res = await fetch("/payment/token", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
          body: JSON.stringify(payload),
        })

        if (!res.ok) {
          const contentType = res.headers.get("content-type") || ""
          let errMsg
          if (contentType.includes("application/json")) {
            const err = await res.json()
            errMsg = JSON.stringify(err)
          } else {
            errMsg = await res.text()
          }
          alert("Error saat generate token. Cek console.")
          console.error("Payment token error:", errMsg)

          // Kembalikan tombol ke keadaan semula
          btnPaynow.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Pay Now';
          btnPaynow.disabled = false;
          return
        }

        const { snap_token } = await res.json()

        if (window.snap) {
          window.snap.pay(snap_token, {
            onSuccess: async (r) => {
              console.log('Payment successful:', r);
              // Update status pembayaran menjadi success
              await updatePaymentStatus('success', r);
              // Reservasi sudah dibuat, hanya perlu update status
              window.goToStep(5)
            },
            onPending: async (r) => {
              console.log('Payment pending:', r);
              // Update status pembayaran menjadi pending
              await updatePaymentStatus('pending', r);
              window.goToStep(5)
            },
            onError: (e) => {
              alert("Payment failed")
              // Kembalikan tombol ke keadaan semula
              btnPaynow.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Pay Now';
              btnPaynow.disabled = false;
            },
            onClose: async () => {
              // Payment modal closed
              // Update status pembayaran menjadi pending
              await updatePaymentStatus('pending', { status: 'pending', message: 'Payment popup closed' });
              // Kembalikan tombol ke keadaan semula
              btnPaynow.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Pay Now';
              btnPaynow.disabled = false;
            },
          })
        } else {
          alert("Midtrans Snap not loaded")
          // Kembalikan tombol ke keadaan semula
          btnPaynow.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Pay Now';
          btnPaynow.disabled = false;
        }
      } catch (e) {
        alert("Gagal menghubungi server. Cek koneksi atau console.")
        console.error("Payment error:", e)
        // Kembalikan tombol ke keadaan semula
        btnPaynow.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Pay Now';
        btnPaynow.disabled = false;
      }
    })
  }

  // Function to update payment status
  async function updatePaymentStatus(status, result) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
      // Ambil ID reservasi dari session storage yang disimpan saat membuat reservasi
      // Ini lebih reliable daripada mencoba mengekstrak dari order_id
      const sessionReservationId = sessionStorage.getItem('current_reservation_id');

      // Fallback ke ekstraksi dari order_id jika tidak ada di session
      let reservationId = sessionReservationId;

      if (!reservationId && result?.order_id) {
        console.log('Trying to extract reservation ID from order_id:', result.order_id);

        // Coba ekstrak dari berbagai format
        if (result.order_id.startsWith('ORDER-')) {
          // Format: ORDER-1234567890
          reservationId = result.order_id.replace('ORDER-', '').split('-')[0];
        }
        else if (result.order_id.startsWith('ORDER_')) {
          // Format: ORDER_1234567890
          reservationId = result.order_id.replace('ORDER_', '').split('_')[0];
        }
        else if (result.order_id.startsWith('ORDER-RETRY-')) {
          // Format: ORDER-RETRY-1234567890
          reservationId = result.order_id.replace('ORDER-RETRY-', '').split('-')[0];
        }
        // Jika tidak ada format khusus, gunakan order_id langsung
        else if (!isNaN(result.order_id)) {
          reservationId = result.order_id;
        }
      }

      // Jika masih tidak ada, coba ambil dari transaction_id
      if (!reservationId && result?.transaction_id) {
        reservationId = result.transaction_id;
      }

      if (!reservationId) {
        console.error('Reservation ID not found in transaction result:', result);
        throw new Error('Reservation ID not found');
      }

      console.log(`Updating payment status for reservation ${reservationId} to ${status}`);

      // Send request to update payment status
      const response = await fetch('/api/payment/update-status', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          reservation_id: reservationId,
          status: status,
          transaction_data: result
        })
      });

      if (!response.ok) {
        const errorText = await response.text();
        console.error('Server response error:', errorText);
        throw new Error('Failed to update payment status');
      }

      const data = await response.json();
      console.log('Payment status updated:', data);

      // Verifikasi status yang diperbarui
      if (status === 'success') {
        console.log('Reservation should now be confirmed');
      } else {
        console.log('Reservation remains in pending status');
      }

      return data;
    } catch (error) {
      console.error('Error updating payment status:', error);
      throw error;
    }
  }

  // Expose functions to global scope
  window.bookingData = bookingData
  window.renderRoomFacilities = function(facilityNames = [], targetId = 'room-facilities') {
    console.log('[DEBUG] renderRoomFacilities target:', targetId, 'facilityNames:', facilityNames);
    const container = document.getElementById(targetId);
    if (!container) return;
    container.innerHTML = '';
    if (facilityNames.length === 0) {
        container.innerHTML = '<span class="text-gray-400 text-xs">No facilities listed.</span>';
        return;
    }
    facilityNames.forEach(name => {
        const badge = document.createElement('span');
        badge.className = 'inline-block px-3 py-1 rounded-full bg-elegant-green/10 text-elegant-green font-semibold border border-elegant-green text-xs mb-1';
        badge.textContent = name;
        container.appendChild(badge);
    });
}
})
