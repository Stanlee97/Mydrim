const sharp = require("sharp");
const fs = require("fs-extra");
const path = require("path");

const inputFolder = "./images";      // your original images
const outputFolder = "./optimized";  // compressed images

async function compressImages() {
  await fs.ensureDir(outputFolder);

  const files = await fs.readdir(inputFolder);

  for (const file of files) {
    const inputPath = path.join(inputFolder, file);
    const outputPath = path.join(outputFolder, file.replace(/\.(jpg|jpeg|png)/, ".webp"));

    await sharp(inputPath)
      .resize({ width: 1200 }) // resize large images
      .webp({ quality: 70 })   // compress
      .toFile(outputPath);

    console.log(`Compressed: ${file}`);
  }

  console.log("✅ Done!");
}

compressImages();

