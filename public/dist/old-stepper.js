// Room data
const roomData = {
    'family-bungalow': {
        name: 'Family Bungalow',
        price: 450000,
        image: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        description: 'Luxurious bungalow with private balcony, perfect for families looking for comfort and privacy. Enjoy stunning views and premium amenities.',
        capacity: 'Up to 4 people',
        beds: '1 King + 2 Singles',
        tag: 'Popular'
    },
    'family-garden': {
        name: 'Family Room with Garden View',
        price: 550000,
        image: 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        description: 'Spacious family room with beautiful garden views. Enjoy premium amenities and a serene atmosphere.',
        capacity: 'Up to 4 people',
        beds: '1 King + 2 Singles',
        tag: 'Best Value'
    },
    'twins-garden': {
        name: 'Twins Room with Garden View',
        price: 350000,
        image: 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        description: 'Cozy twin room with garden views, perfect for couples or friends traveling together.',
        capacity: 'Up to 2 people',
        beds: '2 Twin Beds',
        tag: ''
    }
};

// Booking data
let bookingData = {
    roomId: 'family-bungalow',
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

// DOM Elements
const modal = document.getElementById('booking-stepper-modal');
const modalContent = document.getElementById('modal-content');
const closeModalBtn = document.getElementById('close-modal');
const modalBackdrop = document.getElementById('modal-backdrop');
const nextBtn = document.getElementById('next-step');
const prevBtn = document.getElementById('prev-step');
const progressBar = document.getElementById('progress-bar');
const changeRoomBtn = document.getElementById('change-room-btn');

// Current step tracking
let currentStep = 1;
const totalSteps = 5;

// Initialize date inputs with today and tomorrow
document.addEventListener('DOMContentLoaded', function() {
    // Set min dates for check-in and check-out
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    const checkInInput = document.getElementById('check-in');
    const checkOutInput = document.getElementById('check-out');

    // Format dates for input
    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    // Set min attribute
    checkInInput.min = formatDate(today);
    checkOutInput.min = formatDate(tomorrow);

    // Set default values
    checkInInput.value = formatDate(today);
    checkOutInput.value = formatDate(tomorrow);

    // Update booking data
    bookingData.checkIn = formatDate(today);
    bookingData.checkOut = formatDate(tomorrow);

    // Calculate nights
    updateNights();

    // Initialize room info
    updateSelectedRoomInfo();

    // Set up event listeners for date changes
    checkInInput.addEventListener('change', function() {
        bookingData.checkIn = this.value;

        // Ensure check-out is after check-in
        const checkInDate = new Date(this.value);
        const checkOutDate = new Date(checkOutInput.value);

        if (checkOutDate <= checkInDate) {
            const newCheckOut = new Date(checkInDate);
            newCheckOut.setDate(newCheckOut.getDate() + 1);
            checkOutInput.value = formatDate(newCheckOut);
            bookingData.checkOut = formatDate(newCheckOut);
        }

        // Update min date for check-out
        checkOutInput.min = this.value;

        // Update nights
        updateNights();
    });

    checkOutInput.addEventListener('change', function() {
        bookingData.checkOut = this.value;
        updateNights();
    });

    // Initialize payment method radio buttons
    document.querySelectorAll('.payment-option input').forEach(input => {
        input.addEventListener('change', function() {
            // Remove active class from all labels
            document.querySelectorAll('.payment-label').forEach(label => {
                label.classList.remove('bg-elegant-cream/50',
                    'border-elegant-burgundy');
            });

            // Add active class to selected label
            if (this.checked) {
                this.parentElement.querySelector('label').classList.add(
                    'bg-elegant-cream/50', 'border-elegant-burgundy');

                // Update booking data
                bookingData.paymentMethod = this.id.replace('payment-', '');

                // Show/hide credit card form
                const creditCardForm = document.getElementById('credit-card-form');
                if (this.id === 'payment-credit') {
                    creditCardForm.classList.remove('hidden');
                } else {
                    creditCardForm.classList.add('hidden');
                }
            }
        });
    });

    // Trigger change event on the checked radio button to initialize styles
    document.querySelector('.payment-option input:checked').dispatchEvent(new Event('change'));

    // Set up modal event listeners
    setupModalEventListeners();
});

// Set up modal event listeners
function setupModalEventListeners() {
    // Listen for openBookingModal event
    document.addEventListener('openBookingModal', function(e) {
        if (e.detail && e.detail.roomId) {
            bookingData.roomId = e.detail.roomId;
            updateSelectedRoomInfo();
        }
        openBookingModal();
    });

    // Close modal
    closeModalBtn.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);

    // Change room button
    changeRoomBtn.addEventListener('click', function(e) {
        e.preventDefault();
        // Scroll to rooms section
        document.getElementById('rooms').scrollIntoView({
            behavior: 'smooth'
        });
        // Close modal
        closeModal();
    });

    // Next step
    nextBtn.addEventListener('click', function() {
        if (currentStep < totalSteps) {
            // Validate current step
            if (validateStep(currentStep)) {
                goToStep(currentStep + 1);
            }
        } else {
            // On last step, close modal when "Finish" is clicked
            closeModal();

            // Reset form for next booking
            setTimeout(() => {
                resetBookingForm();
            }, 500);
        }
    });

    // Previous step
    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    // Download receipt (demo functionality)
    document.getElementById('download-receipt').addEventListener('click', function() {
        alert('Receipt download functionality would be implemented here.');
    });

    // View booking (demo functionality)
    document.getElementById('view-booking').addEventListener('click', function() {
        alert('View booking functionality would be implemented here.');
    });
}

