const keranjang = {};
const keranjangList = document.getElementById("keranjang-list");
const subtotalDisplay = document.getElementById("subtotal-display");
const subtotalAfterDpDisplay = document.getElementById(
    "subtotalAfterDpDisplay"
);
const kembalianDisplay = document.getElementById("kembalianDisplay");
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const dpDisplay = document.getElementById("dpDisplay");
const idReservasiSelect = document.getElementById("id_reservasi");
const metodePembayaranSelect = document.getElementById("id_metode_pembayaran");
const jumlahBayarInput = document.getElementById("jumlahBayar");

let dpValue = 0; // Nilai DP yang aktif

document.addEventListener("DOMContentLoaded", function () {
    const btnReset = document.getElementById("btn-reset-keranjang");

    btnReset.addEventListener("click", function () {
        const adaIsiKeranjang = Object.keys(keranjang).length > 0;

        if (!adaIsiKeranjang) {
            Swal.fire({
                icon: "info",
                title: "Keranjang Kosong 😅",
                text: "Belum ada item yang ditambahkan.",
                confirmButtonText: "Oke deh",
                confirmButtonColor: "#3085d6",
            });
            return;
        }

        Swal.fire({
            title: "Yakin mau reset?",
            text: "Semua item di keranjang akan dihapus.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, kosongkan!",
            cancelButtonText: "Batal aja",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
        }).then((result) => {
            if (result.isConfirmed) {
                keranjangList.innerHTML = "";
                subtotalDisplay.textContent = "0";

                document
                    .querySelectorAll('[id^="qty-display-"]')
                    .forEach((el) => {
                        el.textContent = "0";
                    });

                // Kosongkan keranjang global
                for (const id in keranjang) {
                    delete keranjang[id];
                }

                Swal.fire({
                    icon: "success",
                    title: "Keranjang dikosongkan!",
                    text: "Silakan pilih menu baru 😊",
                    confirmButtonColor: "#28a745",
                });
            }
        });
    });
});

function updateKeranjang() {
    keranjangList.innerHTML = "";
    let total = 0;

    for (const id in keranjang) {
        const item = keranjang[id];
        const subtotal = item.qty * item.harga;
        total += subtotal;

        keranjangList.innerHTML += `
            <div class="d-flex mb-3">
                <div style="width: 48px; height: 48px; overflow: hidden;" class="rounded me-2 mr-2">
                    <img src="${
                        item.image
                    }" style="width: 100%; height: 100%; object-fit: cover;" class="rounded" alt="${
            item.nama
        }">
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold text-dark" style="line-height: 1.2;">
                        ${item.nama}
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>x${item.qty}</span>
                        <span>Rp ${item.harga.toLocaleString("id-ID")}</span>
                    </div>
                </div>
            </div>
        `;

        const qtyDisplayElem = document.getElementById(`qty-display-${id}`);
        if (qtyDisplayElem) {
            qtyDisplayElem.textContent = item.qty;
        }
    }

    // Update subtotal di keranjang (tidak dipengaruhi DP)
    subtotalDisplay.textContent = total.toLocaleString("id-ID");

    document.getElementById("modal-subtotal-hidden").value = total;

    updateModalSubtotalAfterDP(total);
}

function updateModalSubtotalAfterDP(subtotal) {
    const totalAfterDp = subtotal - dpValue;
    subtotalAfterDpDisplay.value = `Rp ${(totalAfterDp > 0
        ? totalAfterDp
        : 0
    ).toLocaleString("id-ID")}`;

    // Sesuaikan jumlah bayar input kalau metode pembayaran bukan tunai (id 1)
    if (metodePembayaranSelect.value !== "1") {
        jumlahBayarInput.value = totalAfterDp > 0 ? totalAfterDp : 0;
        jumlahBayarInput.setAttribute("readonly", "readonly");
    } else {
        jumlahBayarInput.value = "";
        jumlahBayarInput.removeAttribute("readonly");
    }

    // Update kembalian sesuai input jumlah bayar
    updateKembalian();
}

function updateKembalian() {
    const jumlahBayar = parseInt(jumlahBayarInput.value) || 0;
    const subtotal =
        parseInt(document.getElementById("modal-subtotal-hidden").value) || 0;
    const totalBayar = subtotal - dpValue;
    const kembalian = jumlahBayar - (totalBayar > 0 ? totalBayar : 0);
    kembalianDisplay.textContent =
        kembalian >= 0 ? kembalian.toLocaleString("id-ID") : 0;
}

