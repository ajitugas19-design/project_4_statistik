Perbaikan index.php

- Memperbaiki error sintaks PHP akibat nested/bentrok <?php ... ?> di area interpretasi hasil Flask.
- Menambahkan interpretasi isi JSON dari Flask:
  - random_forest, gradient_boosting, naive_bayes: mapping 1=Premium, 0=Non-premium
  - kmeans_cluster: heuristic cluster 1 => Premium, cluster lainnya => Non-premium
- Menambahkan voting 2 dari 3 model untuk membuat kesimpulan.
- Menambahkan clamping score ke rentang 0-100.

Validasi: `php -l index.php` => No syntax errors detected.

