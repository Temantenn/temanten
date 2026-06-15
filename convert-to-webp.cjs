const sharp = require('sharp');
const path = require('path');
const fs = require('fs');

const files = [
  'public/assets/bg.png',
  'public/assets/frame-atas.png',
  'public/assets/frame-bawah.png',
  'public/assets/logo.jpg',
  'public/assets/mini-logo.jpg',
  'public/img/qris1.jpeg',
  'public/img/qris.jpeg',
  'public/assets/thumbnail/sunda-asih.png',
  'public/assets/thumbnail/watercolor-flow.png',
  'public/assets/thumbnail/jawa-keraton.png',
  'public/assets/thumbnail/rustic-green.png',
  'public/assets/thumbnail/barakah-love.png',
  'public/assets/thumbnail/golden-sunrise.png',
  'public/assets/thumbnail/emerald-garden.png',
  'public/assets/thumbnail/boho-terracotta.png',
  'public/assets/thumbnail/ocean-breeze.png',
  'public/assets/thumbnail/midnight-garden.png',
  'public/assets/thumbnail/sekar-jagad.png',
  'public/assets/thumbnail/floral-pastel.png',
  'public/assets/thumbnail/celestial-night.png',
  'public/assets/thumbnail/cherry-blossom.png',
  'public/assets/thumbnail/royal-glass.png',
  'public/assets/thumbnail/pixel-adventure.png',
];

async function convertAll() {
  let success = 0;
  let failed = 0;
  const results = [];

  for (const file of files) {
    const inputPath = path.resolve(file);
    const parsed = path.parse(inputPath);
    const outputPath = path.join(parsed.dir, parsed.name + '.webp');

    try {
      if (!fs.existsSync(inputPath)) {
        console.log(`SKIP (not found): ${file}`);
        failed++;
        continue;
      }

      const originalSize = fs.statSync(inputPath).size;
      await sharp(inputPath)
        .webp({ quality: 80 })
        .toFile(outputPath);

      const newSize = fs.statSync(outputPath).size;
      const saving = ((1 - newSize / originalSize) * 100).toFixed(1);
      results.push({ file, original: originalSize, converted: newSize, saving });
      console.log(`OK: ${file} -> ${parsed.name}.webp  (${(originalSize/1024).toFixed(1)}KB -> ${(newSize/1024).toFixed(1)}KB, -${saving}%)`);
      success++;
    } catch (err) {
      console.error(`FAIL: ${file} -> ${err.message}`);
      failed++;
    }
  }

  console.log(`\n=== DONE ===`);
  console.log(`Success: ${success}, Failed: ${failed}`);

  const totalOriginal = results.reduce((s, r) => s + r.original, 0);
  const totalConverted = results.reduce((s, r) => s + r.converted, 0);
  console.log(`Total original:  ${(totalOriginal/1024/1024).toFixed(2)} MB`);
  console.log(`Total converted: ${(totalConverted/1024/1024).toFixed(2)} MB`);
  console.log(`Total saved:     ${((totalOriginal - totalConverted)/1024/1024).toFixed(2)} MB (${((1 - totalConverted/totalOriginal)*100).toFixed(1)}%)`);
}

convertAll();