// Event handler tombol tambah
document.querySelectorAll(".btn-tambah").forEach((btn) => {
    btn.addEventListener("click", function () {
        const id = this.dataset.id;
        const nama = this.dataset.nama;
        const harga = parseInt(this.dataset.harga);
        const image = this.dataset.image;
        const stok = parseInt(this.dataset.stok); // Ambil stok dari data attribute

        if (stok <= 0) {
            Swal.fire({
                icon: "error",
                title: "Stok Habis",
                text: `Menu "${nama}" sedang tidak tersedia.`,
                confirmButtonColor: "#d33",
            });
            return; // Hentikan eksekusi jika stok habis
        }

        // Jika stok masih ada, lanjut tambah ke keranjang
        if (keranjang[id]) {
            if (keranjang[id].qty >= stok) {
                Swal.fire({
                    icon: "warning",
                    title: "Stok Tidak Cukup",
                    text: `Jumlah item "${nama}" sudah mencapai stok maksimum (${stok})`,
                    confirmButtonColor: "#d33",
                });
                return;
            } else {
                keranjang[id].qty++;
            }
        } else {
            if (stok > 0) {
                keranjang[id] = { nama, harga, image, qty: 1 };
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Stok Habis",
                    text: `Menu "${nama}" sedang tidak tersedia.`,
                    confirmButtonColor: "#d33",
                });
                return;
            }
        }
        updateKeranjang();
    });
});

// Event handler tombol kurang
document.querySelectorAll(".btn-kurang").forEach((btn) => {
    btn.addEventListener("click", function () {
        const id = this.dataset.id;
        if (keranjang[id]) {
            keranjang[id].qty--;
            if (keranjang[id].qty <= 0) {
                delete keranjang[id];
                const qtyDisplayElem = document.getElementById(
                    `qty-display-${id}`
                );
                if (qtyDisplayElem) {
                    qtyDisplayElem.textContent = "0";
                }
            }
            updateKeranjang();
        }
    });
});

// Event ketika memilih reservasi (update dpValue dan tampilkan DP)
idReservasiSelect.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    dpValue = parseInt(selectedOption.getAttribute("data-dp")) || 0;

    dpDisplay.value = `Rp ${dpValue.toLocaleString("id-ID")}`;

    // Update total bayar setelah DP di modal
    updateModalSubtotalAfterDP(
        parseInt(document.getElementById("modal-subtotal-hidden").value) || 0
    );
});

// Event ketika metode pembayaran berubah
metodePembayaranSelect.addEventListener("change", function () {
    updateModalSubtotalAfterDP(
        parseInt(document.getElementById("modal-subtotal-hidden").value) || 0
    );
});

// Event input jumlah bayar update kembalian
jumlahBayarInput.addEventListener("input", updateKembalian);

// Tombol simpan transaksi buka modal pembayaran
document.getElementById("btn-simpan").addEventListener("click", function () {
    if (Object.keys(keranjang).length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Oops!",
            text: "Keranjang masih kosong!",
            confirmButtonText: "OK",
        });
        return;
    }

    // Reset dpValue dari pilihan reservasi (jika ada)
    dpValue =
        parseInt(
            idReservasiSelect.options[
                idReservasiSelect.selectedIndex
            ]?.getAttribute("data-dp")
        ) || 0;

    // Update modal subtotal after DP sebelum buka modal
    updateModalSubtotalAfterDP(
        parseInt(document.getElementById("modal-subtotal-hidden").value) || 0
    );

    const modal = new bootstrap.Modal(
        document.getElementById("modalPembayaran")
    );
    modal.show();
});

