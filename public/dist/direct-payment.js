// Direct Payment functionality
document.addEventListener("DOMContentLoaded", () => {
  // Get all direct payment buttons
  const directPayButtons = document.querySelectorAll('.direct-pay-button');

  if (directPayButtons.length > 0) {
    directPayButtons.forEach(button => {
      button.addEventListener('click', async function(e) {
        e.preventDefault();

        // Tampilkan loading spinner
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        this.disabled = true;

        // Ambil reservation ID dari data attribute
        const reservationId = this.getAttribute('data-reservation-id');

        if (!reservationId) {
          alert('ID Reservasi tidak ditemukan');
          // Kembalikan tombol ke keadaan semula
          this.innerHTML = originalText;
          this.disabled = false;
          return;
        }

        try {
          // Ambil snap token dari server
          const response = await fetch(`/api/payment/get-snap-token/${reservationId}`, {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });

          if (!response.ok) {
            throw new Error('Gagal mendapatkan token pembayaran');
          }

          const data = await response.json();
          const snapToken = data.snap_token;

          if (!snapToken) {
            throw new Error('Token pembayaran tidak valid');
          }

          // Jalankan Snap
          if (window.snap) {
            window.snap.pay(snapToken, {
              onSuccess: function(result) {
                console.log('Pembayaran berhasil:', result);
                // Update status pembayaran menjadi success
                updatePaymentStatus(reservationId, 'success', result);
                // Reload halaman dengan pesan sukses
                window.location.reload();
              },
              onPending: function(result) {
                console.log('Pembayaran pending:', result);
                // Update status pembayaran menjadi pending
                updatePaymentStatus(reservationId, 'pending', result);
                // Reload halaman dengan pesan pending
                window.location.reload();
              },
              onError: function(result) {
                console.log('Pembayaran gagal:', result);
                // Kembalikan tombol ke keadaan semula
                button.innerHTML = originalText;
                button.disabled = false;
                // Tampilkan pesan error
                alert('Pembayaran gagal: ' + (result.message || 'Terjadi kesalahan'));
              },
              onClose: function() {
                console.log('Snap ditutup tanpa menyelesaikan pembayaran');
                // Kembalikan tombol ke keadaan semula
                button.innerHTML = originalText;
                button.disabled = false;
              }
            });
          } else {
            alert('Midtrans Snap tidak tersedia');
            // Kembalikan tombol ke keadaan semula
            button.innerHTML = originalText;
            button.disabled = false;
          }
        } catch (error) {
          console.error('Error:', error);
          alert(error.message || 'Terjadi kesalahan saat memproses pembayaran');
          // Kembalikan tombol ke keadaan semula
          button.innerHTML = originalText;
          button.disabled = false;
        }
      });
    });
  }

  // Function to update payment status
  function updatePaymentStatus(reservationId, status, result) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Validasi reservationId
    if (!reservationId) {
      console.error('Reservation ID is missing or invalid:', reservationId);
      return;
    }

    console.log('Updating payment status for reservation:', reservationId, 'Status:', status);

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
