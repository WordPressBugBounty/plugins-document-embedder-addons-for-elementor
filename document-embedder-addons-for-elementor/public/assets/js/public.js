window.addEventListener("DOMContentLoaded", function () {
  const docs = document.querySelectorAll(".bae-pdf");

  Object.values(docs).map((doc) => {
    loadFrameIfNotLoaded(doc);
  });

  function loadFrameIfNotLoaded(doc) {
    if (!doc) return false;
    const iframe = doc.querySelector("iframe");
    if (iframe && iframe.contentDocument !== null) {
      const source = iframe.src;
      iframe.src = source;
      setTimeout(() => {
        loadFrameIfNotLoaded(doc);
      }, 1500);
    }
  }
  loadFrameIfNotLoaded();
});
