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

      // Ambil ID reservasi dari URL
      const urlParts = window.location.pathname.split('/');
      const reservationId = urlParts[urlParts.indexOf('reservation') + 1];

      if (reservationId) {
        // Simpan ID reservasi ke sessionStorage untuk digunakan saat update status pembayaran
        sessionStorage.setItem('current_reservation_id', reservationId);
        console.log("✅ ID Reservasi disimpan ke sessionStorage:", reservationId);
      }

      // Jalankan Snap
      if (window.snap) {
        window.snap.pay(snapToken, {
          onSuccess: function(result) {
            console.log('Pembayaran berhasil:', result);
            // Update status pembayaran menjadi success
            updatePaymentStatus('success', result)
              .then(() => {
                console.log('Payment status updated to success, redirecting...');
                // Tambahkan delay lebih lama sebelum redirect untuk memastikan status diperbarui
                setTimeout(() => {
                  window.location.href = '/dashboard?status=success&message=Pembayaran berhasil';
                }, 3000);
              })
              .catch(err => {
                console.error('Error updating payment status:', err);
                alert('Pembayaran berhasil, tetapi gagal memperbarui status. Silakan refresh halaman.');
              });
          },
          onPending: function(result) {
            console.log('Pembayaran pending:', result);
            // Update status pembayaran menjadi pending
            updatePaymentStatus('pending', result)
              .then(() => {
                console.log('Payment status updated to pending, redirecting...');
                // Redirect ke dashboard dengan pesan pending
                setTimeout(() => {
                  window.location.href = '/dashboard?status=pending&message=Pembayaran dalam proses';
                }, 3000);
              })
              .catch(err => {
                console.error('Error updating payment status:', err);
                alert('Pembayaran dalam proses, tetapi gagal memperbarui status. Silakan refresh halaman.');
              });
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

    // Ambil ID reservasi dari session storage yang disimpan saat membuat reservasi
    // Ini lebih reliable daripada mencoba mengekstrak dari URL atau order_id
    const sessionReservationId = sessionStorage.getItem('current_reservation_id');

    // Fallback ke ekstraksi dari URL jika tidak ada di session
    let reservationId = sessionReservationId;

    if (!reservationId) {
      // Coba ambil dari URL
      const urlParts = window.location.pathname.split('/');
      if (urlParts.indexOf('reservation') !== -1) {
        reservationId = urlParts[urlParts.indexOf('reservation') + 1];
        console.log('Extracted reservation ID from URL:', reservationId);
      }
    }

    if (!reservationId) {
      console.error('Reservation ID not found in sessionStorage or URL');
      return Promise.reject(new Error('Reservation ID not found'));
    }

    console.log('Updating payment status for reservation:', reservationId, 'Status:', status);

    // Send request to update payment status
    return fetch('/api/payment/update-status', {
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

      // Verifikasi status yang diperbarui
      if (status === 'success') {
        console.log('Reservation should now be confirmed');
      } else {
        console.log('Reservation remains in pending status');
      }

      return data;
    })
    .catch(error => {
      console.error('Error updating payment status:', error);
      throw error;
    });
  }
});