// Open booking modal
function openBookingModal() {
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling

    // Animate modal in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    resetStepper();
}

// Close modal
function closeModal() {
    // Animate modal out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
    }, 300);
}

// Go to specific step
function goToStep(step) {
    // Hide all steps with fade effect
    const currentStepContent = document.getElementById(`step-${currentStep}`);
    const nextStepContent = document.getElementById(`step-${step}`);

    // Fade out current step
    currentStepContent.style.opacity = '0';

    setTimeout(() => {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Show target step
        nextStepContent.classList.remove('hidden');

        // Fade in next step
        setTimeout(() => {
            nextStepContent.style.opacity = '1';
        }, 50);
    }, 300);

    // Update progress bar
    const progressPercentage = ((step - 1) / (totalSteps - 1)) * 100;
    progressBar.style.width = `${progressPercentage}%`;

    // Update stepper circles
    document.querySelectorAll('.stepper-circle').forEach((circle, index) => {
        if (index + 1 < step) {
            circle.classList.add('bg-elegant-burgundy', 'text-elegant-white');
            circle.classList.remove('bg-elegant-gold/30', 'text-elegant-navy');
            // Add check icon to completed steps
            circle.innerHTML = '<i class="fas fa-check"></i>';
        } else if (index + 1 === step) {
            circle.classList.add('bg-elegant-burgundy', 'text-elegant-white');
            circle.classList.remove('bg-elegant-gold/30', 'text-elegant-navy');
            circle.textContent = index + 1;
        } else {
            circle.classList.add('bg-elegant-gold/30', 'text-elegant-navy');
            circle.classList.remove('bg-elegant-burgundy', 'text-elegant-white');
            circle.textContent = index + 1;
        }
    });

    // Update stepper labels
    document.querySelectorAll('.stepper-label span').forEach((label, index) => {
        if (index + 1 <= step) {
            label.classList.add('text-elegant-burgundy');
            label.classList.remove('text-elegant-charcoal');
        } else {
            label.classList.add('text-elegant-charcoal');
            label.classList.remove('text-elegant-burgundy');
        }
    });

    // Update buttons
    if (step === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }

    if (step === totalSteps) {
        nextBtn.innerHTML =
            '<div class="flex items-center"><span>Finish</span><i class="fas fa-check ml-2 group-hover:translate-x-1 transition-transform duration-300"></i></div>';
    } else {
        nextBtn.innerHTML =
            '<div class="flex items-center"><span>Next</span><i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i></div>';
    }

    // Update current step
    currentStep = step;

    // Update step-specific information
    updateStepInfo(step);
}

