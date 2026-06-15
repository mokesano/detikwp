#!/bin/bash

# Script untuk modernisasi kode PHP ke standar 8.x+
# Menambahkan: declare(strict_types=1), type hints, return types

echo "🔍 Memulai audit dan modernisasi PHP 8.x+..."

FILES=$(find /workspace -type f -name "*.php" ! -path "*/vendor/*" ! -path "*/node_modules/*" ! -path "*/languages/*" | grep -v index.php)

for file in $FILES; do
    # Skip jika sudah ada declare(strict_types=1)
    if grep -q "declare(strict_types=1)" "$file"; then
        echo "✅ Skip (sudah strict): $file"
        continue
    fi
    
    # Tambahkan declare(strict_types=1) setelah <?php
    if head -1 "$file" | grep -q "<?php"; then
        sed -i '2a\\ndeclare(strict_types=1);' "$file"
        echo "✏️  Added strict_types: $file"
    fi
done

echo "✅ Selesai menambahkan declare(strict_types=1)"
