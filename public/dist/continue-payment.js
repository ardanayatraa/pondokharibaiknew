// Continue Payment functionality
document.addEventListener("DOMContentLoaded", () => {
  // Get the payment button
  const payButton = document.getElementById('pay-button');

  if (payButton) {
    payButton.addEventListener('click', function() {
      // Tampilkan loading spinner
      this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
      this.disabled = true;

      // Ambil snap token dari data attribute
      const snapToken = this.getAttribute('data-snap-token') || document.getElementById('snap-token').value;

      if (!snapToken) {
        alert('Snap token tidak ditemukan');
        // Kembalikan tombol ke keadaan semula
        this.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran';
        this.disabled = false;
        return;
      }

      // Jalankan Snap
      if (window.snap) {
        window.snap.pay(snapToken, {
          onSuccess: function(result) {
            console.log('Pembayaran berhasil:', result);
            // Update status pembayaran menjadi success
            updatePaymentStatus('success', result);
            // Redirect ke dashboard dengan pesan sukses
            window.location.href = '/dashboard?status=success&message=Pembayaran berhasil';
          },
          onPending: function(result) {
            console.log('Pembayaran pending:', result);
            // Update status pembayaran menjadi pending
            updatePaymentStatus('pending', result);
            // Redirect ke dashboard dengan pesan pending
            window.location.href = '/dashboard?status=pending&message=Pembayaran dalam proses';
          },
          onError: function(result) {
            console.log('Pembayaran gagal:', result);
            // Kembalikan tombol ke keadaan semula
            payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran';
            payButton.disabled = false;
            // Tampilkan pesan error
            alert('Pembayaran gagal: ' + (result.message || 'Terjadi kesalahan'));
          },
          onClose: function() {
            console.log('Snap ditutup tanpa menyelesaikan pembayaran');
            // Kembalikan tombol ke keadaan semula
            payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran';
            payButton.disabled = false;
          }
        });
      } else {
        alert('Midtrans Snap tidak tersedia');
        // Kembalikan tombol ke keadaan semula
        payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran';
        payButton.disabled = false;
      }
    });
  }

  // Function to update payment status
  function updatePaymentStatus(status, result) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Get reservation ID from URL
    const urlParts = window.location.pathname.split('/');
    const reservationId = urlParts[urlParts.indexOf('reservation') + 1];

    if (!reservationId) {
      console.error('Reservation ID not found in URL');
      return;
    }

    // Send request to update payment status
    fetch('/api/payment/update-status', {
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
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to update payment status');
      }
      return response.json();
    })
    .then(data => {
      console.log('Payment status updated:', data);
    })
    .catch(error => {
      console.error('Error updating payment status:', error);
    });
  }
});
