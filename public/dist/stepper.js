// Stepper functionality
document.addEventListener("DOMContentLoaded", () => {
  // Initialize stepper variables
  window.currentStep = 1
  const totalSteps = 5

  // Stepper navigation functions
  window.goToStep = (step) => {
    // Hide current step
    document.getElementById(`step-${window.currentStep}`).classList.add("hidden")

    // Show target step
    document.getElementById(`step-${step}`).classList.remove("hidden")

    // Update progress bar
    const progress = ((step - 1) / (totalSteps - 1)) * 100
    document.getElementById("progress-bar").style.width = progress + "%"

    // Update current step
    window.currentStep = step

    // Update navigation buttons
    const prevBtn = document.getElementById("prev-step")
    const nextBtn = document.getElementById("next-step")

    if (prevBtn) {
      prevBtn.classList.toggle("hidden", step === 1 || step === 5)
    }

    if (nextBtn) {
      if (step === totalSteps) {
        nextBtn.innerHTML = `<div class="flex items-center"><span>Finish</span><i class="fas fa-check ml-2"></i></div>`
      } else {
        nextBtn.innerHTML = `<div class="flex items-center"><span>Next</span><i class="fas fa-arrow-right ml-2"></i></div>`
      }
    }

    // Call step-specific render functions
    if (step === 2) window.renderStep2()
    if (step === 3) window.renderStep3()
    if (step === 4) window.renderStep4()
  }

  window.resetStepper = () => {
    window.goToStep(1)
  }

  // Validation function
  window.validateStep = (step) => {
    let isValid = true

    if (step === 1) {
      const checkIn = document.getElementById("check-in").value
      const checkOut = document.getElementById("check-out").value
      const checkInError = document.getElementById("check-in-error")
      const checkOutError = document.getElementById("check-out-error")
      const dateRangeError = document.getElementById("date-range-error")

      // Reset errors
      if (checkInError) checkInError.classList.add("hidden")
      if (checkOutError) checkOutError.classList.add("hidden")
      if (dateRangeError) dateRangeError.classList.add("hidden")

      if (!checkIn) {
        if (checkInError) checkInError.classList.remove("hidden")
        isValid = false
      }

      if (!checkOut) {
        if (checkOutError) checkOutError.classList.remove("hidden")
        isValid = false
      }

      if (checkIn && checkOut) {
        const inDate = new Date(checkIn)
        const outDate = new Date(checkOut)
        if (outDate <= inDate) {
          if (dateRangeError) dateRangeError.classList.remove("hidden")
          isValid = false
        }
      }
    }

    if (step === 3) {
      const requiredFields = ["guest-name", "guest-email", "guest-phone"]
      requiredFields.forEach((fieldId) => {
        const field = document.getElementById(fieldId)
        if (field && !field.value.trim()) {
          field.classList.add("input-error")
          isValid = false
        } else if (field) {
          field.classList.remove("input-error")
        }
      })
    }

    return isValid
  }

  // Payment method selection
  document.addEventListener("change", (e) => {
    if (e.target.name === "payment-method") {
      const payNowBtn = document.getElementById("btn-paynow")
      if (payNowBtn) {
        payNowBtn.classList.remove("hidden")
      }
    }
  })
})
