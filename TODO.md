# TODO - Perbaikan `index.php`

## Rencana

- [x] Rapikan struktur PHP/HTML di `index.php` (hindari embed `<?php ... ?>` yang berpotensi salah tempat).
- [x] Interpretasikan hasil Flask (`random_forest`, `gradient_boosting`, `naive_bayes`, `kmeans_cluster`) menjadi teks.
- [x] Isi `$rf_text`, `$gb_text`, `$nb_text`, `$cluster_text`, dan `$kesimpulan` berdasarkan mapping `1=Premium`, `0=Non-premium`.
- [x] Pastikan progress bar `$score_kenyamanan`, `$score_desain`, `$score_harga` berada di rentang 0-100.
- [x] Tambahkan fallback jika respon Flask null/format tidak sesuai.
