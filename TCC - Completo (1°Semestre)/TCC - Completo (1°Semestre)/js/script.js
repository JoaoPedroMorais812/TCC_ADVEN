document.addEventListener("DOMContentLoaded", () => {
  const scrollBtn = document.querySelector(".btn-hero");
  if (scrollBtn) {
    scrollBtn.addEventListener("click", (e) => {
      e.preventDefault();
      const target = document.querySelector("#servicos");
      if (target) {
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  }
});