// Submit form modal pembayaran
document.getElementById("form-modal").addEventListener("submit", function (e) {
    e.preventDefault();

    const jumlahBayar = Number(jumlahBayarInput.value);
    const subtotal = Number(
        document.getElementById("modal-subtotal-hidden").value
    );
    const totalBayar = subtotal - dpValue;
    const idMetodePembayaran = metodePembayaranSelect.value;

    if (!idMetodePembayaran) {
        return Swal.fire({
            icon: "warning",
            title: "Oops!",
            text: "Pilih metode pembayaran terlebih dahulu!",
            confirmButtonText: "OK",
        });
    }

    if (isNaN(jumlahBayar) || jumlahBayar < totalBayar) {
        return Swal.fire({
            icon: "warning",
            title: "Jumlah tidak cukup!",
            text: `Minimal Rp ${totalBayar.toLocaleString("id-ID")}`,
            confirmButtonText: "OK",
        });
    }

    const formData = new FormData();
    formData.append("_token", csrfToken);
    formData.append("id_user", document.getElementById("id_user")?.value ?? "");
    formData.append("id_reservasi", idReservasiSelect.value);
    formData.append(
        "id_member",
        document.getElementById("id_member")?.value ?? ""
    );
    formData.append("tgl", document.getElementById("tgl")?.value ?? "");
    formData.append("id_metode_pembayaran", idMetodePembayaran);
    formData.append("jumlah_bayar", jumlahBayar);
    formData.append("kembalian", jumlahBayar - totalBayar);
    formData.append("dp_reservasi", dpValue);

    // Kirim data menu
    Object.entries(keranjang).forEach(([id, item]) => {
        formData.append("menu_id[]", id);
        formData.append("qty[]", item.qty);
        formData.append("harga_satuan[]", item.harga);
    });

    fetch("/kasir/order", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (!response.ok) throw new Error("Gagal menyimpan order");
            return response.text();
        })
        .then((orderId) => {
            
            Swal.fire({
                icon: "success",
                title: "Transaksi berhasil!",
                text: "Apa yang ingin Anda lakukan?",
                showCancelButton: true,
                confirmButtonText: "Cetak Struk",
                cancelButtonText: "Selesai",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`/order/receipt/${orderId}`, "_blank");
                }

                // Reset transaksi dan tutup modal tetap dijalankan di kedua kondisi
                resetTransaksiUI();
                refreshStokView();
            });

            // Tutup modal
            bootstrap.Modal.getInstance(
                document.getElementById("modalPembayaran")
            ).hide();
        })
        .catch((error) => {
            Swal.fire("Gagal", error.message, "error");
        });
});

function resetTransaksiUI() {
    // Kosongkan keranjang
    for (const id in keranjang) {
        delete keranjang[id];
    }

    // Kosongkan tampilan keranjang
    keranjangList.innerHTML = "";

    // Reset display subtotal, DP, dan kembalian
    subtotalDisplay.textContent = "0";
    subtotalAfterDpDisplay.value = "Rp 0";
    kembalianDisplay.textContent = "0";
    dpDisplay.value = "Rp 0";

    // Reset input form
    jumlahBayarInput.value = "";
    jumlahBayarInput.removeAttribute("readonly");
    document.getElementById("modal-subtotal-hidden").value = 0;

    // Reset dropdown atau form lainnya jika perlu
    idReservasiSelect.selectedIndex = 0;
    metodePembayaranSelect.selectedIndex = 0;

    // Tampilkan ulang kuantitas = 0 untuk semua item di UI
    document.querySelectorAll('[id^="qty-display-"]').forEach((elem) => {
        elem.textContent = "0";
    });
}

function refreshStokView() {
    fetch(STOK_API_URL)
        .then((response) => response.json())
        .then((data) => {
            data.forEach((menu) => {
                const tambahBtn = document.querySelector(
                    `.btn-tambah[data-id="${menu.id}"]`
                );
                const card = tambahBtn?.closest(".menu-card");
                const stokElem = card?.querySelector(".menu-card-stock strong");
                const imgElem = card?.querySelector("img");
                const overlay = card?.querySelector(".overlay-stock-habis");

                if (!card || !stokElem || !imgElem || !tambahBtn) return;

                stokElem.textContent = menu.stok;

                if (menu.stok <= 0) {
                    tambahBtn.disabled = true;
                    imgElem.style.filter = "blur(3px) brightness(0.6)";
                    if (!overlay) {
                        const overlayDiv = document.createElement("div");
                        overlayDiv.className = "overlay-stock-habis";
                        overlayDiv.innerText = "Stock Habis";
                        card.appendChild(overlayDiv);
                    }
                } else {
                    tambahBtn.disabled = false;
                    imgElem.style.filter = "";
                    if (overlay) overlay.remove();
                }

                // Update data-stok juga supaya validasi selanjutnya akurat
                tambahBtn.setAttribute("data-stok", menu.stok);
            });
        })
        .catch((error) => {
            console.error("Gagal memuat stok terbaru:", error);
        });
}

//filter kategory dan search menu
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const menuItems = document.querySelectorAll(".menu-item");

function filterMenu() {
    const searchValue = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter.value.toLowerCase();

    menuItems.forEach((item) => {
        const namaMenu = item.dataset.nama.toLowerCase();
        const kategoriMenu = item.dataset.kategori.toLowerCase();

        // Cek kecocokan pencarian dan kategori
        const matchesSearch = namaMenu.includes(searchValue);
        const matchesCategory =
            selectedCategory === "" || kategoriMenu === selectedCategory;

        if (matchesSearch && matchesCategory) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
}

// Pasang event listener
searchInput.addEventListener("input", filterMenu);
categoryFilter.addEventListener("change", filterMenu);
