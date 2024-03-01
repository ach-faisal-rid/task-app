ini adalah sistem percobaan jadi masih akan terus di pelajari lagi

untuk menangani auth
1. Endpoint /register diakses melalui metode POST untuk melakukan registrasi.
2. Endpoint /login diakses melalui metode POST untuk melakukan login.
3. Endpoint /user diakses melalui metode GET untuk mendapatkan informasi pengguna saat ini
4. Endpoint /logout diakses melalui metode POST untuk logout user


ini. Route ini dilindungi oleh middleware auth:sanctum, yang menunjukkan bahwa pengguna harus sudah terautentikasi untuk mengaksesnya.
Endpoint /change-password diakses melalui metode POST untuk mengganti kata sandi. Route ini juga dilindungi oleh middleware auth:sanctum.

untuk penanganan task
    1. GET /tasks: Retrieves a list of tasks (index)
    2. GET /tasks/{id}: Retrieves a single task by ID (show)
    3. POST /tasks: Creates a new task (store)
    4. PUT/PATCH /tasks/{id}: Updates an existing task by ID (update)
    5. DELETE /tasks/{id}: Deletes a task by ID (destroy)

Views (Optional):

resources/views/tasks directory:

    1. index.blade.php: Display a list of tasks using the provided data.
    2. create.blade.php: Form to create a new task.
    3. show.blade.php: Display details of a specific task.
    4. edit.blade.php: Form to edit an existing task.


Additional Notes:

 1. Authentication/Authorization: Consider adding authentication and authorization mechanisms to ensure only authorized users can perform specific actions on tasks, depending on your application's requirements.
 2. Error Handling: Implement robust error handling to handle situations like not finding a specific task or potential database errors.
 3. Response Format: You can return your API responses in JSON or XML format instead of redirecting to views if your application doesn't require a full-fledged web interface.

Fitur API:

1. Paginasi: Perkenalkan paginasi untuk membagi daftar tugas menjadi beberapa halaman, memungkinkan navigasi yang lebih mudah untuk kumpulan data yang besar.
2. Filter dan Pencarian: Izinkan pengguna untuk memfilter dan mencari tugas berdasarkan berbagai kriteria seperti judul, deskripsi, status, dan tanggal.
3. Pengurutan: Berikan opsi untuk mengurutkan tugas berdasarkan berbagai kolom seperti waktu pembuatan, waktu pembaruan, dan prioritas.
4. Validasi: Terapkan validasi input yang ketat untuk memastikan data yang dikirimkan dalam permintaan API valid dan aman.

Fitur Tampilan:

1. Tampilan responsif: Buat tampilan yang responsif dan dapat beradaptasi dengan berbagai perangkat dan ukuran layar.
2. Interaksi JavaScript: Gunakan JavaScript untuk menambahkan interaktivitas ke halaman seperti animasi, pemuatan data dinamis, dan konfirmasi sebelum tindakan penting.
3. Komponen UI: Gunakan pustaka UI seperti Bootstrap atau Vue.js untuk mempermudah pembuatan antarmuka pengguna yang menarik dan mudah digunakan.

Keamanan:

 1. Otentikasi: Implementasikan otentikasi pengguna untuk memastikan hanya pengguna yang sah yang dapat mengakses API dan data.
 2. Otorisasi: Tetapkan izin dan peran pengguna untuk mengontrol operasi API mana yang dapat mereka lakukan.
 3. Token API: Gunakan token API untuk mengotorisasi permintaan dan melacak sesi pengguna.

Pengujian:

1. Tulis unit test: Buat unit test untuk memastikan API dan kode backend Anda berfungsi dengan baik.
2. Lakukan integrasi test: Lakukan integrasi test untuk memastikan API dan tampilan Anda berinteraksi dengan benar.
