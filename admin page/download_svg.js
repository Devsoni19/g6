function attachDownloadListeners() {
  document.querySelectorAll(".download-btn").forEach(button => {
    button.addEventListener("click", function () {
      const rowId = this.getAttribute("data-id");
      const imgElement = document.querySelector(`#row-${rowId} .svg-img`);

      if (!imgElement) {
        console.error("SVG image not found!");
        return;
      }

      const svgBase64 = imgElement.getAttribute("data-uri");
      const decodedSvg = atob(svgBase64);

      // Create a Blob from SVG
      const blob = new Blob([decodedSvg], { type: "image/svg+xml" });

      // Create a download link
      const a = document.createElement("a");
      a.href = URL.createObjectURL(blob);
      a.download = `svg_image_${rowId}.svg`;
      document.body.appendChild(a);
      a.click();

      // Cleanup
      document.body.removeChild(a);
      URL.revokeObjectURL(a.href);
    });
  });
}

// Run once after page loads (for static content)
document.addEventListener("DOMContentLoaded", attachDownloadListeners);
