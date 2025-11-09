/*
 * FUNGSI PENCARIAN REAL-TIME
 * Fungsi ini akan dipanggil di setiap halaman yang butuh filter.
 *
 * Cara kerjanya:
 * 1. Ambil teks dari kotak pencarian (inputElementId).
 * 2. Ubah jadi huruf kecil (biar tidak sensitif besar/kecil).
 * 3. Ambil semua item yang mau difilter (itemSelector, misal: semua kartu materi).
 * 4. Looping setiap item.
 * 5. Cek apakah teks di dalam item mengandung teks pencarian.
 * 6. Jika iya, tampilkan (display = 'block' atau 'flex').
 * 7. Jika tidak, sembunyikan (display = 'none').
 */
function siapkanPencarian(inputElementId, itemSelector, displayType = 'block') {
    const input = document.getElementById(inputElementId);
    if (!input) {
        console.error("Elemen input pencarian tidak ditemukan:", inputElementId);
        return;
    }

    const items = document.querySelectorAll(itemSelector);
    if (items.length === 0) {
        console.warn("Tidak ada item yang ditemukan untuk difilter:", itemSelector);
    }

    // Fungsi yang akan dijalankan setiap kali pengguna mengetik
    const filterItems = () => {
        const query = input.value.toLowerCase(); // Ambil teks pencarian

        items.forEach(item => {
            // Ambil seluruh teks di dalam item
            const itemText = item.textContent || item.innerText;
            
            // Cek apakah teks item mengandung query
            if (itemText.toLowerCase().includes(query)) {
                item.style.display = displayType; // Tampilkan jika cocok
            } else {
                item.style.display = 'none'; // Sembunyikan jika tidak cocok
            }
        });
    };

    // Tambahkan event listener 'keyup' (dijalankan setiap kali tombol dilepas)
    input.addEventListener('keyup', filterItems);
}