// Update step-specific information
function updateStepInfo(step) {
    if (step === 2) {
        // Update room details
        updateRoomDetails();
        // Update booking summary
        updateBookingSummary();
    } else if (step === 4) {
        // Update payment summary
        updatePaymentSummary();
    } else if (step === 5) {
        // Update confirmation details
        updateConfirmationDetails();
    }
}

// Validate step
function validateStep(step) {
    let isValid = true;

    // Reset all error messages
    document.querySelectorAll('.error-message').forEach(error => {
        error.classList.add('hidden');
    });
    document.querySelectorAll('.input-error').forEach(input => {
        input.classList.remove('input-error');
    });

    if (step === 1) {
        // Validate dates
        const checkIn = document.getElementById('check-in');
        const checkOut = document.getElementById('check-out');

        if (!checkIn.value) {
            document.getElementById('check-in-error').classList.remove('hidden');
            checkIn.classList.add('input-error');
            isValid = false;
        }

        if (!checkOut.value) {
            document.getElementById('check-out-error').classList.remove('hidden');
            checkOut.classList.add('input-error');
            isValid = false;
        }

        if (checkIn.value && checkOut.value) {
            const checkInDate = new Date(checkIn.value);
            const checkOutDate = new Date(checkOut.value);

            if (checkOutDate <= checkInDate) {
                document.getElementById('date-range-error').classList.remove('hidden');
                checkOut.classList.add('input-error');
                isValid = false;
            }
        }

        // Update booking data
        if (isValid) {
            bookingData.adults = document.getElementById('adults').value;
            bookingData.children = document.getElementById('children').value;
        }
    } else if (step === 3) {
        // Validate guest information
        const guestName = document.getElementById('guest-name');
        const guestEmail = document.getElementById('guest-email');
        const guestPhone = document.getElementById('guest-phone');
        const guestCountry = document.getElementById('guest-country');

        if (!guestName.value.trim()) {
            document.getElementById('guest-name-error').classList.remove('hidden');
            guestName.classList.add('input-error');
            isValid = false;
        }

        if (!guestEmail.value.trim() || !isValidEmail(guestEmail.value)) {
            document.getElementById('guest-email-error').classList.remove('hidden');
            guestEmail.classList.add('input-error');
            isValid = false;
        }

        if (!guestPhone.value.trim()) {
            document.getElementById('guest-phone-error').classList.remove('hidden');
            guestPhone.classList.add('input-error');
            isValid = false;
        }

        if (!guestCountry.value) {
            document.getElementById('guest-country-error').classList.remove('hidden');
            guestCountry.classList.add('input-error');
            isValid = false;
        }

        // Update booking data
        if (isValid) {
            bookingData.guestName = guestName.value;
            bookingData.guestEmail = guestEmail.value;
            bookingData.guestPhone = guestPhone.value;
            bookingData.guestCountry = guestCountry.value;
            bookingData.specialRequests = document.getElementById('special-requests').value;
        }
    } else if (step === 4) {
        // Validate payment information if credit card is selected
        if (bookingData.paymentMethod === 'credit') {
            const cardName = document.getElementById('card-name');
            const cardNumber = document.getElementById('card-number');
            const cardMonth = document.getElementById('card-expiry-month');
            const cardYear = document.getElementById('card-expiry-year');
            const cardCVV = document.getElementById('card-cvv');

            if (!cardName.value.trim()) {
                document.getElementById('card-name-error').classList.remove('hidden');
                cardName.classList.add('input-error');
                isValid = false;
            }

            if (!cardNumber.value.trim() || !isValidCardNumber(cardNumber.value)) {
                document.getElementById('card-number-error').classList.remove('hidden');
                cardNumber.classList.add('input-error');
                isValid = false;
            }

            if (!cardMonth.value) {
                document.getElementById('card-month-error').classList.remove('hidden');
                cardMonth.classList.add('input-error');
                isValid = false;
            }

            if (!cardYear.value) {
                document.getElementById('card-year-error').classList.remove('hidden');
                cardYear.classList.add('input-error');
                isValid = false;
            }

            if (!cardCVV.value.trim() || !isValidCVV(cardCVV.value)) {
                document.getElementById('card-cvv-error').classList.remove('hidden');
                cardCVV.classList.add('input-error');
                isValid = false;
            }

            // Update booking data
            if (isValid) {
                bookingData.cardName = cardName.value;
                bookingData.cardNumber = cardNumber.value;
                bookingData.cardMonth = cardMonth.value;
                bookingData.cardYear = cardYear.value;
                bookingData.cardCVV = cardCVV.value;
            }
        }
    }

    return isValid;
}

