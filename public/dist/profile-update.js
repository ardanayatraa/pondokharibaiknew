// Profile Update Handler
document.addEventListener("DOMContentLoaded", () => {
  const profileForm = document.getElementById("guest-profile-form")

  if (profileForm) {
    profileForm.addEventListener("submit", async (e) => {
      e.preventDefault()

      if (!window.guestId) {
        showAlert("error", "Guest ID not found")
        return
      }

      // Get form data
      const formData = {
        username: document.getElementById("modal-guest-username").value,
        full_name: document.getElementById("modal-guest-name").value,
        email: document.getElementById("modal-guest-email").value,
        phone_number: document.getElementById("modal-guest-phone").value,
        address: document.getElementById("modal-guest-address").value,
        id_card_number: document.getElementById("modal-guest-id-card").value,
        passport_number: document.getElementById("modal-guest-passport").value,
        birthdate: document.getElementById("modal-guest-birthdate").value,
        gender: document.getElementById("modal-guest-gender").value,
      }

      // Show loading state
      const submitBtn = profileForm.querySelector('button[type="submit"]')
      const originalText = submitBtn.innerHTML
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...'
      submitBtn.disabled = true

      try {
        const response = await fetch(`/updateUser`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
          body: JSON.stringify({
            id: window.guestId,
            ...formData,
          }),
        })

        const result = await response.json()

        if (response.ok && result.success) {
          showAlert("success", "Profile updated successfully!")

          // Update user avatar if name changed
          const userAvatar = document.querySelector(".user-avatar")
          if (userAvatar && formData.full_name) {
            userAvatar.textContent = formData.full_name.charAt(0).toUpperCase()
          }

          // Close modal after successful update
          setTimeout(() => {
            window.toggleGuestModal()
          }, 1500)
        } else {
          throw new Error(result.message || "Failed to update profile")
        }
      } catch (error) {
        console.error("Profile update error:", error)
        showAlert("error", error.message || "Failed to update profile")
      } finally {
        // Reset button state
        submitBtn.innerHTML = originalText
        submitBtn.disabled = false
      }
    })
  }
})

// Alert function
function showAlert(type, message) {
  // Remove existing alerts
  const existingAlerts = document.querySelectorAll(".alert-notification")
  existingAlerts.forEach((alert) => alert.remove())

  const alertDiv = document.createElement("div")
  alertDiv.className = `alert-notification fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
    type === "success" ? "bg-green-500" : "bg-red-500"
  } text-white`

  alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === "success" ? "fa-check-circle" : "fa-exclamation-circle"} mr-2"></i>
            ${message}
        </div>
    `

  document.body.appendChild(alertDiv)

  setTimeout(() => {
    alertDiv.style.opacity = "0"
    setTimeout(() => {
      alertDiv.remove()
    }, 300)
  }, 5000)
}
