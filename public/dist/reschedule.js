// Reschedule functionality - Fixed version for production
;(() => {
  // Reschedule-specific state
  const rescheduleState = {
    reservationId: null,
    originalReservation: null,
    newCheckIn: "",
    newCheckOut: "",
    newNights: 0,
    newTotalAmount: 0,
    paymentNeeded: 0,
    isAdditionalPayment: false,
    isRescheduleMode: false,
    canReschedule: false, // New property for H-7 validation
  }

  let rescheduleInPicker = null
  let rescheduleOutPicker = null

  // Declare variables before using them
  let loadRoomDetails = null
  let loadReservedDates = null
  let goToStep = null
  let flatpickr = null

  /**
   * Format currency helper
   */
  function formatCurrency(amount) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount)
  }

  /**
   * Check if reschedule is allowed (H-7 validation)
   */
  function checkRescheduleEligibility(originalCheckInDate) {
    const today = new Date()
    const checkInDate = new Date(originalCheckInDate)

    // Reset time to start of day for accurate comparison
    today.setHours(0, 0, 0, 0)
    checkInDate.setHours(0, 0, 0, 0)

    // Calculate difference in days
    const diffTime = checkInDate.getTime() - today.getTime()
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

    return {
      canReschedule: diffDays >= 7,
      daysUntilCheckIn: diffDays,
      message:
        diffDays >= 7
          ? `Reschedule diizinkan (${diffDays} hari sebelum check-in)`
          : `Reschedule tidak diizinkan. Hanya dapat dilakukan minimal 7 hari sebelum check-in (sisa ${diffDays} hari)`,
    }
  }

  /**
   * Validate reschedule dates with H-7 rule
   */
  function validateRescheduleDates() {
    const checkInEl = document.getElementById("check-in")
    const checkOutEl = document.getElementById("check-out")
    const checkInError = document.getElementById("check-in-error")
    const checkOutError = document.getElementById("check-out-error")
    const dateRangeError = document.getElementById("date-range-error")

    // Reset/hide error elements
    if (checkInError) checkInError.classList.add("hidden")
    if (checkOutError) checkOutError.classList.add("hidden")
    if (dateRangeError) dateRangeError.classList.add("hidden")

    const checkInValue = checkInEl ? checkInEl.value : ""
    const checkOutValue = checkOutEl ? checkOutEl.value : ""

    let isValid = true

    // Basic validation
    if (!checkInValue) {
      if (checkInError) {
        checkInError.textContent = "Tanggal check-in harus dipilih"
        checkInError.classList.remove("hidden")
      }
      isValid = false
    }

    if (!checkOutValue) {
      if (checkOutError) {
        checkOutError.textContent = "Tanggal check-out harus dipilih"
        checkOutError.classList.remove("hidden")
      }
      isValid = false
    }

    if (checkInValue && checkOutValue) {
      const inDate = new Date(checkInValue)
      const outDate = new Date(checkOutValue)

      if (outDate <= inDate) {
        if (dateRangeError) {
          dateRangeError.textContent = "Tanggal check-out harus setelah check-in"
          dateRangeError.classList.remove("hidden")
        }
        isValid = false
      }

      // H-7 validation for new check-in date
      const eligibility = checkRescheduleEligibility(checkInValue)
      if (!eligibility.canReschedule) {
        if (checkInError) {
          checkInError.textContent = "Reschedule harus dilakukan minimal 7 hari sebelum tanggal check-in yang dipilih"
          checkInError.classList.remove("hidden")
        }
        isValid = false
      }
    }

    // Update state
    rescheduleState.newCheckIn = checkInValue
    rescheduleState.newCheckOut = checkOutValue

    if (checkInValue && checkOutValue && isValid) {
      const inDate = new Date(checkInValue)
      const outDate = new Date(checkOutValue)
      rescheduleState.newNights = Math.ceil((outDate - inDate) / (1000 * 60 * 60 * 24))
    } else {
      rescheduleState.newNights = 0
    }

    return isValid
  }

  /**
   * Open reschedule modal and load reservation data
   */
  async function openRescheduleModal(reservationId) {
    rescheduleState.reservationId = reservationId
    rescheduleState.isRescheduleMode = true

    try {
      // Load reservation details
      const res = await fetch(`/reservation/${reservationId}/reschedule-data`)
      if (!res.ok) throw new Error("Failed to load reservation data")

      rescheduleState.originalReservation = await res.json()

      // Check if reschedule is allowed based on H-7 rule
      const eligibility = checkRescheduleEligibility(rescheduleState.originalReservation.original_start_date)
      rescheduleState.canReschedule = eligibility.canReschedule

      // If reschedule is not allowed, show error and return
      if (!rescheduleState.canReschedule) {
        alert(
          `Reschedule Tidak Diizinkan\n\n${eligibility.message}\n\nReschedule hanya dapat dilakukan minimal 7 hari sebelum tanggal check-in.`,
        )
        return
      }

      // Load villa details and reserved dates
      if (loadRoomDetails) await loadRoomDetails(rescheduleState.originalReservation.villa_id)
      if (loadReservedDates) await loadReservedDates(rescheduleState.originalReservation.villa_id)

      // Open modal at step 1 (date selection)
      document.getElementById("booking-stepper-modal").classList.remove("hidden")
      document.body.style.overflow = "hidden"
      setTimeout(() => {
        document.getElementById("modal-content").classList.replace("opacity-0", "opacity-100")
      }, 10)

      // Set reschedule mode and go to step 1
      setRescheduleMode()
      if (goToStep) goToStep(1)

      // Initialize reschedule pickers after modal is shown
      setTimeout(() => {
        initReschedulePickers()
      }, 500)
    } catch (error) {
      alert("Gagal memuat data reservasi: " + error.message)
    }
  }

  /**
   * Set UI to reschedule mode
   */
  function setRescheduleMode() {
    // Update modal title
    const modalTitle = document.querySelector("#booking-stepper-modal h3")
    if (modalTitle) {
      modalTitle.textContent = "Reschedule Your Booking"
    }

    // Update step 1 title
    const stepTitle = document.querySelector("#step-1 h4")
    if (stepTitle) {
      stepTitle.textContent = "Select New Dates"
    }

    // Show original booking info with H-7 validation status
    const eligibility = checkRescheduleEligibility(rescheduleState.originalReservation.original_start_date)

    const originalInfo = document.createElement("div")
    originalInfo.id = "reschedule-original-info"
    originalInfo.className = "bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6"
    originalInfo.innerHTML = `
      <h5 class="font-medium text-blue-800 mb-2">Original Booking</h5>
      <div class="text-sm text-blue-700 space-y-1">
        <p><strong>Check-in:</strong> ${rescheduleState.originalReservation.original_start_date}</p>
        <p><strong>Check-out:</strong> ${rescheduleState.originalReservation.original_end_date}</p>
        <p><strong>Total Paid:</strong> ${formatCurrency(rescheduleState.originalReservation.paid_amount)}</p>
      </div>
    `

    // Add H-7 validation info
    const validationInfo = document.createElement("div")
    validationInfo.className = `mt-4 p-3 rounded-lg ${eligibility.canReschedule ? "bg-green-50 border border-green-200" : "bg-red-50 border border-red-200"}`
    validationInfo.innerHTML = `
      <div class="flex items-center">
        <i class="fas ${eligibility.canReschedule ? "fa-check-circle text-green-600" : "fa-exclamation-triangle text-red-600"} mr-2"></i>
        <span class="text-sm ${eligibility.canReschedule ? "text-green-700" : "text-red-700"}">${eligibility.message}</span>
      </div>
      <div class="text-xs ${eligibility.canReschedule ? "text-green-600" : "text-red-600"} mt-1">
        <i class="fas fa-info-circle mr-1"></i>
        Kebijakan: Reschedule harus dilakukan minimal H-7 (7 hari) sebelum check-in
      </div>
    `
    originalInfo.appendChild(validationInfo)

    // Insert after step title
    const stepTitleContainer = document.querySelector("#step-1 .flex.items-center")
    if (stepTitleContainer && !document.getElementById("reschedule-original-info")) {
      stepTitleContainer.parentNode.insertBefore(originalInfo, stepTitleContainer.nextSibling)
    }
  }

  /**
   * Initialize date pickers for reschedule with H-7 validation
   */
  function initReschedulePickers() {
    const inEl = document.getElementById("check-in")
    const outEl = document.getElementById("check-out")

    if (!inEl || !outEl) {
      console.error("Date input elements not found")
      return
    }

    // Destroy existing pickers
    if (rescheduleInPicker) {
      rescheduleInPicker.destroy()
      rescheduleInPicker = null
    }
    if (rescheduleOutPicker) {
      rescheduleOutPicker.destroy()
      rescheduleOutPicker = null
    }

    // Clear existing values
    inEl.value = ""
    outEl.value = ""

    // Get disabled ranges from global scope or create empty array
    const fpDisabled = (window.disabledRanges || []).map((r) => ({
      from: r.from,
      to: r.to,
    }))

    // Add H-7 validation: disable dates that are less than 7 days from today
    const today = new Date()
    const minRescheduleDate = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000) // 7 days from today

    // Check if flatpickr is available
    if (typeof window.flatpickr === "undefined") {
      console.error("Flatpickr not loaded")
      // Fallback to regular date inputs with min date
      inEl.type = "date"
      outEl.type = "date"

      // Set minimum date to H+7
      const minDateStr = minRescheduleDate.toISOString().split("T")[0]
      inEl.min = minDateStr
      outEl.min = minDateStr

      inEl.addEventListener("change", function () {
        rescheduleState.newCheckIn = this.value
        if (rescheduleState.newCheckIn && rescheduleState.newCheckOut) {
          calculateReschedulePrice()
        }
      })

      outEl.addEventListener("change", function () {
        rescheduleState.newCheckOut = this.value
        if (rescheduleState.newCheckIn && rescheduleState.newCheckOut) {
          calculateReschedulePrice()
        }
      })

      return
    }

    // Check-in picker with H-7 validation
    try {
      rescheduleInPicker = window.flatpickr(inEl, {
        dateFormat: "Y-m-d",
        minDate: minRescheduleDate, // Minimum 7 days from today
        disable: fpDisabled,
        onChange: (selectedDates, dateStr) => {
          rescheduleState.newCheckIn = dateStr

          const errorEl = document.getElementById("check-in-error")
          if (errorEl) errorEl.classList.add("hidden")

          // Validate H-7 rule
          if (selectedDates[0]) {
            const eligibility = checkRescheduleEligibility(dateStr)
            if (!eligibility.canReschedule) {
              if (errorEl) {
                errorEl.textContent = "Tanggal check-in harus minimal 7 hari dari hari ini"
                errorEl.classList.remove("hidden")
              }
              return
            }

            // Update check-out picker
            const nextDay = new Date(selectedDates[0].getTime() + 86400000)
            if (rescheduleOutPicker) {
              rescheduleOutPicker.set("minDate", nextDay)
            }
          }

          // Calculate if both dates selected
          if (rescheduleState.newCheckIn && rescheduleState.newCheckOut) {
            calculateReschedulePrice()
          }
        },
      })
    } catch (error) {
      console.error("Error initializing check-in picker:", error)
    }

    // Check-out picker
    try {
      rescheduleOutPicker = window.flatpickr(outEl, {
        dateFormat: "Y-m-d",
        minDate: minRescheduleDate,
        disable: fpDisabled,
        onChange: (selectedDates, dateStr) => {
          rescheduleState.newCheckOut = dateStr

          const errorEl = document.getElementById("check-out-error")
          if (errorEl) errorEl.classList.add("hidden")

          // Calculate nights
          if (rescheduleState.newCheckIn && rescheduleState.newCheckOut) {
            const inDate = new Date(rescheduleState.newCheckIn)
            const outDate = new Date(rescheduleState.newCheckOut)
            rescheduleState.newNights = Math.ceil((outDate - inDate) / (1000 * 60 * 60 * 24))

            // Calculate price
            if (outDate > inDate) {
              calculateReschedulePrice()
            }
          }
        },
      })
    } catch (error) {
      console.error("Error initializing check-out picker:", error)
    }
  }

  /**
   * Calculate reschedule pricing
   */
  async function calculateReschedulePrice() {
    const statusEl = document.getElementById("calc-status")
    const wrapEl = document.getElementById("calc-total")
    const amtEl = document.getElementById("calc-amount")

    if (!statusEl || !wrapEl || !amtEl) return

    statusEl.textContent = "Calculating reschedule price..."
    wrapEl.classList.add("hidden")

    try {
      const url = `/reservation/${rescheduleState.reservationId}/calculate-reschedule?new_start_date=${rescheduleState.newCheckIn}&new_end_date=${rescheduleState.newCheckOut}`
      const res = await fetch(url)

      if (!res.ok) throw new Error("Failed to calculate price")

      const data = await res.json()

      rescheduleState.newTotalAmount = data.new_total
      rescheduleState.paymentNeeded = data.payment_needed
      rescheduleState.isAdditionalPayment = data.is_additional_payment

      // Update UI
      if (rescheduleState.paymentNeeded > 0) {
        amtEl.innerHTML = `
          <div class="space-y-1 text-sm text-gray-700">
            <div class="flex justify-between">
              <span>New Total</span>
              <span class="font-medium">${formatCurrency(data.new_total)}</span>
            </div>
            <div class="flex justify-between">
              <span>Already Paid</span>
              <span class="text-gray-500">${formatCurrency(data.paid_amount)}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-semibold text-red-500">Additional Payment</span>
              <span class="font-semibold text-red-500">${formatCurrency(data.payment_needed)}</span>
            </div>
          </div>
        `
      } else {
        amtEl.innerHTML = `
          <div class="space-y-1 text-sm text-gray-700">
            <div class="flex justify-between">
              <span>New Total</span>
              <span class="font-medium">${formatCurrency(data.new_total)}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-semibold text-green-600">No additional payment needed</span>
            </div>
          </div>
        `
      }

      statusEl.textContent = ""
      wrapEl.classList.remove("hidden")
    } catch (error) {
      statusEl.textContent = "Failed to calculate reschedule price."
      console.error("Calculate reschedule price error:", error)
    }
  }

  /**
   * Process reschedule payment with validation
   */
  async function processReschedulePayment() {
    // Validate dates first with H-7 rule
    if (!validateRescheduleDates()) {
      return
    }

    // Double-check H-7 validation
    const eligibility = checkRescheduleEligibility(rescheduleState.newCheckIn)
    if (!eligibility.canReschedule) {
      alert(`Reschedule Tidak Diizinkan\n\n${eligibility.message}`)
      return
    }

    console.log('Processing reschedule payment. Payment needed:', rescheduleState.paymentNeeded);

    if (rescheduleState.paymentNeeded <= 0) {
      // No payment needed, directly update reservation
      console.log('No additional payment needed, updating reservation directly');
      const success = await updateReservationDates()
      if (success) {
        if (goToStep) goToStep(5)
      }
      return
    }

    // Generate payment token for additional payment
    const payload = {
      villa_id: rescheduleState.originalReservation.villa_id,
      check_in: rescheduleState.newCheckIn,
      check_out: rescheduleState.newCheckOut,
      total_amount: rescheduleState.paymentNeeded,
      guest_name: rescheduleState.originalReservation.guest.full_name || rescheduleState.originalReservation.guest.name,
      guest_email: rescheduleState.originalReservation.guest.email,
      guest_phone:
        rescheduleState.originalReservation.guest.phone_number || rescheduleState.originalReservation.guest.phone,
      reservation_id: rescheduleState.reservationId,
    }

    try {
      console.log('Requesting payment token with payload:', payload);

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
        const errorText = await res.text()
        console.error("Payment token error:", errorText)
        throw new Error(`Failed to generate payment token: HTTP ${res.status}`)
      }

      const { snap_token } = await res.json()
      console.log('Payment token received:', snap_token);

      // Open Midtrans payment
      if (window.snap) {
        window.snap.pay(snap_token, {
          onSuccess: async (result) => {
            console.log('Payment success:', result);
            // Pass snap_token to updateReservationDates
            const success = await updateReservationDates(snap_token)
            if (success) {
              if (goToStep) goToStep(5)
            }
          },
          onPending: async (result) => {
            console.log('Payment pending:', result);
            // Pass snap_token to updateReservationDates
            const success = await updateReservationDates(snap_token)
            if (success) {
              if (goToStep) goToStep(5)
            }
          },
          onError: (result) => {
            console.error("Payment error:", result)
            alert("Payment failed. Please try again.")
          },
          onClose: () => {
            // Payment modal closed
            console.log('Payment modal closed without completing payment');
          },
        })
      } else {
        throw new Error("Midtrans Snap not loaded")
      }
    } catch (error) {
      console.error("Payment processing error:", error)
      alert("Failed to process payment: " + error.message)
    }
  }

  /**
   * Update reservation with new dates
   */
  async function updateReservationDates(snapToken = null) {
    console.log('Updating reservation dates with state:', {
      reservationId: rescheduleState.reservationId,
      newDates: [rescheduleState.newCheckIn, rescheduleState.newCheckOut],
      newTotal: rescheduleState.newTotalAmount,
      paymentNeeded: rescheduleState.paymentNeeded,
      snapToken: snapToken
    });

    const payload = {
      reservation_id: rescheduleState.reservationId,
      new_start_date: rescheduleState.newCheckIn,
      new_end_date: rescheduleState.newCheckOut,
      new_total_amount: rescheduleState.newTotalAmount,
      payment_amount: rescheduleState.paymentNeeded,
      snap_token: snapToken
    }

    try {
      const res = await fetch("/reservation/reschedule", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify(payload),
      })

      if (!res.ok) {
        const errorText = await res.text()
        console.error("Reschedule API Error:", errorText)
        throw new Error(`HTTP ${res.status}: ${errorText}`)
      }

      const data = await res.json()
      console.log('Reschedule successful:', data);
      return true
    } catch (error) {
      console.error("Failed to update reservation:", error)
      alert("Failed to update reservation: " + error.message)
      return false
    }
  }

  /**
   * Reset reschedule state
   */
  function resetRescheduleState() {
    rescheduleState.reservationId = null
    rescheduleState.originalReservation = null
    rescheduleState.newCheckIn = ""
    rescheduleState.newCheckOut = ""
    rescheduleState.newNights = 0
    rescheduleState.newTotalAmount = 0
    rescheduleState.paymentNeeded = 0
    rescheduleState.isAdditionalPayment = false
    rescheduleState.isRescheduleMode = false
    rescheduleState.canReschedule = false

    // Remove reschedule UI elements
    const originalInfo = document.getElementById("reschedule-original-info")
    if (originalInfo) {
      originalInfo.remove()
    }

    // Destroy reschedule pickers
    if (rescheduleInPicker) {
      rescheduleInPicker.destroy()
      rescheduleInPicker = null
    }
    if (rescheduleOutPicker) {
      rescheduleOutPicker.destroy()
      rescheduleOutPicker = null
    }
  }

  // Initialize when DOM is ready
  document.addEventListener("DOMContentLoaded", () => {
    // Assign functions from global scope
    loadRoomDetails = window.loadRoomDetails
    loadReservedDates = window.loadReservedDates
    goToStep = window.goToStep
    flatpickr = window.flatpickr

    // Listen for Livewire events
    window.addEventListener("openRescheduleModal", (event) => {
      openRescheduleModal(event.detail[0])
    })

    // Override modal close to reset reschedule state
    const originalCloseModal = window.closeModal
    if (originalCloseModal) {
      window.closeModal = () => {
        resetRescheduleState()
        originalCloseModal()
      }
    }

    // Override next button behavior for reschedule mode
    const nextButton = document.getElementById("next-step")
    if (nextButton) {
      const originalNextHandler = nextButton.onclick

      nextButton.onclick = async function () {
        // Check if we're in reschedule mode
        if (rescheduleState.isRescheduleMode && rescheduleState.reservationId) {
          if (window.currentStep === 1) {
            // Validate dates with H-7 rule
            if (!validateRescheduleDates()) {
              return
            }

            // Process reschedule payment
            await processReschedulePayment()
            return
          }
        }

        // Use original handler for normal booking
        if (originalNextHandler) {
          originalNextHandler.call(this)
        }
      }
    }
  })

  // Expose functions to global scope if needed
  window.openRescheduleModal = openRescheduleModal
  window.rescheduleState = rescheduleState
  window.validateRescheduleDates = validateRescheduleDates
  window.checkRescheduleEligibility = checkRescheduleEligibility
})()