// Helper functions for validation
function isValidEmail(email) {
    const re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function isValidCardNumber(number) {
    // Simple validation for demo purposes
    return number.replace(/\s/g, '').length >= 13;
}

function isValidCVV(cvv) {
    // Simple validation for demo purposes
    return /^\d{3,4}$/.test(cvv);
}

// Reset stepper to first step
function resetStepper() {
    // Reset opacity for all steps
    document.querySelectorAll('.step-content').forEach(content => {
        content.style.opacity = '1';
    });

    goToStep(1);
}

// Update nights calculation
function updateNights() {
    const checkInDate = new Date(bookingData.checkIn);
    const checkOutDate = new Date(bookingData.checkOut);

    // Calculate nights
    const nights = Math.round((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
    bookingData.nights = nights > 0 ? nights : 1;
}

// Update selected room info in step 1
function updateSelectedRoomInfo() {
    const room = roomData[bookingData.roomId];

    if (room) {
        document.getElementById('selected-room-name').textContent = room.name;
        document.getElementById('selected-room-price').textContent = `Rp ${formatCurrency(room.price)} / night`;
    }
}

// Update room details in step 2
function updateRoomDetails() {
    const room = roomData[bookingData.roomId];

    if (room) {
        document.getElementById('room-image').src = room.image;
        document.getElementById('room-detail-name').textContent = room.name;
        document.getElementById('room-detail-price').textContent = `Rp ${formatCurrency(room.price)}`;
        document.getElementById('room-description').textContent = room.description;
        document.getElementById('room-capacity').textContent = room.capacity;
        document.getElementById('room-beds').textContent = room.beds;

        // Update room tag
        const roomTag = document.getElementById('room-tag');
        if (room.tag) {
            roomTag.textContent = room.tag;
            roomTag.classList.remove('hidden');
        } else {
            roomTag.classList.add('hidden');
        }
    }
}

// Update booking summary in step 2
function updateBookingSummary() {
    const room = roomData[bookingData.roomId];

    if (room) {
        // Format dates
        const checkInDate = new Date(bookingData.checkIn);
        const checkOutDate = new Date(bookingData.checkOut);

        // Update summary
        document.getElementById('summary-checkin').textContent = formatDate(checkInDate);
        document.getElementById('summary-checkout').textContent = formatDate(checkOutDate);
        document.getElementById('summary-nights').textContent = bookingData.nights;
        document.getElementById('summary-guests').textContent =
            `${bookingData.adults} Adults, ${bookingData.children} Children`;

        // Calculate total
        const roomTotal = room.price * bookingData.nights;
        const tax = roomTotal * 0.1;
        const grandTotal = roomTotal + tax;

        // Update price details
        document.getElementById('room-rate-label').textContent = `Room Rate (${bookingData.nights} nights):`;
        document.getElementById('room-rate-total').textContent = `Rp ${formatCurrency(roomTotal)}`;
        document.getElementById('tax-amount').textContent = `Rp ${formatCurrency(tax)}`;
        document.getElementById('summary-total').textContent = `Rp ${formatCurrency(grandTotal)}`;
    }
}

// Update payment summary in step 4
function updatePaymentSummary() {
    const room = roomData[bookingData.roomId];

    if (room) {
        // Calculate total
        const roomTotal = room.price * bookingData.nights;
        const tax = roomTotal * 0.1;
        const grandTotal = roomTotal + tax;

        // Update price details
        document.getElementById('payment-room-rate-label').textContent =
        `Room Rate (${bookingData.nights} nights):`;
        document.getElementById('payment-room-rate-total').textContent = `Rp ${formatCurrency(roomTotal)}`;
        document.getElementById('payment-tax-amount').textContent = `Rp ${formatCurrency(tax)}`;
        document.getElementById('payment-total').textContent = `Rp ${formatCurrency(grandTotal)}`;
    }
}

// Update confirmation details in step 5
function updateConfirmationDetails() {
    const room = roomData[bookingData.roomId];

    if (room) {
        // Generate booking ID
        const bookingId = generateBookingId();

        // Format dates
        const checkInDate = new Date(bookingData.checkIn);
        const checkOutDate = new Date(bookingData.checkOut);

        // Calculate total
        const roomTotal = room.price * bookingData.nights;
        const tax = roomTotal * 0.1;
        const grandTotal = roomTotal + tax;

        // Update confirmation details
        document.getElementById('confirmation-email').textContent = bookingData.guestEmail;
        document.getElementById('booking-id').textContent = bookingId;
        document.getElementById('confirmation-room').textContent = room.name;
        document.getElementById('confirmation-checkin').textContent = formatDate(checkInDate);
        document.getElementById('confirmation-checkout').textContent = formatDate(checkOutDate);
        document.getElementById('confirmation-guests').textContent =
            `${bookingData.adults} Adults, ${bookingData.children} Children`;

        // Payment method
        let paymentMethod = 'Credit Card';
        if (bookingData.paymentMethod === 'paypal') {
            paymentMethod = 'PayPal';
        } else if (bookingData.paymentMethod === 'bank') {
            paymentMethod = 'Bank Transfer';
        }
        document.getElementById('confirmation-payment').textContent = paymentMethod;

        // Total amount
        document.getElementById('confirmation-total').textContent = `Rp ${formatCurrency(grandTotal)}`;
    }
}

// Generate booking ID
function generateBookingId() {
    const date = new Date();
    const year = date.getFullYear().toString().substr(-2);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');

    return `PHB${year}${month}${day}${random}`;
}

// Format date
function formatDate(date) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    return date.toLocaleDateString('en-US', options);
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID').format(amount);
}

// Reset booking form
function resetBookingForm() {
    // Reset booking data
    bookingData = {
        roomId: 'family-bungalow',
        checkIn: document.getElementById('check-in').value,
        checkOut: document.getElementById('check-out').value,
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

    // Reset form fields
    document.getElementById('adults').value = '2';
    document.getElementById('children').value = '0';
    document.getElementById('guest-name').value = '';
    document.getElementById('guest-email').value = '';
    document.getElementById('guest-phone').value = '';
    document.getElementById('guest-country').value = '';
    document.getElementById('special-requests').value = '';
    document.getElementById('card-name').value = '';
    document.getElementById('card-number').value = '';
    document.getElementById('card-expiry-month').value = '';
    document.getElementById('card-expiry-year').value = '';
    document.getElementById('card-cvv').value = '';

    // Update nights
    updateNights();

    // Update selected room info
    updateSelectedRoomInfo();
}
